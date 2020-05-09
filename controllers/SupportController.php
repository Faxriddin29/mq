<?php

namespace app\controllers;

use app\models\Indigent;
use app\models\Product;
use app\models\Support;
use app\models\Supportings;
use app\models\SupportingsSearch;
use app\models\SupportProduct;
use InvoiceGenerator;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SupportController implements the CRUD actions for Support model.
 */
class SupportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Support models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupportingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $readyInvoices = Supportings::find()
            ->where(['=', 'app_status', Support::STATUS_NOT_GENERATED])
            ->andWhere(['=', 'status', Indigent::ON_PROCESS])
            ->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'readyInvoices' => $readyInvoices
        ]);
    }

    /**
     * Displays a single Support model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApplySupport()
    {
        $request = Yii::$app->request->post();
        $products = Product::find()->where(['>', 'amount', 0])->all();
        return Yii::$app->controller->renderAjax('_partial/_choose_product', ['products' => $products]);
    }

    /**
     * Deletes an existing Support model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $support = Support::findOne($id);
            $indigent = Indigent::findOne($support->indigent_id);
            $indigent->status = Indigent::NOT_CONFIRMED;
            $indigent->save();
            $support->delete();

            $transaction->commit();
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return Yii::$app->session->setFlash('error', 'O`chirib bo`lmadi');
        }
    }

    /**
     * Finds the Support model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Supportings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supportings::find()->where(['=', 'id', $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionOnProcess()
    {
        $request = Yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($request['products']) && is_array($request['products']) && count($request['products']) > 0) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $not_confirmed = [];
                foreach ($request['rows'] as $row) {

                    $indigent = Indigent::findOne($row['indigent_id']);
                    if ($indigent->status === Indigent::CONFIRMED) {

                        foreach ($request['products'] as $product) {

                            $db->createCommand()->insert('support_product', [
                                'support_id' => $row['support_id'],
                                'indigent_id' => $row['indigent_id'],
                                'product_id' => $product['id'],
                                'amount' => $product['amount'],
                                'created_at' => date('Y-m-d H:i:s')
                            ])->execute();

                            $tempProduct = Product::findOne($product['id']);

                            if (!$tempProduct) {
                                $transaction->rollBack();
                                return [
                                    'success' => false,
                                    'message' => "{$product['id']} IDli mahsulot topilmadi! Iltimos, tekshirib ko`ring."
                                ];
                            }

                            $tempProduct->amount -= $product['amount'];
                            $tempProduct->save();
                        }

                        $db->createCommand()->update('indigent', [
                            'status' => Indigent::ON_PROCESS
                        ], "id=:id")
                            ->bindValue(':id', $row['indigent_id'])
                            ->execute();

                    } else {
                        $not_confirmed[] = $indigent->id;
                    }
                }

                $transaction->commit();
                $message = 'Bajarildi!';
                $message .= count($not_confirmed) > 0 ? ' Quyidagi IDli arizachilar tasdiqlangan statusga ega bo`lmaganligi sababli ularga mahsulot yozilmadi. IDlar: ' . implode(', ', $not_confirmed) : '';
                return [
                    'code' => 200,
                    'success' => true,
                    'message' => $message
                ];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return [
                    'code' => 422,
                    'success' => false,
                    'message' => 'Ma`lumot saqlanmadi! Sabab: ' . $e->getMessage()
                ];
            }
        } else {
            return [
                'code' => 422,
                'success' => false,
                'message' => 'Mahsulot(lar) tanlanmagan!'
            ];
        }
    }

    private function getInvoices(array $clients, array $products)
    {
        $clientsArray = Support::find()->where(['in','id', $clients])->all();
        $productsArray = Product::find()->where(['in', 'id', $products])->all();

        $invoice = new InvoiceGenerator($clientsArray, $productsArray);
        return $invoice->generateInvoice();
    }
}

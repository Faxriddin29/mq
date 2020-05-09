<?php

namespace app\controllers;

use app\models\Support;
use Yii;
use app\models\Indigent;
use app\models\ApplicantSearch;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ApplicantController implements the CRUD actions for Indigent model.
 */
class ApplicantController extends Controller
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
     * Lists all Indigent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Indigent models.
     * @return mixed
     */
    public function actionPendingConfirmation()
    {
        $searchModel = new ApplicantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Indigent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Indigent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Indigent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Indigent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Indigent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Indigent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Indigent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Indigent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionConfirmApplicants()
    {
        $request = Yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        // TODO: validate parameters
        if ($request['rows'] && count($request['rows']) > 0) {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $supports = Indigent::find()
                ->where(['in', 'id', $request['rows']])
                ->all();//return Support::find()->where(['=', 'indigent_id', $supports[0]->id])->exists();
            if ($request['status'] === Indigent::CONFIRMED) {
                try {
                    $deniedUsers = [];
                    foreach ($supports as $support) {
                        if (!Support::find()->where(['=', 'indigent_id', $support->id])->exists()) {
                            $connection->createCommand()->insert('support', [
                                'indigent_id' => $support->id,
                                'date' => date('Y-m-d'),
                                'app_status' => Support::STATUS_NOT_GENERATED
                            ])->execute();
                            $support->status = Indigent::CONFIRMED;
                            $support->save();
                        } else {
                            $deniedUsers[] = $support->id;
                        }
                    }

                    $transaction->commit();
                    $message = "Arizachi(lar) mahsulot yuboriluvchilar ro`yxatiga qo`shildi!";
                    $message .= count($deniedUsers) > 0 ?  " \nQuyidagi foydalanuvchilar support da mavjudligi sababli qaytarib yuborildi:\n" . implode(', ', $deniedUsers) : "";
                    return [
                        'code' => 200,
                        'success' => true,
                        'message' => $message
                    ];
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return [
                        'code' => 200,
                        'success' => false,
                        'message' => 'Arizachi(lar)ni ro`yxatga qo`shib bo`lmadi! Sabab: ' . $exception->getMessage()
                    ];
                }
            } else if ($request['status'] === Indigent::REJECTED) {
                try {
                    foreach ($supports as $support) {
                        $support->status = Indigent::REJECTED;
                        $support->save();
                    }

                    $transaction->commit();
                    return [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Arizachi(lar) arizasi rad etildi!'
                    ];
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return [
                        'code' => 200,
                        'success' => false,
                        'message' => 'Rad etishda xatolik! Sabab: ' . $exception->getMessage()
                    ];
                }
            }
        }
        return [
            'code' => 200,
            'success' => false,
            'message' => 'Ariza tanlanmagan!'
        ];
    }
}

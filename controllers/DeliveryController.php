<?php

namespace app\controllers;

use app\models\ApplicantSearch;
use app\models\Indigent;
use app\models\Support;
use app\models\SupportingsSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeliveryController extends \yii\web\Controller
{
    /**
     * Lists all Indigent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupportingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Indigent::ON_PROCESS);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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

    public function actionDelivered()
    {
        if (Yii::$app->request->isAjax) {
            $request = Yii::$app->request->post('ids');
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (count($request) > 0) {
                $model = Indigent::find()->where(['in', 'id', $request])->all();
                if (count($model) > 0) {
                    $connection = Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        foreach ($model as $item) {
                            $item->status = Indigent::DELIVERED;
                            $item->save();
                        }

                        $transaction->commit();
                        return [
                            'success' => true,
                            'message' => 'Done',
                            'data' => $model
                        ];
                    } catch (\Exception $exception) {
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'message' => $exception->getMessage()
                        ];
                    }
                }
                return [
                    'success' => false,
                    'message' => 'Arizachi(lar) topilmadi!'
                ];
            }
            return [
                'success' => false,
                'message' => 'Error',
                'data' => $request
            ];
        }
        return 'Request is not Ajax';
    }
}

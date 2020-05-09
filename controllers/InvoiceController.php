<?php

namespace app\controllers;

use app\models\Indigent;
use app\models\Support;
use app\models\SupportingsSearch;
use Yii;
use PhpOffice\PhpWord\TemplateProcessor;
use yii\web\Response;

class InvoiceController extends \yii\web\Controller
{
    public function actionInvoice()
    {
        $searchModel = new SupportingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Indigent::ON_PROCESS);
        $readyInvoices = Support::find()->where(['=', 'app_status', Support::STATUS_NOT_GENERATED])->count();

        return $this->render('invoice', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'readyInvoices' => $readyInvoices
        ]);
    }

    public function actionApplication()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $ids = Yii::$app->request->post('ids');
            if (count($ids) === 0) {
                return [
                    'success' => false,
                    'message' => 'Arizachi(lar) tanlanmagan!'
                ];
            }

            $supportings = Support::find()->where(['=', 'app_status', Support::STATUS_NOT_GENERATED])->andWhere(['in', 'indigent_id', $ids])->all();

            if (count($supportings) > 0) {
                $hasNotProducts = [];
                foreach ($supportings as $supporting) {
                    if (count($supporting->supportProducts) === 0) {
                        $hasNotProducts[] = $supporting->indigent->first_name . ' ' . $supporting->indigent->last_name;
                    }
                }
                if (count($hasNotProducts) > 0) {
                    return [
                        'success' => false,
                        'message' => implode(', ', $hasNotProducts) . '(lar)ga mahsulot biriktirilmagan. Iltimos, arizachi(lar)ga mahsulot bering!'
                    ];
                }

                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    $files = [];
                    foreach ($supportings as $item) {
                        $products = $item->supportProducts;
                        $countProducts = count($products);

                        $fio = $item->indigent->last_name . ' ' . $item->indigent->first_name . ' ' . $item->indigent->middle_name;
                        $application = new TemplateProcessor(Yii::getAlias('@app/web/docs/templates/') . 'application.docx');
                        $application->setValue('date', date('d.m.Y'));
                        $application->setValue('fio', $fio);
                        $application->setValue('address', $item->indigent->address);
                        $application->setValue('phone', $item->indigent->phone);



                        if ($countProducts > 0) {
                            $application->cloneRow('num', $countProducts);

                            $iteration = 0;
                            foreach ($products as $datum) {
                                $iteration++;
                                $application->setValue('num#'.$iteration, $iteration);
                                $application->setValue('name#'.$iteration, $datum->product->name_uz);
                                $application->setValue('measurement#'.$iteration, $datum->product->unit);
                                $application->setValue('weight#'.$iteration, $datum->amount);
                            }
                        }

                        $path = Yii::getAlias('@app/web/docs/applications/') . date('d.m.Y');
                        if (!file_exists($path) && !mkdir($path, 0777) && !is_dir($path)) {
                            throw new \RuntimeException(sprintf('"%s" papka yaratilmagan', $path));
                        }

                        $application->saveAs(Yii::getAlias('@app/web/docs/applications/') . date('d.m.Y') . '/'. $fio .'_'. $item->id . '_' . date('d-m-Y').'.docx');

                        $connection->createCommand()->update('support', [
                            'app_status' => Support::STATUS_GENERATED
                        ], 'id = :id')->bindValue(':id', $item->id)->execute();

                        $files[] = $path;
                    }

                    $transaction->commit();
                    return [
                        'success' => true,
                        'message' => 'Ariza yaratilgan!',
                        'data' => $files
                    ];
                } catch (\Exception $exception) {
                    foreach ($supportings as $item) {
                        $file = Yii::getAlias('@web/docs/applications/'). date('d.m.Y H:i:s') . '/'. $fio .'_'. $item->id . '_' . date('d-m-Y').'.docx';
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'message' => $exception->getMessage()
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Arizachi topilmadi'
            ];
        }

        return 'Request is not Ajax';
    }

    public function actionInvoices()
    {
        return $this->render('show_files');
    }

}

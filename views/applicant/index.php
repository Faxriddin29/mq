<?php

use app\models\Indigent;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Arizachilar');
$this->params['breadcrumbs'][] = $this->title;

$status = [
        '' => 'Tanlang',
        Indigent::CONFIRMED => 'Tasdiqlangan',
        Indigent::REJECTED => 'Rad etilgan'
];
?>
<div class="indigent-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-2">
                <?= Html::a(Yii::t('app', 'Yangi qo`shish'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-2 col-md-offset-8">
            <?= Html::dropDownList('status-dropdown', 'id', $status, [
                'class' => 'form-control',
                'id' => 'status-select'
            ]) ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'first_name',
            'middle_name',
            'last_name',
            'phone',
            'address',
//            'support_type',
            //'support_regularity_type',
            //'support_days',
            [
                    'attribute' => 'status',
                'value' => function ($model) {
                    $status = $model->status;
                    switch ($status) {
                        case '0':
                            return '<div class="status-box" data-id="0"><span class="text-info indigent-status">Tasdiqlanmagan</span></div>';
                        case '1':
                            return '<div class="status-box" data-id="1"><span class="text-warning indigent-status">Yuborish jarayonida</span></div>';
                        case '2':
                            return '<div class="status-box" data-id="2"><span class="text-success indigent-status">Yuborilgan</span></div>';
                        case '3':
                            return '<div class="status-box" data-id="3"><span class="text-danger indigent-status">Rad etilgan</span></div>';
                        case '4':
                            return '<div class="status-box" data-id="4"><span class="text-success indigent-status">Tasdiqlangan</span></div>';
                    }
                    return '---';
                },
                'filter' => [
                        Indigent::NOT_CONFIRMED => 'Tasdiqlanmagan',
                        Indigent::REJECTED => 'Rad etilgan',
                ],
                'format' => 'raw'
            ],
            [
                'class' => \yii\grid\CheckboxColumn::class,
                'cssClass' => 'form-check-input'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
<?php
$script = <<< JS
$(document).ready(function(){
                $('#status-select').on('change', function (e) {
                let val = e.target.value;
                let selected = $('#w0').yiiGridView('getSelectedRows');console.log(val, selected)
                let csrfToken = $('meta[name="csrf - token"]').attr("content");
                if (val) {
                if (selected.length > 0) {
                    $.ajax({
                        url: 'applicant/confirm-applicants',
                        type: 'POST',
                        data: {
                            _csrf: csrfToken, 
                            status: val,
                            rows: selected
                        },
                        success: function (res) {
                            console.log(res);
                            if (res.success) {
                                toastr.success(res.message, '', {timeOut: 5000, extendedTimeout: 3000})
                            } else {
                                toastr.error(res.message, '', {timeOut: 5000, extendedTimeout: 3000})
                            }
                            setTimeout(function () {window.location.reload();}, 2000)
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                } else {
                    toastr.error('Ariza tanlanmagan! Iltimos, arizani tanlang')
                }
                }
            });
            });
JS;

$this->registerJs($script, \yii\web\View::POS_END)
?>

<?php

use app\models\Indigent;
use app\models\Support;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Akt yaratish');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button id="generate_invoice" class="btn btn-primary">Akt yaratish</button>
        <?= Html::a(Yii::t('app', 'Aktni ko`rish'), ['/invoice/invoices'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'first_name',
            'last_name',
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return date('d-m-Y', strtotime($model->date));
                },
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'format' => 'html'
            ],
            'support_days',
            [
                'attribute' => 'support_type',
                'filter' => [Support::SUPPORT_ONCE => 'Bir martalik', Support::SUPPORT_REGULAR => 'Muntazam'],
                'value' => function ($model) {
                    return $model->support_type === Support::SUPPORT_ONCE ? '<span class="text-success">Bir martalik</span>' : '<span class="text-warning">Muntazam</span>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'status',
                'value' => static function ($model) {
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
                    Indigent::DELIVERED => 'Yuborilgan',
                    Indigent::ON_PROCESS => 'Yuborish jarayonida',
                    Indigent::CONFIRMED => 'Tasdiqlangan'
                ],
                'format' => 'raw'
            ],
            [
                'attribute' => 'app_status',
                'value' => static function ($model) {
                    $status = $model->app_status;
                    return $status === '1' ? '<div class="status-box" data-id="0"><span class="text-info indigent-status">Yaratilgan</span></div>' :
                                            '<div class="status-box" data-id="1"><span class="text-warning indigent-status">Yaratilmagan</span></div>';
                },
                'filter' => [
                    Support::STATUS_GENERATED => 'Yaratilgan',
                    Support::STATUS_NOT_GENERATED => 'Yaratilmagan'
                ],
                'format' => 'raw'
            ],
            [
                'class' => \yii\grid\CheckboxColumn::class,
                'cssClass' => 'form-check-input',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->support_id, 'data-indigent' => $model->id];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => static function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/support/view?id=' . $model->id],
                            ['class' => 'label btn-success',
                                'title' => 'Ko`rish',
                                'aria-label' => 'Ko`rish',

                            ]);

                    },
                    'delete' => static function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/support/delete', 'id' => $model->id],
                            [
                                'class' => 'label btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'O`chirilsinmi ?'),
                                    'method' => 'post',
                                ],
                                'title' => 'O`chirish',
                                'aria-label' => 'O`chirish',

                            ]);
                    }

                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?php
$script = <<< JS
$("#generate_invoice").on('click', function() {
    let selected = [];
    $('input:checkbox[class="form-check-input"]:checked').map((i, val) => {
        selected.push(val.dataset.indigent);
    });
  if (selected.length > 0) {
      $.ajax({
        url: '/invoice/application',
        type: 'post',
        data: {ids: selected},
        success: function(res) {
          if (res.success) {
              toastr.success(res.message);
              setTimeout(function() {
                window.location.reload();
              }, 2000);
          } else {
              toastr.error(res.message);
          }
        },
        error: function(err) {
          console.log(err);
        }
      });
  } else {
      toastr.error('Arizachi(lar) tanlanmagan!')
  }
})
JS;

$this->registerJs($script, \yii\web\View::POS_END);
?>

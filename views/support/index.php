<?php

use app\models\Indigent;
use app\models\Support;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SupportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Supports');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("
    #supportModal .modal-dialog {width: 50%; }
");
?>
<div class="support-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button id="choose-product" class="btn btn-primary">Mahsulot tanlash</button>
        <?php if ($readyInvoices > 0): ?>
<!--            <button id="generate_invoice" class="btn btn-warning">Akt chiqarish <span class="badge badge-success">--><?//= $readyInvoices ?><!--</span></button>-->
            <?= Html::a(Yii::t('app', 'Akt chiqarish <span class="badge badge-success">'. $readyInvoices .'</span>'), ['/invoice/invoice'], ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>
    </p>

    <?php Pjax::begin(); ?>

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
                        Indigent::DELIVERED => 'Yuborilgan',
                        Indigent::ON_PROCESS => 'Yuborish jarayonida',
                        Indigent::CONFIRMED => 'Tasdiqlangan'
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
                            'view' => function ($url, $model, $key) {
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

<!-- Modal -->
<div id="supportModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close support-modal-close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mahsulot tanlash</h4>
            </div>
            <div class="modal-body" id="support-modal-body">

            </div>
            <div class="modal-footer">
                <button type="button"
                        id="send-support"
                        class="btn btn-primary"
                >Tasdiqlash</button>
            </div>
        </div>

    </div>
</div>
<?php
$script = <<< JS
function convert_HTML_ToPDF(html) {
    let doc = new jspdf();
    
    doc.fromHTML(html, 400, 250);
    
    doc.save('invoice.pdf');
}
$(document).ready(function(){
        $('.support-modal-close').on('click', function () {
            $('#support-modal-body').html('');
        });
        $('#choose-product').on('click', function (e) {
            let selected = [];
            $('input:checkbox[class="form-check-input"]:checked').map((i, val) => {
                selected.push({
                    support_id: val.value,
                    indigent_id: val.dataset.indigent
                })
            });
            
            if (selected.length > 0) {
            window.localStorage.setItem('rows', JSON.stringify(selected));
                let csrfToken = yii.getCsrfToken();
               $.ajax({
                   url: '/support/apply-support',
                   type: 'POST',
                   data: {
                        _csrf: csrfToken,
                        rows: selected
                   },
                   success: function (res) {
                        let body = $('#support-modal-body');
                        body.html('');
                        body.html(res);
                        $('#supportModal').modal('show');
                    },
                    error: function (err) {
                        console.log(err);
                    }
               });
            } else {
                toastr.error('Arizachi(lar) tanlanmagan!');
            }
        });
        
        $(document).on('change', '.support-checkbox', function () {
            let checkbox = $(this);
            if (checkbox.prop('checked')) {
                checkbox.parent().parent().find('.product-qty').attr('readonly', false);
            } else {
                checkbox.parent().parent().find('.product-qty').attr('readonly', true);
            }
        });
        
        $(document).on('click', '#send-support', function () {
            let products = [];
            $('.product-qty').map((i, val) => {
                (val.value !== '' && val.dataset.product && val.dataset.product > 0) ? products.push({
                    id: val.dataset.product,
                    amount: val.value
                }) : '';
            });
            if (products.length > 0) {
            let csrfToken = yii.getCsrfToken();
            let selected = [];
            selected = window.localStorage.getItem('rows');
            $.ajax({
                url: '/support/on-process',
                type: 'POST',
                data: {
                    _csrf: csrfToken,
                    products: products,
                    rows: JSON.parse(selected)
                },
                success: function (res) {
                   if (res.success) {
                       toastr.success(res.message)
                   } else {
                       toastr.error(res.message)
                   }
                   setTimeout(function () {window.location.reload();}, 2000);
                },
                error: function (err) {
                    console.log(err);
                }
            });
            } else {
                toastr.error('Mahsulot tanlanmagan yoki miqdori ko`rsatilmagan!');
            }
        });
        });
        
        // var modal = document.getElementById('support-modal-body');
        // window.onclick = function(event) {
        //     if (event.target === modal) {
        //         modal.innerHTML = '';
        //     }
        // };
JS;

$this->registerJs($script,
    \yii\web\View::POS_END
    );
?>

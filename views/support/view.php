<?php

use app\models\Indigent;
use app\models\Support;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Supports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="support-view">

    <h1><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'middle_name',
            'last_name',
            'support_days',
            [
                'attribute' => 'support_type',
                'filter' => [Support::SUPPORT_ONCE => 'Bir martalik', Support::SUPPORT_REGULAR => 'Muntazam'],
                'value' => function ($model) {
                    return $model->support_type === Support::SUPPORT_ONCE ? '<span class="text-success">Bir martalik</span>' : '<span class="text-warning">Muntazam</span>';
                },
                'format' => 'html'
            ],
            'address',
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
                    'format' => 'html'
            ],
            'date',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indigent */

$this->title = Yii::t('app', 'Arizachi ma`lumotini yangilash: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arizachilar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'O`zgartirish');
?>
<div class="indigent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

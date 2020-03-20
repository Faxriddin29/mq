<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indigent */

$this->title = Yii::t('app', 'Update Indigent: {name}', [
    'name' => $model->first_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Indigents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="indigent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

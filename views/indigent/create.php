<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indigent */

$this->title = Yii::t('app', 'Create Indigent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Indigents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indigent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

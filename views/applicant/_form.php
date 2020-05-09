<?php

use app\models\Indigent;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Indigent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indigent-form">

  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    </div>
  </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

  <div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'support_type')->dropDownList([ 'regular' => 'Doimiy', 'once' => 'Bir martalik', ], ['prompt' => '']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'support_regularity_type')->dropDownList([ 'week_days' => 'Hafta kunlarida', 'dates_of_the_month' => 'Oyning bazi kunlarida', ], ['prompt' => '']) ?>
    </div>
      <div class="col-md-3">
          <?= $form->field($model, 'status')->dropDownList([ Indigent::NOT_CONFIRMED => 'Tasdiqlanmagan', Indigent::CONFIRMED => 'Tasdiqlangan' ], ['prompt' => '']) ?>
    </div>
  </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'support_days')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

  <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

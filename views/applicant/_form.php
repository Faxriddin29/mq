<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Indigent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indigent-form">

  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    </div>
  </div>
  <!--    --><? //= $form->field($model, 'support_type')->dropDownList([ 'regular' => 'Regular', 'once' => 'Once', ], ['prompt' => '']) ?>
  <!--    --><? //= $form->field($model, 'support_regularity_type')->dropDownList([ 'week_days' => 'Week days', 'dates_of_the_month' => 'Dates of the month', ], ['prompt' => '']) ?>
  <!--    --><? //= $form->field($model, 'support_days')->textInput(['maxlength' => true]) ?>
  <!--    --><? //= $form->field($model, 'verified')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

  <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

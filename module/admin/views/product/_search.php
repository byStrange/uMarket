<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, "id")->textInput(['readonly' => true, 'placeholder' => Yii::t('app', 'ID')]) ?>

      <?= $form->field($model, "created_at")->textInput(['readonly' => true, 'placeholder' => Yii::t('app', 'Created At')]) ?>

      <?= $form->field($model, "updated_at")->textInput(['readonly' => true, 'placeholder' => Yii::t('app', 'Updated At')]) ?>

      <?= $form->field($model, 'price')->input('number', ['step' => '0.01', 'placeholder' => Yii::t('app', 'Price')]) ?>

      <?= $form->field($model, 'discount_price')->input('number', ['step' => '0.01', 'placeholder' => Yii::t('app', 'Discount Price')]) ?>

      <?= $form->field($model, 'status')->dropDownList([
        '1' => Yii::t('app', 'Active'),
        '0' => Yii::t('app', 'Inactive')
      ], ['prompt' => Yii::t('app', 'Select Status')]) ?>

      <?= $form->field($model, 'views')->input('number', ['placeholder' => Yii::t('app', 'Views')]) ?>
    </div>

    <div class="col-md-6">
      <?= $form->field($model, 'created_by_id')->dropDownList(
        User::toOptionsList(), // Assuming you have a list of users
        ['prompt' => Yii::t('app', 'Select User')]
      ) ?>
    </div>

  </div>
  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', "Search"), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', "Reset"), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

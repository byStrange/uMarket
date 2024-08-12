<?php

use app\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\OrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->textInput(['placeholder' => Yii::t('app', 'ID')]) ?>

  <?= $form->field($model, "created_at")->textInput(['placeholder' => Yii::t('app', 'Created At')]) ?>

  <?= $form->field($model, "updated_at")->textInput(['placeholder' => Yii::t('app', 'Updated At')]) ?>

  <?= $form->field($model, "status")->dropDownList([
    '' => Yii::t('app', 'Select Status'),
    1 => Yii::t('app', 'Pending'),
    2 => Yii::t('app', 'Processing'),
    3 => Yii::t('app', 'Shipped'),
    4 => Yii::t('app', 'Delivered'),
    5 => Yii::t('app', 'Cancelled'),
  ]) ?>


  <?= $form->field($model, "payment_type")->dropDownList(Order::getPaymentTypeOptions(), ['prompt' => Yii::t('app', 'Select Payment Type')]) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', "Search"), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', "Reset"), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

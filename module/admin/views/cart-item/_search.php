<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CartItemSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-item-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id") ?>

  <?= $form->field($model, "quantity") ?>

  <?= $form->field($model, "cart_id") ?>

  <?= $form->field($model, "product_id") ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t("app", "Search"), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', "Reset"), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CartSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id") ?>

  <?= $form->field($model, "created_at") ?>

  <?= $form->field($model, "updated_at") ?>

  <?= $form->field($model, "user_id") ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t("app", "Search"), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t("app", "Reset"), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

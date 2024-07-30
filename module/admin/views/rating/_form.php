<?php

use app\components\Utils;
use app\models\Product;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Rating $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rating-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "score")->textInput() ?>

  <?= $form->field($model, "comment")->textarea(["rows" => 6]) ?>

  <?= Utils::popupField($form, $model, '', function ($form, $model) {
    return $form
      ->field($model, "product_id")
      ->dropDownList(Product::toOptionsList());
  }) ?>

  <?= Utils::popupField($form, $model, '', function ($form, $model) {
    return $form
      ->field($model, "user_id")
      ->dropDownList(
        User::toOptionsList()
      )
      ->label("User");
  }) ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

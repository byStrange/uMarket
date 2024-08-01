<?php

use app\components\Utils;
use app\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductTranslation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-translation-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "language_code")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "title")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "description")->textarea(["rows" => 5]) ?>

  <?php if (isset($product_id)) {
      echo $form
          ->field($model, "product_id")
          ->hiddenInput(["value" => $product_id])
          ->label("Product Id: $product_id");
  } else {
      echo Utils::popupField($form, $model, "product_id", function (
          $form,
          $model
      ) {
          return $form
              ->field($model, "product_id")
              ->dropDownList(Product::toOptionsList());
      });
  } ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

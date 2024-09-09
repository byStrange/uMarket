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

  <?= $form->field($model, 'language_code')->textInput(['maxlength' => true, 'placeholder' => Yii::t("app", "for example uz-UZ")])->label(Yii::t('app', 'Language Code')) ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('app', 'Title')) ?>

  <?= $form->field($model, 'description')->textarea(['rows' => 5])->label(Yii::t('app', 'Description')) ?>

  <?php if (isset($product_id)) {
    echo $form
      ->field($model, 'product_id')
      ->hiddenInput(['value' => $product_id])
      ->label(Yii::t('app', 'Product Id: {id}', ['id' => $product_id]));
  } else {
    echo Utils::popupField($form, $model, 'product_id', function (
      $form,
      $model
    ) {
      $options = Product::toOptionsList();
      return $form
        ->field($model, 'product_id')
        ->dropDownList($options, ['prompt' => Yii::t('app', 'Select a product')])
        ->label(Yii::t('app', 'Product'));
    });
  } ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

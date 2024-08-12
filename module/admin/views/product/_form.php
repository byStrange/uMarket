<?php

use app\components\Utils;
use app\models\Category;
use app\models\Image;
use app\models\Product;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */

// Get the current action ID for conditional display
$actionId = Yii::$app->controller->action->id;

// Generate options lists for dropdowns
$imageOptionsList = Image::toOptionsList();
$toProductsOptionsList = Product::toOptionsList();
$categoriesOptionList = Category::toOptionsList();
$usersOptionList = User::toOptionsList();
?>

<div class="product-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-6">
      <?= Utils::popupField($form, $model, "category", function ($form, $model) use ($categoriesOptionList) {
        return $form
          ->field($model, "categories[]")
          ->dropDownList($categoriesOptionList, [
            "multiple" => true,
            "options" => Utils::preSelectOptions($model->categories),
          ])->label(Yii::t('app', 'Categories'));
      }) ?>

      <?= Utils::popupField($form, $model, "image", function ($form, $model) use ($imageOptionsList) {
        return $form->field($model, "images[]")->dropDownList($imageOptionsList, [
          "multiple" => true,
          "options" => Utils::preSelectOptions($model->images),
        ])->label(Yii::t('app', 'Images'));
      }) ?>

      <?= Utils::popupField($form, $model, "product", function ($form, $model) use ($toProductsOptionsList) {
        return $form
          ->field($model, "toProducts[]")
          ->dropDownList($toProductsOptionsList, [
            "multiple" => true,
            "options" => Utils::preSelectOptions($model->toProducts),
          ])
          ->label(Yii::t('app', 'Related Products'));
      }) ?>

      <?php if ($actionId != "create"): ?>

        <?=
        // Utils::popupField($form, $model, "user", function ($form, $model) use ($usersOptionList) {
        //     return $form
        //       ->field($model, "viewers[]")
        //       ->dropDownList($usersOptionList, [
        //         "multiple" => true,
        //         "options" => Utils::preSelectOptions($model->viewers),
        //       ])->label(Yii::t('app', 'Viewers'));
        // })
        ""
        ?>

        <?=
        // Utils::popupField($form, $model, "user", function ($form, $model) use ($usersOptionList) {
        //     return $form
        //       ->field($model, "likedUsers[]")
        //       ->dropDownList($usersOptionList, [
        //         "multiple" => true,
        //         "options" => Utils::preSelectOptions($model->likedUsers),
        //       ])->label(Yii::t('app', 'Liked Users'));
        // })
        ""
        ?>

      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'price')->input('number', [
        'step' => '0.01',
        'id' => 'price-input',
        'class' => 'form-control'
      ])->label(Yii::t('app', 'Price')); ?>

      <?= $form->field($model, 'discount_price')->input('number', [
        'step' => '0.01',
        'id' => 'discount-price-input',
        'class' => 'form-control'
      ])->label(Yii::t('app', 'Discount Price')); ?>

      <?= $form->field($model, 'status')->dropDownList([
        '1' => 'Active',
        '0' => 'Inactive'
      ], ['class' => 'form-select'])->label(Yii::t('app', 'Status')); ?>

      <?= $form->field($model, 'views')->input('number', [
        'class' => 'form-control'
      ])->label(Yii::t('app', 'Views')); ?>
    </div>
    <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
    </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>

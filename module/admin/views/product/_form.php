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
$actionId = Yii::$app->controller->action->id;
$imageOptionsList = Image::toOptionsList();
$toProductsOptionsList = Product::toOptionsList();
$categoriesOptionList = Category::toOptionsList();
$usersOptionList = User::toOptionsList();


?>

<div class="product-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-6">
      <?= Utils::popupField($form, $model, "category", function (
        $form,
        $model
      ) use ($categoriesOptionList) {
        return $form
          ->field($model, "categories[]")
          ->dropDownList($categoriesOptionList, [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
              $model->categories
            ),
          ]);
      }) ?>

      <?= Utils::popupField($form, $model, "image", function ($form, $model) use (
        $imageOptionsList
      ) {
        return $form->field($model, "images[]")->dropDownList($imageOptionsList, [
          "multiple" => true,
          "options" => Utils::preSelectOptions(
            $model->images
          ),
        ]);
      }) ?>

      <?= Utils::popupField($form, $model, "product", function ($form, $model) use (
        $toProductsOptionsList
      ) {
        return $form
          ->field($model, "toProducts[]")
          ->dropDownList($toProductsOptionsList, [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
              $model->toProducts
            ),
          ])
          ->label("Related products");
      }) ?>

      <?php if ($actionId != "create"): ?>

        <?= Utils::popupField($form, $model, "user", function ($form, $model) use (
          $usersOptionList
        ) {
          return $form
            ->field($model, "viewers[]")
            ->dropDownList($usersOptionList, [
              "multiple" => true,
              "options" => Utils::preSelectOptions(
                $model->viewers
              ),
            ]);
        }) ?>

        <?= Utils::popupField($form, $model, "user", function ($form, $model) use (
          $usersOptionList
        ) {
          return $form
            ->field($model, "likedUsers[]")
            ->dropDownList($usersOptionList, [
              "multiple" => true,
              "options" => Utils::preSelectOptions(
                $model->likedUsers
              ),
            ]);
        }) ?>

      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'price')->input('number', ['step' => '0.01', 'id' => 'price-input', 'class' => 'form-control']); ?>
      <?= $form->field($model, 'discount_price')->input('number', ['step' => '0.01', 'id' => 'discount-price-input', 'class' => 'form-control']); ?>
      <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive'], ['class' => 'form-select']); ?>
      <?= $form->field($model, 'views')->input('number', ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
      <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>

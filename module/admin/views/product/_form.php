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

  <?= Utils::popupField($form, $model, 'category', function ($form, $model) use ($categoriesOptionList) {
    return $form->field($model, "categories[]")->dropDownList(
      $categoriesOptionList,
      [
        "multiple" => true,
        "options" => Utils::preSelectOptions(
          $categoriesOptionList,
          $model->categories
        ),
      ]
    );
  }) ?>

  <?= Utils::popupField($form, $model, 'image', function ($form, $model) use ($imageOptionsList) {
    return $form->field($model, "images[]")->dropDownList(
      $imageOptionsList,
      [
        "multiple" => true,
        "options" => Utils::preSelectOptions(
          $imageOptionsList,
          $model->images
        ),
      ]
    );
  }) ?>

  <?= Utils::popupField($form, $model, 'product', function ($form, $model) use ($toProductsOptionsList) {
    return $form
      ->field($model, "toProducts[]")
      ->dropDownList($toProductsOptionsList, [
        "multiple" => true,
        "options" => Utils::preSelectOptions(
          $toProductsOptionsList,
          $model->toProducts
        ),
      ])->label('Related products');
  }) ?>

  <?php if ($actionId != 'create'): ?>

    <?= Utils::popupField($form, $model, 'user', function ($form, $model) use ($usersOptionList) {
      return $form->field($model, "viewers[]")->dropDownList(
        $usersOptionList,
        [
          "multiple" => true,
          "options" => Utils::preSelectOptions(
            $usersOptionList,
            $model->viewers
          ),
        ]
      );
    }) ?>

    <?= Utils::popupField($form, $model, 'user', function ($form, $model) use ($usersOptionList) {
      return $form->field($model, "likedUsers[]")->dropDownList(
        $usersOptionList,
        [
          "multiple" => true,
          "options" => Utils::preSelectOptions(
            $usersOptionList,
            $model->likedUsers
          ),
        ]
      );
    }) ?>

  <?php endif ?>

  <?= $form->field($model, "price")->textInput() ?>

  <?= $form->field($model, "discount_price")->textInput() ?>

  <?= $form->field($model, "status")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "views")->textInput() ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

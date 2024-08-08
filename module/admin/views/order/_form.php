<?php

use app\components\Utils;
use app\models\CartItem;
use app\models\Coupon;
use app\models\Order;
use app\models\User;
use app\models\UserAddress;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */

$statuses = [
    1 => "Pending",
    2 => "Processing",
    3 => "Shipped",
    4 => "Delivered",
    5 => "Cancelled",
];

$cartItemQuery = CartItem::toOptionsList();
?>

<div class="order-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "status")->dropDownList($statuses) ?>

  <?= $form->field($model, "payment_type")->dropDownList(Order::getPaymentTypeOptions(), ['value' => $model->payment_type]) ?>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
      return $form
          ->field($model, "coupon_id")
          ->dropDownList(Coupon::toOptionsList())
          ->label("Coupon");
  }) ?>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
      return $form
          ->field($model, "user_id")
          ->dropDownList(User::toOptionsList())
          ->label("User");
  }) ?>

  <?= Utils::popupField($form, $model, "user-address", function (
      $form,
      $model
  ) {
      return $form
          ->field($model, "address_id")
          ->dropDownList(UserAddress::toOptionsList())
          ->label("Address");
  }) ?>

  <?= Utils::popupField($form, $model, "cart-item", function (
      $form,
      $model
  ) use ($cartItemQuery) {
      return $form
          ->field($model, "cartItems[]")
          ->dropDownList($cartItemQuery, [
              "multiple" => true,
              "options" => Utils::preSelectOptions(
                  $model->cartItems
              ),
          ])
          ->label("Cart items");
  }) ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

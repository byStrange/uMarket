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
  1 => Yii::t('app', 'Pending'),
  2 => Yii::t('app', 'Processing'),
  3 => Yii::t('app', 'Shipped'),
  4 => Yii::t('app', 'Delivered'),
  5 => Yii::t('app', 'Cancelled'),
];

$cartItemQuery = CartItem::toOptionsList();
?>

<div class="order-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "status")->dropDownList($statuses, ['prompt' => Yii::t('app', 'Select Status')]) ?>

  <?= $form->field($model, "payment_type")->dropDownList(Order::getPaymentTypeOptions(), ['value' => $model->payment_type, 'prompt' => Yii::t('app', 'Select Payment Type')]) ?>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
      ->field($model, "coupon_id")
      ->dropDownList(Coupon::toOptionsList(), ['prompt' => Yii::t('app', 'Select Coupon')])
      ->label(Yii::t('app', 'Coupon'));
  }) ?>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
      ->field($model, "user_id")
      ->dropDownList(User::toOptionsList(), ['prompt' => Yii::t('app', 'Select User')])
      ->label(Yii::t('app', 'User'));
  }) ?>

  <?= Utils::popupField($form, $model, "user-address", function ($form, $model) {
    return $form
      ->field($model, "address_id")
      ->dropDownList(UserAddress::toOptionsList(), ['prompt' => Yii::t('app', 'Select Address')])
      ->label(Yii::t('app', 'Address'));
  }) ?>

  <?= Utils::popupField($form, $model, "cart-item", function ($form, $model) use ($cartItemQuery) {
    return $form
      ->field($model, "cartItems[]")
      ->dropDownList($cartItemQuery, [
        "multiple" => true,
        "options" => Utils::preSelectOptions($model->cartItems),
        'prompt' => Yii::t('app', 'Select Cart Items'),
      ])
      ->label(Yii::t('app', 'Cart Items'));
  }) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

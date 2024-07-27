<?php

use app\components\Utils;
use app\models\CartItem;
use app\models\Coupon;
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

$paymentTypes = [
    "click" => "ClickUz",
    "payme" => "PayMe",
    "cod" => "Cash on Delivery",
];

$cartItemQuery = CartItem::find()
    ->select(["id"])
    ->indexBy("id")
    ->column();
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "status")->dropDownList($statuses) ?>

    <?= $form->field($model, "payment_type")->dropDownList($paymentTypes) ?>

    <?= $form
        ->field($model, "coupon_id")
        ->dropDownList(Coupon::find()->select("label")->indexBy("id")->column())
        ->label("Coupon") ?>

    <?= $form
        ->field($model, "user_id")
        ->dropDownList(
            User::find()->select("username")->indexBy("id")->column()
        )
        ->label("User") ?>

    <?= $form
        ->field($model, "address_id")
        ->dropDownList(
            UserAddress::find()->select("label")->indexBy("id")->column()
        )
        ->label("Address") ?>

<?= $form
    ->field($model, "cartItems[]")
    ->dropDownList($cartItemQuery, [
        "multiple" => true,
        "options" => Utils::preSelectOptions($cartItemQuery, $model->cartItems),
    ])
    ->label("Cart items") ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

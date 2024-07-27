<?php

use app\models\Cart;
use app\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CartItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "quantity")->textInput() ?>

    <?= $form->field($model, "cart_id")->dropDownList(
        Cart::find()
            ->select(["id"])
            ->indexBy("id")
            ->column()
    ) ?>

<?= $form
    ->field($model, "product_id")
    ->dropDownList(Product::findTranslatedTitlesOrIds())
    ->label("Product") ?>
    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

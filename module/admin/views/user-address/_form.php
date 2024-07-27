<?php

use app\models\DeliveryPoint;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserAddress $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "label")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "city")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "zip_code")->textInput(["maxlength" => true]) ?>

    <?= $form
        ->field($model, "delivery_point_id")
        ->dropDownList(
            DeliveryPoint::find()->select("label")->indexBy("id")->column()
        )
        ->label("Delivery point") ?>

    <?= $form
        ->field($model, "user_id")
        ->dropDownList(
            User::find()->select("username")->indexBy("id")->column()
        )
        ->label("User") ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

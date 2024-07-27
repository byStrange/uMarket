<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CouponSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="coupon-search">

    <?php $form = ActiveForm::begin([
        "action" => ["index"],
        "method" => "get",
    ]); ?>

    <?= $form->field($model, "id") ?>

    <?= $form->field($model, "created_at") ?>

    <?= $form->field($model, "updated_at") ?>

    <?= $form->field($model, "code") ?>

    <?= $form->field($model, "discount_percentage") ?>

    <?php
// echo $form->field($model, 'is_active')->checkbox()
?>

    <div class="form-group">
        <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
        <?= Html::resetButton("Reset", [
            "class" => "btn btn-outline-secondary",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

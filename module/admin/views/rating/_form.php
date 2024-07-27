<?php

use app\models\Product;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Rating $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rating-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "score")->textInput() ?>

    <?= $form->field($model, "comment")->textarea(["rows" => 6]) ?>

    <?= $form
        ->field($model, "product_id")
        ->dropDownList(Product::findTranslatedTitlesOrIds()) ?>

    <?= $form
        ->field($model, "user_id")
        ->dropDownList(
            User::find()
                ->select(["username"])
                ->indexBy("id")
                ->column()
        )
        ->label("User") ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

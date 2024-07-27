<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LocationPoint $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="location-point-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "lon")->textInput() ?>

    <?= $form->field($model, "lat")->textInput() ?>

    <?= $form
        ->field($model, "address_label")
        ->textInput(["maxlength" => true]) ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        "action" => ["index"],
        "method" => "get",
    ]); ?>

    <?= $form->field($model, "id") ?>

    <?= $form->field($model, "is_superuser")->checkbox() ?>

    <?= $form->field($model, "username") ?>

    <?php
// echo $form->field($model, 'first_name')
?>

    <?php
// echo $form->field($model, 'last_name')
?>

    <?php
// echo $form->field($model, 'email')
?>

    <?php
// echo $form->field($model, 'is_active')->checkbox()
?>

    <?php
// echo $form->field($model, 'created_at')
?>

    <?php
// echo $form->field($model, 'updated_at')
?>

    <div class="form-group">
        <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
        <?= Html::resetButton("Reset", [
            "class" => "btn btn-outline-secondary",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

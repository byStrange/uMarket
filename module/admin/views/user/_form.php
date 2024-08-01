<?php

use app\models\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "password")->passwordInput(["maxlength" => true]) ?>

  <?= $form->field($model, "is_superuser")->checkbox() ?>

  <?= $form->field($model, "username")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "first_name")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "last_name")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "email")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "profile_picture")->fileInput() ?>

  <?= $form->field($model, "is_active")->checkbox() ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

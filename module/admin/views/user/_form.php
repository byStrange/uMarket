<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(Yii::t('app', 'Password')) ?>

  <?= $form->field($model, 'is_superuser')->checkbox()->label(Yii::t('app', 'Is Superuser')) ?>

  <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label(Yii::t('app', 'Username')) ?>

  <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label(Yii::t('app', 'First Name')) ?>

  <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label(Yii::t('app', 'Last Name')) ?>

  <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(Yii::t('app', 'Email')) ?>

  <?= $form->field($model, 'profile_picture')->fileInput()->label(Yii::t('app', 'Profile Picture')) ?>

  <?= $form->field($model, 'is_active')->checkbox()->label(Yii::t('app', 'Is Active')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

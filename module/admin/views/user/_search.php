<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'id')->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, 'is_superuser')->checkbox()->label(Yii::t('app', 'Is Superuser')) ?>

  <?= $form->field($model, 'username')->label(Yii::t('app', 'Username')) ?>

  <?= $form->field($model, 'first_name')->label(Yii::t('app', 'First Name')) ?>

  <?= $form->field($model, 'last_name')->label(Yii::t('app', 'Last Name')) ?>

  <?= $form->field($model, 'email')->label(Yii::t('app', 'Email')) ?>

  <?= $form->field($model, 'is_active')->checkbox()->label(Yii::t('app', 'Is Active')) ?>

  <?= $form->field($model, 'created_at')->label(Yii::t('app', 'Created At')) ?>

  <?= $form->field($model, 'updated_at')->label(Yii::t('app', 'Updated At')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), [
      'class' => 'btn btn-outline-secondary',
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

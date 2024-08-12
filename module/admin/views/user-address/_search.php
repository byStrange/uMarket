<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\UserAddressSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-address-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, "created_at")->label(Yii::t('app', 'Created At')) ?>

  <?= $form->field($model, "updated_at")->label(Yii::t('app', 'Updated At')) ?>

  <?= $form->field($model, "label")->label(Yii::t('app', 'Label')) ?>

  <?= $form->field($model, "city")->label(Yii::t('app', 'City')) ?>

  <?php
  // Uncomment and translate these fields if needed
  // echo $form->field($model, 'zip_code')->label(Yii::t('app', 'Zip Code'));
  // echo $form->field($model, 'delivery_point_id')->label(Yii::t('app', 'Delivery Point ID'));
  // echo $form->field($model, 'user_id')->label(Yii::t('app', 'User ID'));
  ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

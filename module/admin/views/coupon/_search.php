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

  <?= $form->field($model, "id")->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, "created_at")->label(Yii::t('app', 'Created At')) ?>

  <?= $form->field($model, "updated_at")->label(Yii::t('app', 'Updated At')) ?>

  <?= $form->field($model, "code")->label(Yii::t('app', 'Code')) ?>

  <?= $form->field($model, "discount_percentage")->label(Yii::t('app', 'Discount Percentage')) ?>

  <?= $form->field($model, 'is_active')->checkbox()->label(Yii::t('app', 'Is Active')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

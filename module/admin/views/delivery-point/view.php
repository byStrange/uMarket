<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\DeliveryPointSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="delivery-point-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, "created_at")->label(Yii::t('app', 'Created At'))
  ?>

  <?= $form->field($model, "updated_at")->label(Yii::t('app', 'Updated At')) ?>

  <?= $form->field($model, "label")->label(Yii::t('app', 'Label')) ?>

  <?= $form->field($model, "location_id")->label(Yii::t('app', 'Location')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

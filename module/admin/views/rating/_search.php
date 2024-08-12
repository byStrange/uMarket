<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\RatingSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rating-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, "created_at")->label(Yii::t('app', 'Created At')) ?>

  <?= $form->field($model, "updated_at")->label(Yii::t('app', 'Updated At')) ?>

  <?= $form->field($model, "score")->label(Yii::t('app', 'Score')) ?>

  <?= $form->field($model, "comment")->label(Yii::t('app', 'Comment')) ?>

  <?php
  // Uncomment and translate the following fields if needed
  // echo $form->field($model, 'product_id')->label(Yii::t('app', 'Product ID'));
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

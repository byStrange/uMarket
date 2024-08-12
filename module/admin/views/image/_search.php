<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ImageSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="image-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->textInput(['placeholder' => Yii::t('app', 'ID')]) ?>

  <?= $form->field($model, "created_at")->textInput(['placeholder' => Yii::t('app', 'Created at')]) ?>

  <?= $form->field($model, "updated_at")->textInput(['placeholder' => Yii::t('app', 'Updated at')]) ?>

  <?= $form->field($model, "image")->textInput(['placeholder' => Yii::t('app', 'Image')]) ?>

  <?= $form->field($model, "alt")->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Alt')]) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

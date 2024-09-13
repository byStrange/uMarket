<?php

use yii\helpers\Html;
use yii\jui\Accordion;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\Image $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="image-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "image_file")->fileInput()->label('Change Image') ?>

  <?= $form->field($model, "alt")->textInput(["maxlength" => true]) ?>

  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

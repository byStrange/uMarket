<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\FeaturedOfferSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="featured-offer-search">

  <?php $form = ActiveForm::begin([
    "action" => ["index"],
    "method" => "get",
  ]); ?>

  <?= $form->field($model, "id")->label('app', "Id") ?>

  <?= $form->field($model, "created_at")->label('app', "Created at") ?>

  <?= $form->field($model, "updated_at")->label('app', "Updated at") ?>

  <?= $form->field($model, "dicount_price")->label('app', "Dicount price") ?>

  <?= $form->field($model, "start_time")->label('app', "Start time") ?>

  <?php
  // echo $form->field($model, 'end_time')
  ?>

  <?php
  // echo $form->field($model, 'product_id')
  ?>

  <?php
  // echo $form->field($model, 'category_id')
  ?>

  <?php
  // echo $form->field($model, 'image_banner_id')
  ?>

  <?php
  // echo $form->field($model, 'image_portrait_id')
  ?>

  <?php
  // echo $form->field($model, 'image_small_landscape_id')
  ?>

  <?php
  // echo $form->field($model, 'type')
  ?>

  <div class="form-group">
    <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
    <?= Html::resetButton("Reset", [
      "class" => "btn btn-outline-secondary",
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

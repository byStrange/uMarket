<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserAddress $model */
/** @var yii\widgets\ActiveForm $form */
/** @var bool $d */
?>

<style>
  .user-address-form .d-flex>div {
    flex-basis: 50%;
  }

  .user-address-form .help-block {
    color: var(--bs-danger)
  }
</style>
<div class="user-address-form">

  <?php $form = ActiveForm::begin(); ?>


  <div class="d-flex gap-3">
    <?= $form->field($model, "label")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "city")->textInput(["maxlength" => true]) ?>
  </div>
  <div class="d-flex gap-3">
    <?= $form->field($model, "zip_code")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "apartment")->textInput(["maxlength" => true]) ?>
  </div>

  <div class="d-flex gap-3">
    <?= $form->field($model, "street_address")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "user_first_name")->textInput(["maxlength" => true]) ?>
  </div>

  <div class="d-flex gap-3">
    <?= $form->field($model, "street_address")->textInput(["maxlength" => true]) ?>
    <?= $form->field($model, "user_last_name")->textInput(["maxlength" => true]) ?>
  </div>

  <div class="d-flex gap-3">
    <?= $form->field($model, "user_phone_number")->textInput(["maxlength" => true]) ?>

    <?php if (!$d): ?>
      <?= $form
        ->field($model, "user_id")
        ->dropDownList(User::find()->select("username")->indexBy("id")->column())
        ->label("User") ?>
    <?php endif ?>
  </div>
  <?php if ($d) : ?>
    <button class="btn-primary mt-3" hx-post="/admin/user-address/create/?d=true" hx-trigger='click' hx-swap="none" data-bs-dismiss="modal">Save</button>
  <?php else: ?>
    <div class="form-group">
      <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>
  <?php endif ?>
  <?php ActiveForm::end(); ?>

</div>

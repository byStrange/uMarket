<?php

use app\components\Utils;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
      ->field($model, "user_id")
      ->dropDownList(User::toOptionsList())->label(Yii::t('app', 'User'));
  }) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t("app", "Save"), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

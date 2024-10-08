<?php

use app\components\Utils;
use app\models\LocationPoint;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DeliveryPoint $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="delivery-point-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "label")->textInput(["maxlength" => true])->label(Yii::t('app', 'Label')) ?>

  <?= Utils::popupField($form, $model, "location-point", function (
    $form,
    $model
  ) {
    return $form
      ->field($model, "location_id")
      ->dropDownList(LocationPoint::toOptionsList())
      ->label(Yii::t('app', 'Location Point'));
  }) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

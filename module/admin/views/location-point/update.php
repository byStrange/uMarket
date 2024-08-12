<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LocationPoint $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', "Update Location point {id}", ["id" => $model->id]);
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', "Location Points"), "url" => ["index"]];
$this->params["breadcrumbs"][] = [
  "label" => $model->id,
  "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', "Update");

?>

<div class="location-point-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "lon")->textInput()->label(Yii::t('app', 'Longitude')) ?>

  <?= $form->field($model, "lat")->textInput()->label(Yii::t('app', 'Latitude')) ?>

  <?= $form
    ->field($model, "address_label")
    ->textInput(["maxlength" => true])
    ->label(Yii::t('app', 'Address Label')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

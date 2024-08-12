<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LocationPoint $model */

$this->title = Yii::t('app', "Create Location Point");
if (!$popup) {
  $this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', "Location Points"),
    "url" => ["index"],
  ];
  $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="location-point-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

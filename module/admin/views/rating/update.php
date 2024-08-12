<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Rating $model */

$this->title = Yii::t('app', "Update Rating: {id}", ['id' => $model->id]);
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', "Ratings"), "url" => ["index"]];
$this->params["breadcrumbs"][] = [
  "label" => $model->id,
  "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', "Update");
?>
<div class="rating-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

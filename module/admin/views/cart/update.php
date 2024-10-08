<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */

$this->title = Yii::t('app', "Update Cart: {id}", ["id" => $model->id]);
$this->params["breadcrumbs"][] = ["label" => Yii::t("app", "Carts"), "url" => ["index"]];
$this->params["breadcrumbs"][] = [
  "label" => $model->id,
  "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', "Update");
?>
<div class="cart-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

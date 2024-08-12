<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductTranslation $model */

$this->title = Yii::t('app', "Update Product Translation: {id}", ['id' => $model->id]);
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', "Product Translations"),
  "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
  "label" => $model->title,
  "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app',  "Update");
?>
<div class="product-translation-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductTranslation $model */

$this->title = Yii::t('app', "Create Product Translation");
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', "Product Translations"),
  "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="product-translation-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

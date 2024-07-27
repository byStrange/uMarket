<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductTranslation $model */

$this->title = "Update Product Translation: " . $model->title;
$this->params["breadcrumbs"][] = [
    "label" => "Product Translations",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->title,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = "Update";
?>
<div class="product-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

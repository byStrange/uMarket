<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryTranslation $model */

$this->title = "Update Category Translation: " . $model->name;
$this->params["breadcrumbs"][] = [
    "label" => "Category Translations",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->name,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = "Update";
?>
<div class="category-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

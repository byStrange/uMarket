<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryTranslation $model */

$this->title = Yii::t('app', 'Update Category Translation: {id}', [
    'id' => $model->name,
]);
$this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', 'Category Translations'),
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->name,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', 'Update');
?>
<div class="category-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

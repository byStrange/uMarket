<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => "Categories", "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            "Update",
            ["update", "id" => $model->id],
            ["class" => "btn btn-primary"]
        ) ?>
        <?= Html::a(
            "Delete",
            ["delete", "id" => $model->id],
            [
                "class" => "btn btn-danger",
                "data" => [
                    "confirm" => "Are you sure you want to delete this item?",
                    "method" => "post",
                ],
            ]
        ) ?>
    </p>

    <?= DetailView::widget([
        "model" => $model,
        "attributes" => [
            "id",
            "created_at",
            "label",
            "updated_at",
            "parent_id_id",
            /*[*/
            /*    "label" => "name",*/
            /*    "value" => $model->getCategoryTranslationForLanguage(*/
            /*        Yii::$app->language*/
            /*    ),*/
            /*],*/
        ],
    ]) ?>

</div>

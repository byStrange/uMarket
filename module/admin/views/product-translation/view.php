<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductTranslation $model */

$this->title = $model->title;
$this->params["breadcrumbs"][] = [
    "label" => "Product Translations",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-translation-view">

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
            "updated_at",
            "language_code",
            "title",
            "product_id",
        ],
    ]) ?>

</div>

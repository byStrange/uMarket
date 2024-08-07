<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = [
    "label" => "Featured Offers",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="featured-offer-view">

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
          "dicount_price",
          "start_time",
          "end_time",
          "product_id",
          "category_id",
          "image_banner",
          "image_portrait",
          "image_small_landscape",
          "type",
      ],
  ]) ?>

</div>

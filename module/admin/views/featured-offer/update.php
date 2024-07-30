<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */

$this->title = "Update Featured Offer: " . $model->id;
$this->params["breadcrumbs"][] = [
    "label" => "Featured Offers",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->id,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = "Update";
?>
<div class="featured-offer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

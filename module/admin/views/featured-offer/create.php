<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */

$this->title = "Create Featured Offer";
$this->params["breadcrumbs"][] = [
    "label" => "Featured Offers",
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="featured-offer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

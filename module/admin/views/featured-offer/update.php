<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */

$this->title = Yii::t('app', "Update Featured Offer {id}", ['id' => $model->id]);
$this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', "Featured Offers"),
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->id,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', "Update");
?>
<div class="featured-offer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

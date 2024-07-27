<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Rating $model */

$this->title = "Create Rating";
$this->params["breadcrumbs"][] = ["label" => "Ratings", "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="rating-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

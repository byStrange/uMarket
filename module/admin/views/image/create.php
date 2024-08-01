<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Image $model */

$this->title = "Create Image";
if (!$popup) {
    $this->params["breadcrumbs"][] = ["label" => "Images", "url" => ["index"]];
    $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="image-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
      "model" => $model,
  ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */

$this->title = "Create Cart";
if (!$popup) {
    $this->params["breadcrumbs"][] = ["label" => "Carts", "url" => ["index"]];
    $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="cart-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
      "model" => $model,
  ]) ?>

</div>

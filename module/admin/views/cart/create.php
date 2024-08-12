<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */

$this->title = Yii::t('app', "Create Cart");
if (!$popup) {
  $this->params["breadcrumbs"][] = ["label" => Yii::t("app", "Carts"), "url" => ["index"]];
  $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="cart-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

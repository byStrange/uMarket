<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coupon $model */

$this->title = Yii::t('app', "Create Coupon");
if (!$popup) {
  $this->params["breadcrumbs"][] = ["label" => Yii::t('app', "Coupons"), "url" => ["index"]];
  $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="coupon-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
  ]) ?>

</div>

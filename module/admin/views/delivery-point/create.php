<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DeliveryPoint $model */

$this->title = Yii::t('app', 'Create Delivery Point');
if (!$popup) {
    $this->params["breadcrumbs"][] = [
        "label" => Yii::t('app', 'Delivery Points'),
        "url" => ["index"],
    ];
    $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="delivery-point-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
      "model" => $model,
  ]) ?>

</div>

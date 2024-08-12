<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DeliveryPoint $model */

$this->title = Yii::t('app', 'Update Delivery Point: {id}', ['id' => $model->id]);
$this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', 'Delivery Points'),
    "url" => ["index"],
];
$this->params["breadcrumbs"][] = [
    "label" => $model->id,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = Yii::t('app', 'Update');
?>
<div class="delivery-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>

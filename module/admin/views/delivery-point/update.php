<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DeliveryPoint $model */

$this->title = 'Update Delivery Point: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Delivery Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

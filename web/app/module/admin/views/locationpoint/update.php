<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LocationPoint $model */

$this->title = 'Update Location Point: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Location Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="location-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

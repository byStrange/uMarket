<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DeliveryPoint $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app",  'Delivery Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="delivery-point-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => Yii::t("app",  'Are you sure you want to delete this item?'),
        'method' => Yii::t("app",  'post'),
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'created_at',
      'updated_at',
      'label',
      'location_id',
    ],
  ]) ?>

</div>

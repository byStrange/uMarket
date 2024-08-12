<?php

use app\models\DeliveryPoint;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\DeliveryPointSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Delivery Points');
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="delivery-point-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', 'Create Delivery Point'),
      ["create"],
      ["class" => "btn btn-success"]
    ) ?>
  </p>

  <?php
  // echo $this->render('_search', ['model' => $searchModel]);
  ?>

  <?= GridView::widget([
    "dataProvider" => $dataProvider,
    "filterModel" => $searchModel,
    "columns" => [
      ["class" => "yii\grid\SerialColumn"],

      [
        "attribute" => "id",
        "label" => Yii::t('app', 'ID'),
      ],
      [
        "attribute" => "created_at",
        "label" => Yii::t('app', 'Created At'),
      ],
      [
        "attribute" => "updated_at",
        "label" => Yii::t('app', 'Updated At'),
      ],
      [
        "attribute" => "label",
        "label" => Yii::t('app', 'Label'),
      ],
      [
        "attribute" => "location",
        "label" => Yii::t('app', 'Location'),
      ],
      [
        "class" => ActionColumn::className(),
        "header" => Yii::t('app', 'Actions'),
        "urlCreator" => function (
          $action,
          DeliveryPoint $model,
          $key,
          $index,
          $column
        ) {
          return Url::toRoute([$action, "id" => $model->id]);
        },
      ],
    ],
  ]) ?>


</div>

<?php

use app\models\CartItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CartItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Cart Items");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="cart-item-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Cart Item"),
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
        "attribute" => "quantity",
        "label" => Yii::t('app', 'Quantity'),
      ],
      [
        "attribute" => "cart_id",
        "label" => Yii::t('app', 'Cart ID'),
      ],
      [
        "attribute" => "product_id",
        "label" => Yii::t('app', 'Product ID'),
      ],
      [
        "class" => ActionColumn::className(),
        "header" => Yii::t('app', 'Actions'),
        "template" => "{view}",
        "urlCreator" => function (
          $action,
          CartItem $model,
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

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CartItem $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', 'Cart Items'), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cart-item-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', 'Update'),
      ["update", "id" => $model->id],
      ["class" => "btn btn-primary"]
    ) ?>
    <?= Html::a(
      Yii::t('app', 'Delete'),
      ["delete", "id" => $model->id],
      [
        "class" => "btn btn-danger",
        "data" => [
          "confirm" => Yii::t('app', 'Are you sure you want to delete this item?'),
          "method" => "post",
        ],
      ]
    ) ?>
  </p>

  <?= DetailView::widget([
    "model" => $model,
    "attributes" =>
    [
      "id",
      "quantity",
      [
        "attribute" => "cart_id",
        "label" => Yii::t("app", "Cart"),
        "value" => function ($model) {
          return $model->cart ? (string)$model->cart : Yii::t("app", "no cart item set, this item is moved to order");
        }
      ],
      "product_id"
    ],
  ]) ?>

</div>

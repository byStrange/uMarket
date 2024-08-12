<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', "Products"), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Update"),
      ["update", "id" => $model->id],
      ["class" => "btn btn-primary"]
    ) ?>
    <?= Html::a(
      Yii::t('app', "Delete"),
      ["delete", "id" => $model->id],
      [
        "class" => "btn btn-danger",
        "data" => [
          "confirm" => Yii::t('app',  "Are you sure you want to delete this item?"),
          "method" => "post",
        ],
      ]
    ) ?>
  </p>


  <?= DetailView::widget([
    "model" => $model,
    "attributes" => [
      [
        'attribute' => 'id',
        'label' => Yii::t('app', 'ID'),
      ],
      [
        'attribute' => 'created_at',
        'label' => Yii::t('app', 'Created At'),
      ],
      [
        'attribute' => 'updated_at',
        'label' => Yii::t('app', 'Updated At'),
      ],
      [
        'attribute' => 'price',
        'label' => Yii::t('app', 'Price'),
      ],
      [
        'attribute' => 'discount_price',
        'label' => Yii::t('app', 'Discount Price'),
      ],
      [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
      ],
      [
        'attribute' => 'views',
        'label' => Yii::t('app', 'Views'),
      ],
      [
        'label' => Yii::t('app', 'Owner'),
        'value' => $model->createdBy->username,
      ],
    ],
  ]) ?>


</div>

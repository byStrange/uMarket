<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Rating $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', "Ratings"), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rating-view">

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
          "confirm" => Yii::t('app', "Are you sure you want to delete this item?"),
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
        'attribute' => 'score',
        'label' => Yii::t('app', 'Score'),
      ],
      [
        'attribute' => 'comment',
        'label' => Yii::t('app', 'Comment'),
        'format' => 'ntext',
      ],
      [
        'attribute' => 'product_id',
        'label' => Yii::t('app', 'Product ID'),
      ],
      [
        'attribute' => 'user_id',
        'label' => Yii::t('app', 'User ID'),
      ],
    ],
  ]) ?>

</div>

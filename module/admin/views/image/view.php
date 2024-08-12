<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Image $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', 'Images'),
  "url" => ["index"]
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="image-view">

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
    "attributes" => [
      [
        "attribute" => "id",
        "label" => Yii::t('app', 'ID')
      ],
      [
        "attribute" => "created_at",
        "label" => Yii::t('app', 'Created At')
      ],
      [
        "attribute" => "updated_at",
        "label" => Yii::t('app', 'Updated At')
      ],
      [
        "attribute" => "image",
        "label" => Yii::t('app', 'Image')
      ],
      [
        "attribute" => "alt",
        "label" => Yii::t('app', 'Alt Text')
      ],
    ],
  ]) ?>

</div>

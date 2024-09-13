<?php

use yii\helpers\Html;
use yii\jui\Accordion;
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
        "attribute" => "image_small_landscape",
        "label" => Yii::t('app', 'Image'),
        'value' => function ($model) {
          if (!$model->image) {
            return '<span class="not-set">(not set)</span>';
          }
          return Accordion::widget([
            'items' => [
              [
                'header' => 'Click to view',
                'label' => Yii::t('app', 'Small Landscape Image'),
                'content' => Html::img('/' . $model->image, ['style' => 'max-height: 400px; max-width: 100%;'])
              ],
            ],
            'clientOptions' => [
              'collapsible' => true,
              'active' => true,
            ],
          ]);
        },
        'format' => 'raw'
      ],
      [
        "attribute" => "image",
        "label" => Yii::t('app', 'Url')
      ],
      [
        "attribute" => "alt",
        "label" => Yii::t('app', 'Alt Text')
      ],
    ],
  ]) ?>

</div>

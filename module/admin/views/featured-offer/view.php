<?php

use yii\helpers\Html;
use yii\jui\Accordion;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', "Featured Offers"),
  "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="featured-offer-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Update"),
      ["update", "id" => $model->id],
      ["class" => "btn btn-primary"]
    ) ?>
    <?= Html::a(
      Yii::t("app", "Delete"),
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
      ["attribute" => "id", "label" => Yii::t('app', 'ID')],
      ["attribute" => "created_at", "label" => Yii::t('app', 'Created At')],
      ["attribute" => "updated_at", "label" => Yii::t('app', 'Updated At')],
      ["attribute" => "dicount_price", "label" => Yii::t('app', 'Discount Price')],
      ["attribute" => "start_time", "label" => Yii::t('app', 'Start Time')],
      ["attribute" => "end_time", "label" => Yii::t('app', 'End Time')],
      ["attribute" => "product_id", "label" => Yii::t('app', 'Product'), 'value' => function ($model) {
        return $model->product;
      }],
      ["attribute" => "category_id", "label" => Yii::t('app', 'Category'), 'value' => function ($model) {
        return $model->category;
      }],
      ["attribute" => "image_banner", "label" => Yii::t('app', 'Banner Image'), 'value' => function ($model) {
        if (!$model->image_banner) {
          return '<span class="not-set">(not set)</span>';
        }
        return Accordion::widget([
          'items' => [
            [
              'header' => 'Click to view',
              'label' => Yii::t('app', 'Banner Image'),
              'content' => Html::img('/' . $model->image_banner, ['style' => 'max-height: 400px; max-width: 100%;'])
            ],
          ],
          'clientOptions' => [
            'collapsible' => true,
            'active' => true,
          ]
        ]);
      }, 'format' => 'raw'],
      [
        "attribute" => "image_portrait",
        "label" => Yii::t('app', 'Portrait Image'),
        "value" => function ($model) {
          if (!$model->image_portrait) {
            return '<span class="not-set">(not set)</span>';
          }
          return Accordion::widget([
            'items' => [
              [
                'header' => 'Click to view',
                'label' => Yii::t('app', 'Portrait Image'),
                'content' => Html::img('/' . $model->image_portrait, ['style' => 'max-height: 400px; max-width: 100%;'])
              ],
            ],
            'clientOptions' => [
              'collapsible' => true,
              'active' => true,
            ]
          ]);
        },
        'format' => 'raw'
      ],
      [
        "attribute" => "image_small_landscape",
        "label" => Yii::t('app', 'Small Landscape Image'),
        'value' => function ($model) {
          if (!$model->image_small_landscape) {
            return '<span class="not-set">(not set)</span>';
          }
          return Accordion::widget([
            'items' => [
              [
                'header' => 'Click to view',
                'label' => Yii::t('app', 'Small Landscape Image'),
                'content' => Html::img('/' . $model->image_small_landscape, ['style' => 'max-height: 400px; max-width: 100%;'])
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
      ["attribute" => "type", "label" => Yii::t('app', 'Type')],
    ],
  ]) ?>


</div>

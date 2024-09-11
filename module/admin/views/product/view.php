<?php

use app\models\Product;
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
        'attribute' => 'title',
        'label' => Yii::t('app', 'Title'),
        'filter' => false,
        'value' => function ($model) {
          return $model->getProductTranslationForLanguage()->title;
        }
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
        'value' => function ($model) {
          return Yii::$app->formatter->asCurrency($model->price);
        }
      ],
      [
        'attribute' => 'images',
        'label' => Yii::t('app', 'Images'),
        'format' => 'raw', // This tells Yii2 to render the output as HTML
        'value' => function ($model) {
          $images = $model->images;
          $imageTags = [];

          // Assuming each image URL is stored in the images attribute as an array
          foreach ($images as $image) {
            // You can adjust the width, height, and other attributes as needed
            $imageTags[] = Html::img('/' . $image->image, ['alt' => $image->alt, 'width' => '50', 'height' => '50']);
          }

          // Join the image tags into a single string
          return implode(' ', $imageTags);
        }
      ],
      [
        'attribute' => 'categories',
        'label' => Yii::t('app', 'Categories'),
        'value' => function ($model) {
          return implode(', ', $model->categories);
        }
      ],
      [
        'attribute' => 'real_value',
        'label' => Yii::t('app', 'Real value'),
        'value' => function ($model) {
          return $model->priceAsCurrency();
        }
      ],
      [
        'attribute' => 'discount_price',
        'label' => Yii::t('app', 'Discount Price'),
        'value' => function ($model) {
          return Yii::$app->formatter->asCurrency($model->discount_price);
        },
        'format' => 'raw'
      ],
      [
        'attribute' => 'offered',
        'label' => Yii::t('app', 'Offered'),
        'format' => 'boolean',
        'value' => function ($model) {
          return count($model->featuredOffers) ? true : false;
        }
      ],
      [
        'attribute' => 'specifications',
        'label' => Yii::t('app', 'Specifications'),
        'format' => 'raw',
        'value' => function ($model) {
          if (!$model->specifications) {
            return Yii::t('app', 'No specifications provided');
          }
          $specifications = $model->specifications;
          $specOutput = [];

          // Loop through each specification and format the output
          foreach ($specifications as $spec) {
            $specOutput[] = "<strong>{$spec->spec_key}</strong>: {$spec->spec_value}";
          }

          // Join the specifications into a single string with line breaks
          return implode('<br>', $specOutput);
        }
      ],
      [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
        'value' => function ($model) {
          $statusOptions = Product::getStatusOptions();
          $option = $statusOptions[$model->status] ?? Yii::t('app', 'Unknown');

          return $option;
        }
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
</div>

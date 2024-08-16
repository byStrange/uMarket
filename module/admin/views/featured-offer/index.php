<?php

use app\models\FeaturedOffer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\FeaturedOfferSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Featured Offers");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="featured-offer-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Featured Offer"),
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
        "attribute" => "title",
        "label" => Yii::t('app', 'Title'),
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
        "attribute" => "dicount_price",
        "label" => Yii::t('app', 'Discount Price'),
      ],
      [
        "attribute" => 'type',
        "label" => Yii::t('app', 'Type')
      ],
      [
        "attribute" => "start_time",
        "label" => Yii::t('app', 'Start Time'),
      ],
      /*
        [
            "attribute" => "end_time",
            "label" => Yii::t('app', 'End Time'),
        ],
        [
            "attribute" => "product_id",
            "label" => Yii::t('app', 'Product ID'),
        ],
        [
            "attribute" => "category_id",
            "label" => Yii::t('app', 'Category ID'),
        ],
        [
            "attribute" => "image_banner_id",
            "label" => Yii::t('app', 'Image Banner ID'),
        ],
        [
            "attribute" => "image_portrait_id",
            "label" => Yii::t('app', 'Image Portrait ID'),
        ],
        [
            "attribute" => "image_small_landscape_id",
            "label" => Yii::t('app', 'Image Small Landscape ID'),
        ],
        [
            "attribute" => "type",
            "label" => Yii::t('app', 'Type'),
        ],
        */
      [
        "class" => ActionColumn::className(),
        "header" => Yii::t('app', 'Actions'),
        "urlCreator" => function (
          $action,
          FeaturedOffer $model,
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

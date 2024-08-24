<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Products");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="product-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Product"),
      ["create"],
      ["class" => "btn btn-success"]
    ) ?>
    <?= Html::a(
      Yii::t('app', "How product prices work?"),
      ["#"],
      ["style" => 'margin-left: 12px', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#pricingModal']
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
      // Uncomment and translate these columns if needed
      [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
      ],
      [
        "attribute" => 'is_deleted',
        "format" => 'boolean',
        'label' => Yii::t('app', 'Is Deleted'),
      ],
      [
        'attribute' => 'views',
        'label' => Yii::t('app', 'Views'),
      ],
      [
        'attribute' => 'created_by_id',
        'label' => Yii::t('app', 'Created By'),
        'value' => "createdBy.username",
      ],

      [
        "class" => ActionColumn::className(),
        'template' => '{publish} {disable} {view} {update} {delete}',
        "urlCreator" => function (
          $action,
          Product $model,
          $key,
          $index,
          $column
        ) {
          return Url::toRoute([$action, "id" => $model->id]);
        },
        'header' => Yii::t('app', 'Actions'),
        'buttons' => [
          'publish' => function ($url, $model, $key) {
            return Html::a(
              '<i class="fa fa-upload" aria-hidden="true"></i>',
              ['product/mark-as-published', 'id' => $model->id],
              [
                'title' => Yii::t('app', 'Mark as Published'),
                'data-pjax' => '0',
              ]
            );
          },
          'disable' => function ($url, $model, $key) {
            return Html::a(
              '<i class="fa fa-ban" aria-hidden="true"></i>',
              ['product/mark-as-disabled', 'id' => $model->id],
              [
                'title' => Yii::t('app', 'Mark as Disabled'),
                'data-pjax' => '0',
              ]
            );
          },
        ]
      ],

    ],
  ]) ?>

</div>

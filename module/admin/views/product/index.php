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
  </p>

  <?php
  echo $this->render('_search', ['model' => $searchModel]);
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
        'attribute' => 'views',
        'label' => Yii::t('app', 'Views'),
      ],
      [
        'attribute' => 'created_by_id',
        'label' => Yii::t('app', 'Created By'),
      ],

      [
        "class" => ActionColumn::className(),
        "urlCreator" => function (
          $action,
          Product $model,
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

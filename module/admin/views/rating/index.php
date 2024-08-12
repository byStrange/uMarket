<?php

use app\models\Rating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\RatingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Ratings");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="rating-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Rating"),
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
      // Uncomment and translate the following columns if needed
      // [
      //     'attribute' => 'product_id',
      //     'label' => Yii::t('app', 'Product ID'),
      // ],
      // [
      //     'attribute' => 'user_id',
      //     'label' => Yii::t('app', 'User ID'),
      // ],

      [
        "class" => ActionColumn::className(),
        "urlCreator" => function (
          $action,
          Rating $model,
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

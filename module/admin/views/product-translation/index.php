<?php

use app\models\ProductTranslation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ProductTranslationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Product Translations");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="product-translation-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Product Translation"),
      ["create"],
      ["class" => "btn btn-success"]
    ) ?>
  </p>

  <?php
  // echo $this->render('_search', ['model' => $searchModel]);
  ?>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

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
        'attribute' => 'language_code',
        'label' => Yii::t('app', 'Language Code'),
      ],
      [
        'attribute' => 'title',
        'label' => Yii::t('app', 'Title'),
      ],
      // Uncomment and adjust if needed
      /*
        [
            'attribute' => 'product_id',
            'label' => Yii::t('app', 'Product ID'),
        ],
        */
      [
        'class' => ActionColumn::class,
        'urlCreator' => function (
          $action,
          ProductTranslation $model,
          // $key,
          // $index,
          // $column
        ) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'header' => Yii::t('app', 'Actions'),
      ],

    ],
  ]) ?>


</div>

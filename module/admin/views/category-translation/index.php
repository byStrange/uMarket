<?php

use app\models\CategoryTranslation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CategoryTranslationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Category Translations');
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="category-translation-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', 'Create Category Translation'),
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
        "attribute" => "created_at",
        "label" => Yii::t('app', 'Created At'),
      ],
      [
        "attribute" => "updated_at",
        "label" => Yii::t('app', 'Updated At'),
      ],
      [
        "attribute" => "language_code",
        "label" => Yii::t('app', 'Language Code'),
      ],
      [
        "attribute" => "name",
        "label" => Yii::t('app', 'Name'),
      ],
      // If you uncomment these, wrap them in translation as well
      // [
      //     "attribute" => "category_id",
      //     "label" => Yii::t('app', 'Category ID'),
      // ],
      // [
      //     "attribute" => "image_id",
      //     "label" => Yii::t('app', 'Image ID'),
      // ],
      [
        "class" => ActionColumn::className(),
        "urlCreator" => function ($action, CategoryTranslation $model, $key, $index, $column) {
          return Url::toRoute([$action, "id" => $model->id]);
        },
        "header" => Yii::t('app', 'Actions'),
      ],
    ],
  ]) ?>

</div>

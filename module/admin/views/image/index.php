<?php

use app\models\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ImageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Images");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="image-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t("app", "Create Image"),
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
        "attribute" => "image",
        "label" => Yii::t('app', 'Image'),
      ],

      [
        "attribute" => "alt",
        "label" => Yii::t('app', 'Alt Text'),
      ],

      [
        "class" => ActionColumn::className(),
        "template" => "{delete} {view}",
        "urlCreator" => function (
          $action,
          Image $model,
          $key,
          $index,
          $column
        ) {
          return Url::toRoute([$action, "id" => $model->id]);
        },
        "header" => Yii::t('app', 'Actions'),
      ],
    ],
  ]) ?>



</div>

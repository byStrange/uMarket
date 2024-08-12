<?php

use app\models\Coupon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CouponSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Coupons');
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="coupon-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', 'Create Coupon'),
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
        "attribute" => "code",
        "label" => Yii::t('app', 'Code'),
      ],
      [
        "attribute" => "discount_percentage",
        "label" => Yii::t('app', 'Discount Percentage'),
      ],
      [
        "attribute" => "is_active",
        "format" => 'boolean',
        "label" => Yii::t('app', 'Is Active'),
      ],
      [
        "class" => ActionColumn::className(),
        "header" => Yii::t('app', 'Actions'),
        "urlCreator" => function (
          $action,
          Coupon $model,
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

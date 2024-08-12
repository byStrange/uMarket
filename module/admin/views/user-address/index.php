<?php

use app\models\UserAddress;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\UserAddressSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "User Addresses");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="user-address-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create User Address"),
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
        'attribute' => 'label',
        'label' => Yii::t('app', 'Label'),
      ],
      [
        'attribute' => 'city',
        'label' => Yii::t('app', 'City'),
      ],
      // Uncomment and translate these columns if needed
      // [
      //     'attribute' => 'zip_code',
      //     'label' => Yii::t('app', 'Zip Code'),
      // ],
      // [
      //     'attribute' => 'delivery_point_id',
      //     'label' => Yii::t('app', 'Delivery Point ID'),
      // ],
      // [
      //     'attribute' => 'user_id',
      //     'label' => Yii::t('app', 'User ID'),
      // ],
      [
        "class" => ActionColumn::className(),
        "urlCreator" => function (
          $action,
          UserAddress $model,
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

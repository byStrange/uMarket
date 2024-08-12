<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Orders");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="order-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Order"),
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
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
        'value' => function ($model) {
          $statuses = [
            1 => Yii::t('app', 'Pending'),
            2 => Yii::t('app', 'Processing'),
            3 => Yii::t('app', 'Shipped'),
            4 => Yii::t('app', 'Delivered'),
            5 => Yii::t('app', 'Cancelled'),
          ];
          return $statuses[$model->status] ?? Yii::t('app', 'Unknown');
        },
      ],
      [
        'attribute' => 'payment_type',
        'label' => Yii::t('app', 'Payment Type'),
        'value' => function ($model) {
          $paymentTypes = Order::getPaymentTypeOptions();
          return $paymentTypes[$model->payment_type] ?? Yii::t('app', 'Unknown');
        },
      ],
      // Uncomment and adjust these fields as needed
      // [
      //     'attribute' => 'coupon_id',
      //     'label' => Yii::t('app', 'Coupon ID'),
      // ],
      // [
      //     'attribute' => 'user_id',
      //     'label' => Yii::t('app', 'User ID'),
      // ],
      // [
      //     'attribute' => 'address_id',
      //     'label' => Yii::t('app', 'Address ID'),
      // ],
      [
        "class" => ActionColumn::className(),
        "urlCreator" => function (
          $action,
          Order $model,
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

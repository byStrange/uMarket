<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\Card;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">
  <h1><?= Html::encode($this->title) ?></h1>

  <div class="row mb-4">
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => Yii::t('app', 'Total Orders'),
        'content' => Html::tag('h2', $totalOrders, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => Yii::t('app', 'Total Products'),
        'content' => Html::tag('h2', $totalProducts, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => Yii::t('app', 'Featured Offers'),
        'content' => Html::tag('h2', $featuredOffers, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => Yii::t('app', 'Active Users'),
        'content' => Html::tag('h2', $activeUsers, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <h3>Recent Orders</h3>
      <?php Pjax::begin(); ?>
      <?= GridView::widget([
        'dataProvider' => $recentOrdersProvider,
        'columns' => [
          'id',
          ["attribute" => "user.username", "label" => Yii::t('app', 'User')],
          [
            "attribute" => "total_amount",
            "label" => Yii::t('app', 'Total'),
            "value" => function ($model) {
              return $model->totalPriceAsCurrency();
            },
          ],
          ["attribute" => "created_at", "label" => Yii::t('app', 'Created At')],
          ['class' => 'yii\grid\ActionColumn', 'controller' => 'order',  'template' => '{view}'],
        ],
      ]); ?>
      <?php Pjax::end(); ?>
    </div>
    <div class="col-md-6">
      <h3>Quick Actions</h3>
      <div class="row">
        <div class="col-md-6 mb-2">
          <?= Html::a(Yii::t('app', 'Add New Product'), ['product/create'], ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a(Yii::t('app', 'View All Orders'), ['order/index'], ['class' => 'btn btn-info btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a(Yii::t('app', 'Manage Users'), ['user/index'], ['class' => 'btn btn-warning btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a(Yii::t('app', 'Update Featured Offers'), ['featured-offer/index'], ['class' => 'btn btn-success btn-block']) ?>
        </div>
      </div>
    </div>
  </div>
</div>

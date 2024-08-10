<?php

use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\Card;
use kartik\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">
  <h1><?= Html::encode($this->title) ?></h1>

  <div class="row mb-4">
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => 'Total Orders',
        'content' => Html::tag('h2', $totalOrders, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => 'Total Products',
        'content' => Html::tag('h2', $totalProducts, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => 'Featured Offers',
        'content' => Html::tag('h2', $featuredOffers, ['class' => 'text-center']),
        'options' => ['class' => 'bg-light'],
      ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php
      echo Card::widget([
        'title' => 'Active Users',
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
          'user.username',
          'total_amount:currency',
          'created_at:datetime',

          ['class' => 'yii\grid\ActionColumn', 'controller' => 'order',  'template' => '{view}'],
        ],
      ]); ?>
      <?php Pjax::end(); ?>
    </div>
    <div class="col-md-6">
      <h3>Quick Actions</h3>
      <div class="row">
        <div class="col-md-6 mb-2">
          <?= Html::a('Add New Product', ['product/create'], ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a('View All Orders', ['order/index'], ['class' => 'btn btn-info btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a('Manage Users', ['user/index'], ['class' => 'btn btn-warning btn-block']) ?>
        </div>
        <div class="col-md-6 mb-2">
          <?= Html::a('Update Featured Offers', ['featured-offer/index'], ['class' => 'btn btn-success btn-block']) ?>
        </div>
      </div>
    </div>
  </div>
</div>

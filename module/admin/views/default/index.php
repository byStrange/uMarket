<?php

use app\models\FeaturedOffer;
use app\models\Product;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\Card;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('./_inconsistent_info_modals.php') ?>
<div class="admin-dashboard">
  <h1><?= Html::encode($this->title) ?></h1>
  <?php if ( $offer_inconsisties && count($offer_inconsisties)): ?>
    <div class="alert alert-warning">
      <h4 class="alert-heading">
        Inconsistent data
      </h4>
      <p>There are few inconsistent data that has already been stored in the database, few things might not work as expected. You may want to make some changes to make this warning disappar.</p>
      <?php foreach ($offer_inconsisties as $inc): ?>
        <hr />
        <?php if ($inc['type'] === FeaturedOffer::INCONSISTY_DUPLICATE_OFFER_FOR_A_PRODUCT): ?>
          <p class="mb-1">
            There are some products that has duplicate offers: <a href="#" data-bs-toggle="modal" data-bs-target="#<?= FeaturedOffer::INCONSISTY_DUPLICATE_OFFER_FOR_A_PRODUCT ?>">[[Learn more]]</a>

          </p>
          <div class="d-flex flex-column mb-2">
            <?php foreach ($inc['data'] as $product): ?>
              <?= Html::a($product, Url::toRoute(['product/view', 'id' => $product->id])) ?>
            <?php endforeach ?>
          </div>
        <?php elseif ($inc['type'] === FeaturedOffer::INCONSISTY_INACTIVE_PRODUCT_INCLUDED): ?>
          <p class="mb-1">There are some products that were not published yet but included in the featured offer: <a href="#" data-bs-toggle="modal" data-bs-target="#<?= FeaturedOffer::INCONSISTY_INACTIVE_PRODUCT_INCLUDED ?>">[[Learn more]]</a></p>
          <div class="d-flex flex-column mb-2">
            <?php foreach ($inc['data'] as $product): ?>
              <?= Html::a($product, Url::toRoute(['product/view', 'id' => $product->id])) ?>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </div>
  <?php endif ?>

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
        'content' => Html::tag('h2', '<span title="' . Yii::t('app', 'published products') . '">'  . count(Product::toOptionsList()) . '</span>' . '/' . $totalProducts, ['class' => 'text-center']),
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
      <h3><?= Yii::t("app", "Recent Orders") ?></h3>
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

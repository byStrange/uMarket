<?php

use app\components\Utils;
use app\models\Product;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\View;
use yii\widgets\LinkPager;

/** @var Product[] $products */
/** @var Sort $sort */
/** @var View $view */
/** @var Pagination $pagination */
/** @var number $totalCount */
/** @var bool $swiperEnabled */


$css = <<<CSS
.pagination {
  justify-content: flex-end;
}

.pagination :is(.next,.prev).disabled {
  display: none;
}
CSS;
$view->registerCss($css);

if (isset($sort)) {
  global $currentFilterDisplay;
  $currentFilterDisplay = $sort->getAttributeOrders() ? array_keys($sort->getAttributeOrders())[0] : '';
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- Shop Top Area Start -->
      <div class="shop-top-bar d-flex">
        <?php if (isset($totalCount)): ?>
          <p class="compare-product"><?= Yii::t('app', '{count} Product Found of {totalCount}', ['count' => count($products), 'totalCount' => $totalCount]) ?></p>
        <?php endif ?>
        <!-- Left Side End -->
        <!-- Right Side Start -->

        <?php if (isset($sort)) : ?>
          <div class="select-shoing-wrap d-flex align-items-center">
            <div class="shot-product">
              <p><?= Yii::t('app', 'Sort By') ?>:</p>
            </div>

            <!-- Single Wedge End -->
            <div class="header-bottom-set dropdown">
              <button class="dropdown-toggle header-action-btn" data-bs-toggle="dropdown"><?= $currentFilterDisplay ? ucwords($currentFilterDisplay) : Yii::t('app', 'Default') ?><i class="fa fa-angle-down"></i></button>

              <ul class="dropdown-menu dropdown-menu-right">
                <li><?= Utils::renderSortLink('price', '', Yii::t('app', 'Price, low to high'), $sort, SORT_DESC) ?></li>
                <li><?= Utils::renderSortLink('price', Yii::t('app',  'Price, high to low'), '', $sort, SORT_ASC) ?></li>
                <li><?= Utils::renderSortLink('id', Yii::t('app', 'Sort By old'), '', $sort, SORT_ASC) ?></li>
                <li><?= Utils::renderSortLink('id', '', Yii::t('app',  'Sort By new'), $sort, SORT_DESC) ?></li>
              </ul>
            </div>
            <!-- Single Wedge Start -->
          </div>
          <!-- Right Side End -->
        <?php endif ?>
      </div>
      <!-- Shop Top Area End -->
      <!-- Shop Bottom Area Start -->
      <div class="shop-bottom-area">
        <!-- Tab Content Area Start -->
        <div class="row">
          <div class="col">
            <?php if (isset($swiperEnabled)) : ?>
              <div class="new-product-slider swiper-container slider-nav-style-1">
                <div class="swiper-wrapper">
                  <?php foreach ($products as $product) : ?>
                    <div class="swiper-slide">
                      <?= $this->render("@app/components/product/_product_card", ["product" => $product, "wrappedInCol" => false]); ?>
                    </div>
                  <?php endforeach ?>
                </div>
                <div class="swiper-buttons">
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
          </div>
        <?php else: ?>
          <div class="row mb-n-30px">
            <?php foreach ($products as $product) {
                echo $this->render("@app/components/product/_product_card", ["product" => $product]);
              } ?>
          </div>
        <?php endif ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Tab Content Area End -->
  <!--  Pagination Area Start -->
  <style>
    .pro-pagination-style li.active a {
      color: #266bf9;
      border-color: #266bf9;
      background: #fff;
    }
  </style>
  <?php if (isset($pagination)): ?>
    <div class="pro-pagination-style text-center text-lg-end" data-aos="fade-up" data-aos-delay="200">
      <div class="pages">
        <?= LinkPager::widget(["pagination" => $pagination,]) ?>
      </div>
    </div>
  <?php endif ?>
  <!--  Pagination Area End -->
</div>

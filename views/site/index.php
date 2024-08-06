<?php

/** @var yii\web\View $this */

use app\components\home\OffCanvasList;
use app\models\Product;

/** @var Product[] $products */

$this->title = "My Yii Application";
?>
<div>

  <!-- OffCanvas menus start -->
  <!-- OffCanvas menus End -->
  <!-- Hero/Intro Slider Start -->
  <?= $this->render("@app/components/home/HeroIntroSlider", [
    "featuredOffers" => $featuredOffers,
  ]) ?>
  <!-- Hero/Intro Slider End -->
  <!-- Banner Area Start -->
  <div class="banner-area style-one pt-100px pb-100px">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="single-banner nth-child-1">
            <img src="/images/banner/3.webp" alt="">
            <div class="banner-content nth-child-1">
              <h3 class="title">Smart Watch For <br>
                Your Hand</h3>
              <span class="category">From $29.00</span>
              <a href="shop-left-sidebar.html" class="shop-link"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="single-banner nth-child-2 mb-30px mb-lm-30px mt-lm-30px ">
            <img src="/images/banner/4.webp" alt="">
            <div class="banner-content nth-child-2">
              <h3 class="title">Headphones</h3>
              <span class="category">From $95.00</span>
              <a href="shop-left-sidebar.html" class="shop-link"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
          </div>
          <div class="single-banner nth-child-2">
            <img src="/images/banner/5.webp" alt="">
            <div class="banner-content nth-child-3">
              <h3 class="title">Smartphone</h3>
              <span class="category">From $69.00</span>
              <a href="shop-left-sidebar.html" class="shop-link"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Banner Area End -->
  <!-- Product Area Start -->
  <?= $this->render("@app/components/product/HomeProductsList", [
    "products" => $products,
    "famous8" => $famous8,
    "view" => &$this,
  ]) ?>
  <!-- Product Area End -->
  <!-- Fashion Area Start -->
  <div class="fashion-area" data-bg-image="/images/fashion/fashion-bg.webp">
    <div class="container h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 text-center">
          <h2 class="title"> <span>Smart Fashion</span> With Smart Devices </h2>
          <a href="/shop" class="btn btn-primary text-capitalize m-auto">Shop All Devices</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Fashion Area End -->
  <!-- Feature product area start -->
  <?= $this->render('@app/components/home/FeaturedOffers', ["featuredOffers" => $featuredOffers, "view" => $this]) ?>
  <!-- Feature product area End -->
</div>

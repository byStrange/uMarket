<?php

use app\models\FeaturedOffer;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var FeaturedOffer[] $featuredOffers **/
?>

<div class="section">
  <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1 swiper-container-fade swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
    <!-- Hero slider Active -->
    <div class="swiper-wrapper" style="transition-duration: 0ms;" id="swiper-wrapper-4eab022c2bedd1c6" aria-live="off">
      <!-- Single slider item -->
      <?php foreach ($featuredOffers as $offer): ?>
        <?= $offer->image_portrait ?>
        <div class="hero-slide-item slider-height-2 swiper-slide bg-color1 swiper-slide-prev swiper-slide-duplicate-next" data-bg-image="/images/hero/bg/hero-bg-2-1.webp" style="background-image: url(&quot;/images/hero/bg/hero-bg-2-1.webp&quot;); width: 1144px; transition-duration: 0ms; opacity: 1; transform: translate3d(-1144px, 0px, 0px);" data-swiper-slide-index="0" role="group" aria-label="2 / 4">
          <div class="container h-100">
            <div class="row h-100 flex-row-reverse">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                <div class="hero-slide-content hero-slide-content-2 slider-animated-1">
                  <h2 class="title-1"><?= $offer->title ?></h2>
                  <span class="price">
                    <span class="mini-title">
                      <?= $offer->type == "product"
                          ? "Only"
                          : ($offer->type == "category"
                              ? "Starting from"
                              : "") ?>
                    </span>
                    <span class="amount"><?= (int) $offer->dicount_price ?></span>
                  </span>
                  <?php
                  $url =
                      $offer->type == "product"
                          ? ["shop/product", "id" => $offer->product->id]
                          : ($offer->type == "category"
                              ? ["shop/category", "id" => $offer->category->id]
                              : "#");
                  echo Html::a("Shop", Url::toRoute($url), [
                      "class" => "btn btn-primary text-capitalize",
                  ]);
                  ?>
                  <!--<a href="shop-left-sidebar.html" class="">Shop</a>-->
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-center">
                <div class="show-case">
                  <div class="hero-slide-image slider-2">
                    <?= Html::img($offer->image_portrait, [
                        "id" => $offer->image_portrait,
                    ]) ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <!-- Single slider item -->
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-white"></div>
    <!-- Add Arrows -->
    <div class="swiper-buttons">
      <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-4eab022c2bedd1c6"></div>
      <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-4eab022c2bedd1c6"></div>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
  </div>
</div>

<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var Product $product **/

$this->title = "Product detail";
$this->params["breadcrumbs"][] = $this->title;
$translatedProduct = $product->getProductTranslationForLanguage(
    Yii::$app->language
);
?>


<div class="product-details-area pt-100px pb-100px">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
        <div class="product-details-img product-details-tab product-details-tab-2 product-details-tab-3 d-flex">
          <div class="swiper-container ml-15px zoom-thumbs-2 align-self-start slider-nav-style-1 small-nav swiper-container-initialized swiper-container-vertical swiper-container-pointer-events swiper-container-free-mode swiper-container-thumbs">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;" id="swiper-wrapper-cc596741fbc110c58" aria-live="polite">
              <div class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-thumb-active" style="height: 77.6px; margin-bottom: 20px;" role="group" aria-label="1 / 5">
                <img class="img-responsive m-auto" src="/images/product-image/small-image/1.webp" alt="">
              </div>
              <div class="swiper-slide swiper-slide-visible swiper-slide-next" style="height: 77.6px; margin-bottom: 20px;" role="group" aria-label="2 / 5">
                <img class="img-responsive m-auto" src="/images/product-image/small-image/2.webp" alt="">
              </div>
              <div class="swiper-slide swiper-slide-visible" style="height: 77.6px; margin-bottom: 20px;" role="group" aria-label="3 / 5">
                <img class="img-responsive m-auto" src="/images/product-image/small-image/3.webp" alt="">
              </div>
              <div class="swiper-slide swiper-slide-visible" style="height: 77.6px; margin-bottom: 20px;" role="group" aria-label="4 / 5">
                <img class="img-responsive m-auto" src="/images/product-image/small-image/4.webp" alt="">
              </div>
              <div class="swiper-slide swiper-slide-visible" style="height: 77.6px; margin-bottom: 20px;" role="group" aria-label="5 / 5">
                <img class="img-responsive m-auto" src="/images/product-image/small-image/5.webp" alt="">
              </div>
            </div>
            <!-- Add Arrows -->
            <!-- <div class="swiper-buttons">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div> -->
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
          </div>
          <!-- Swiper -->
          <div class="swiper-container zoom-top-2 align-self-start swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
            <div class="swiper-wrapper" style="transform: translate3d(-383px, 0px, 0px); transition-duration: 0ms;" id="swiper-wrapper-6a7cadb9fd93b213" aria-live="polite">
              <div class="swiper-slide swiper-slide-duplicate swiper-slide-prev" data-swiper-slide-index="4" style="width: 383px;" role="group" aria-label="1 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/5.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/5.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0" style="width: 383px;" role="group" aria-label="2 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/1.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/1.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide swiper-slide-next" data-swiper-slide-index="1" style="width: 383px;" role="group" aria-label="3 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/2.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/2.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide" data-swiper-slide-index="2" style="width: 383px;" role="group" aria-label="4 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/3.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/3.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide" data-swiper-slide-index="3" style="width: 383px;" role="group" aria-label="5 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/4.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/4.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide swiper-slide-duplicate-prev" data-swiper-slide-index="4" style="width: 383px;" role="group" aria-label="6 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/5.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/5.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
              <div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="0" style="width: 383px;" role="group" aria-label="7 / 7">
                <img class="img-responsive m-auto" src="/images/product-image/zoom-image/1.webp" alt="">
                <a class="venobox full-preview vbox-item" data-gall="myGallery" href="/images/product-image/zoom-image/1.webp">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
        <div class="product-details-content quickview-content ml-25px">
          <h2><?= $translatedProduct->title ?></h2>
          <div class="pricing-meta">
            <ul class="d-flex">
              <li class="new-price"><?= Yii::$app->formatter->asCurrency(
                  $product->price
              ) ?></li>
            </ul>
          </div>
          <div class="pro-details-rating-wrap">
            <div class="rating-product">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </div>
            <span class="read-review"><a class="reviews" href="#">(5 Customer Review)</a></span>
          </div>
          <p class="mt-30px"><?= StringHelper::truncateWords(
              $translatedProduct->description,
              20,
              "..."
          ) ?></p>
          <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
            <span>Categories: </span>
            <ul class="d-flex">
              <li>
                <a href="#">Smart Device, </a>
              </li>
              <li>
                <a href="#">ETC</a>
              </li>
            </ul>
          </div>
          <div class="pro-details-quality">
            <div class="cart-plus-minus">
              <div class="dec qtybutton">-</div>
              <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
              <div class="inc qtybutton">+</div>
            </div>
            <div class="pro-details-cart">
              <button class="add-cart"> Add To
                Cart</button>
            </div>
            <div class="pro-details-compare-wishlist pro-details-wishlist ">
              <a href="wishlist.html"><i class="pe-7s-like"></i></a>
            </div>
          </div>
        </div>
        <!-- product details description area start -->
        <div class="description-review-wrapper">
          <div class="description-review-topbar nav">
            <button class="active" data-bs-toggle="tab" data-bs-target="#des-details1">Description</button>
            <button data-bs-toggle="tab" data-bs-target="#des-details3">Reviews (<?= count(
                $product->ratings
            ) ?>)</button>
          </div>
          <div class="tab-content description-review-bottom">
            <div id="des-details1" class="tab-pane active">
              <div class="product-description-wrapper">
                <p><?= $translatedProduct->description ?></p>
              </div>
            </div>
            <div id="des-details3" class="tab-pane">
              <div class="row">
                <div class="col-lg-12">
                  <div class="review-wrapper">
                    <?php foreach ($product->ratings as $rating): ?>
                      <div class="single-review">
                        <div class="review-img">
                          <?= Html::img(
                              $rating->user->profile_picture
                                  ? $rating->user->profile_picture
                                  : "/images/review-image/1.png"
                          ) ?>
                        </div>
                        <div class="review-content">
                          <div class="review-top-wrap">
                            <div class="review-left">
                              <div class="review-name">
                                <h4><?= $rating->user->first_name ?></h4>
                              </div>
                              <div class="rating-product">
                                <?php for (
                                    $i = 0;
                                    $i < $rating->score;
                                    $i++
                                ): ?>
                                  <i class="fa fa-star"></i>
                                <?php endfor; ?>
                              </div>
                            </div>
                          </div>
                          <div class="review-bottom">
                            <p><?= $rating->comment ?></p>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="ratting-form-wrapper pl-50">
                    <h3>Add a Review</h3>
                    <div class="ratting-form">
                      <form action="#">
                        <div class="star-box">
                          <span>Your rating:</span>
                          <div class="rating-product">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="rating-form-style">
                              <input placeholder="Name" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="rating-form-style">
                              <input placeholder="Email" type="email">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="rating-form-style form-submit">
                              <textarea name="Your Review" placeholder="Message"></textarea>
                              <button class="btn btn-primary btn-hover-color-primary " type="submit" value="Submit">Submit</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- product details description area end -->
      </div>
    </div>
  </div>
</div>

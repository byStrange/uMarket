<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var Product $product **/

$translatedProduct = $product->getProductTranslationForLanguage(
  Yii::$app->language
);

?>


<div class="container product-details-area">
  <div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
      <div class="product-details-img product-details-tab product-details-tab-2 product-details-tab-3 d-flex">
        <div class="swiper-container ml-15px zoom-thumbs-2 align-self-start slider-nav-style-1 small-nav">
          <div class="swiper-wrapper">
            <?php foreach ($product->images as $image) : ?>
              <div class="swiper-slide">
                <img class="img-responsive m-auto" src="/<?= $image->image ?>" alt="">
              </div>
            <?php endforeach ?>
          </div>
          <!-- Add Arrows -->
          <!-- <div class="swiper-buttons">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div> -->
        </div>
        <!-- Swiper -->
        <div class="swiper-container zoom-top-2 align-self-start">
          <div class="swiper-wrapper">

            <?php foreach ($product->images as $image): ?>
              <div class="swiper-slide">
                <img class="img-responsive m-auto" src="/<?= $image->image ?>" alt="">
                <a class="venobox full-preview" data-gall="myGallery" href="/<?= $image->image ?>">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </a>
              </div>
            <?php endforeach ?>

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
      <div class="product-details-content quickview-content ml-25px">
        <h2><?= $translatedProduct->title ?></h2>
        <div class="pricing-meta">
          <ul class="d-flex">
            <li class="new-price"><?= $product->priceAsCurrency() ?> <span class="text-muted text-decoration-line-through"><?= Yii::$app->formatter->asCurrency($product->price) ?></span></li>
          </ul>
        </div>
        <p class="mt-30px"><?= StringHelper::truncateWords(
                              $translatedProduct->description,
                              20,
                              "..."
                            ) ?></p>
        <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
          <span>Categories: </span>
          <ul class="d-flex">
            <?php foreach ($product->categories as $category): ?>
              <li>
                <a href="<?= Url::toRoute(['shop/category', 'id' => $category->id]) ?>"><?= $category ?> </a>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
        <div class="pro-details-quality">
          <input type="hidden" value="<?= $product->id ?>" name="id" id="productIdInput" />

          <div class="cart-plus-minus">
            <div class="dec qtybutton">-</div>
            <input class="cart-plus-minus-box" type="text" value="1" name="quantity" id="quantityInput">
            <div class="inc qtybutton">+</div>
          </div>

          <div class="pro-details-cart">
            <button
              data-bs-toggle="modal"
              data-bs-target="#cartModal"
              hx-target="#cartModal .modal-content"
              hx-trigger="click"
              hx-post="<?= Url::toRoute(['cart/add-to-cart']) ?>"
              hx-include='#productIdInput, #quantityInput'
              class="add-cart">
              Add To Cart
            </button>
          </div>

          <div class="pro-details-compare-wishlist pro-details-wishlist">
            <a
              data-bs-toggle="modal"
              data-bs-target="#cartModal"
              hx-target="#cartModal .modal-content"
              hx-trigger="click"
              hx-post="<?= Url::toRoute(['cart/add-to-wishlist']) ?>"
              hx-vals='{ "id": <?= $product->id ?> }'
              href="#">

              <?php if ($product->isOnTheWishlist()): ?>
                <svg id="wishlist-icon-<?= $product->id ?>" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red" />
                </svg>
              <?php else: ?>
                <i class="pe-7s-like" id="wishlist-icon-<?= $product->id ?>"></i>
              <?php endif ?>
            </a>
          </div>
        </div>
      </div>
      <!-- product details description area start -->
      <?php if ($detailed): ?>
        <div class="description-review-wrapper">
          <div class="description-review-topbar nav">
            <button class="active" data-bs-toggle="tab" data-bs-target="#des-details1">Description</button>
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
                  <div class="ratting-form-wrapper pl-50 pt-0">
                    <h3>Add a Review</h3>
                    <?php if (Yii::$app->user->isGuest): ?>
                      <p class="my-3">You must be logged in to be able to write reviews </p>
                      <a href="/site/login">Login</a>
                    <?php else: ?>
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
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>
      <!-- product details description area end -->
    </div>
  </div>
</div>

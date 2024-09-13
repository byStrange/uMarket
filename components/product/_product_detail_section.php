<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var Product $product **/

$translatedProduct = $product->getProductTranslationForLanguage(
  Yii::$app->language
);
$js = <<<JS
function initRatingField() {
  $(document).ready(function() {
      $('.rating-product .fa-star').on('click', function() {
          var rating = $(this).data('rating');
          $('#rating-score').val(rating);
          $('.rating-product .fa-star').removeClass('active');
          $(this).prevAll().addBack().addClass('active');
      });
  });
}
window.initRatingField = initRatingField;
JS;
$this->registerJs($js);

/** @var User $user */
$user = Yii::$app->user->identity;
?>
<style>
  .rating-product .rating-star.fa-star {
    cursor: pointer;
    color: gray !important;
  }

  .rating-product .fa-star.active {
    color: #f8d000 !important;
  }
</style>

<div class="container product-details-area">
  <div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
      <div class="product-details-img product-details-tab product-details-tab-2 product-details-tab-3 d-flex">
        <div class="swiper-container ml-15px zoom-thumbs-2 align-self-start slider-nav-style-1 small-nav">
          <div class="swiper-wrapper">

            <?php if ($product->images && count($product->images)): ?>
              <?php foreach ($product->images as $image) : ?>
                <div class="swiper-slide">
                  <img class="img-responsive m-auto" src="/<?= $image->image ?>" alt="">
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <img class="img-responsive m-auto" src="https://placehold.co/485" alt="">
            <?php endif ?>

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

            <?php if ($product->images && count($product->images)): ?>
              <?php foreach ($product->images as $image) : ?>
                <div class="swiper-slide">
                  <img class="img-responsive m-auto" src="/<?= $image->image ?>" alt="">
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <img class="img-responsive m-auto" src="https://placehold.co/485" alt="">
            <?php endif ?>

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
      <div class="product-details-content quickview-content ml-25px">
        <h2><?= $translatedProduct->title ?></h2>
        <div class="pricing-meta">
          <ul class="d-flex">

            <?php if ($product->comparisonPrice()): ?>
              <li class="new-price">
                <?= $product->comparisonPrice()["price"] ?>
                <span class="text-muted text-decoration-line-through"> <?= $product->comparisonPrice()["discount_price"] ?> </span>
              </li>
            <?php else: ?>
              <li class="new-price"><?= $product->priceAsCurrency() ?></li>
            <?php endif ?>
          </ul>
        </div>
        <p class="mt-30px"><?= StringHelper::truncateWords(
                              $translatedProduct->description,
                              20,
                              "..."
                            ) ?></p>
        <?php if ($product->categories && count($product->categories)): ?>
          <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
            <span><?= Yii::t('app', 'Categories') ?>:</span>
            <ul class="d-flex">
              <?php foreach ($product->categories as $category): ?>
                <li>
                  <a href="<?= Url::toRoute(['shop/category', 'id' => $category->id]) ?>"><?= $category ?> </a>
                </li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>
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
              <?= Yii::t('app', 'Add To Cart') ?>
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
                <svg class="wishlist-icon-<?= $product->id ?>" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red" />
                </svg>
              <?php else: ?>
                <i class="pe-7s-like wishlist-icon-<?= $product->id ?>"></i>
              <?php endif ?>
            </a>
          </div>
        </div>
      </div>
      <!-- product details description area start -->
      <?php if ($detailed): ?>
        <div class="description-review-wrapper">
          <div class="description-review-topbar nav">

            <?php if (count($product->specifications)): ?>
              <button data-bs-toggle="tab" data-bs-target="#des-details2"><?= Yii::t('app', 'Specifications') ?></button>
            <?php endif ?>

            <button class="active" data-bs-toggle="tab" data-bs-target="#des-details1"><?= Yii::t('app', 'Description') ?></button>
            <button data-bs-toggle="tab" data-bs-target="#des-details3"><?= Yii::t('app', 'Reviews') ?></button>
          </div>
          <div class="tab-content description-review-bottom">
            <div id="des-details1" class="tab-pane active">
              <div class="product-description-wrapper">
                <p><?= $translatedProduct->description ?></p>
              </div>
            </div>
            <?php if (count($product->specifications)): ?>
              <div id="des-details2" class="tab-pane">
                <div class="product-anotherinfo-wrapper text-start">
                  <ul>
                    <?php foreach ($product->specifications as $specification): ?>
                      <li><span><?= $specification->spec_key ?>:</span> <span><?= $specification->spec_value ?></span></li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
            <?php endif ?>
            <div id="des-details3" class="tab-pane">
              <div class="row">
                <div class="col-lg-12">
                  <div class="review-wrapper">
                    <?php foreach ($product->ratings as $rating): ?>
                      <div class="single-review">
                        <div class="review-img">
                          <?= Html::img(
                            $rating->user->profile_picture
                              ? '/' . $rating->user->profile_picture
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
                        <?php if ($user && $user->id === $rating->user_id): ?>
                          <div style="margin-left: 24px;">
                            <button
                              data-bs-toggle="modal"
                              data-bs-target="#cartModal"
                              hx-get="<?= Url::to(['admin/rating/update', 'id' => $rating->id, 'd' => true]) ?>"
                              hx-target="#cartModal .modal-content"
                              class="text-decoration-underline">
                              <?= Yii::t('app', 'Edit') ?>
                            </button>
                          </div>
                        <?php endif ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class=" col-lg-12">
                  <div class="ratting-form-wrapper pl-50 pt-0">
                    <h3><?= Yii::t('app', 'Add a Review') ?></h3>
                    <?php if (Yii::$app->user->isGuest): ?>
                      <p class="my-3"><?= Yii::t('app', 'You must be logged in to be able to write reviews ') ?></p>
                      <a href="/site/login"><?= Yii::t('app', 'Login') ?></a>
                    <?php elseif ($user->hasRated($product->id)): ?>
                      <p class="my-3"><?= Yii::t('app', 'You have already rated this product') ?></p>
                    <?php else: ?>
                      <?= $this->render('@app/components/product/_product_detail_section__rating_form', ["review_model" => $review_model]) ?>
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

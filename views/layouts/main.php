<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\components\home\Footer;
use app\components\home\Header;
use app\components\home\offcanvas\OffCanvasMobileMenu;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(["charset" => Yii::$app->charset], "charset");
$this->registerMetaTag([
  "name" => "viewport",
  "content" => "width=device-width, initial-scale=1, shrink-to-fit=no",
]);
$this->registerMetaTag([
  "name" => "description",
  "content" => $this->params["meta_description"] ?? "",
]);
$this->registerMetaTag([
  "name" => "keywords",
  "content" => $this->params["meta_keywords"] ?? "",
]);
$this->registerLinkTag([
  "rel" => "icon",
  "type" => "image/x-icon",
  "href" => Yii::getAlias("@web/favicon.ico"),
]);
$this->registerJsFile("@web/js/vendor/bootstrap.bundle.min.js");

$script = <<<JS
function reloadScript(url, callback) {
  var existingScript = document.querySelector(`script[src=" + url + "]`);

  if (existingScript) {
    existingScript.parentNode.removeChild(existingScript);
  }

  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = url + '?v=' + new Date().getTime();

  script.onload = callback;

  document.head.appendChild(script);
}

document.addEventListener('htmx:afterSettle', function(event) {
  if (event.detail.requestConfig.elt.classList.contains('quickview')) reloadScript('/js/main.min.js')
});
JS;
$this->registerJs($script, View::POS_HEAD);

$script = <<<JS
$(function () {
  $(document).on('htmx:afterOnLoad', function (event) {
    var response = event.detail.xhr.response; 
    const parser = new DOMParser();
    var doc = parser.parseFromString(response, 'text/html')
    var body = $(doc.body);
    var wrapper = body.children().first()
    var id = wrapper.attr('data-id');
    var action = wrapper.attr('data-action')
    var heartIconSvg = `<svg id="wishlist-icon-` + id + `" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red"/>
</svg>`
    var likeButton = $('#wishlist-icon-' + id);
    var likeButtonHtml = '<i class="pe-7s-like" id="wishlist-icon-' + id + '"' + '></i>'

    switch (action) {
      case 'addToWishlist':
        likeButton.replaceWith(heartIconSvg)
        break;

      case 'removeFromWishList':
        likeButton.replaceWith(likeButtonHtml)

        var removedWishlistItem =  $('#wishlistitem-' + id);
        console.log(removedWishlistItem)
        removedWishlistItem.slideUp()
        break;

      case 'removeFromCart':
        var removedCartItem = $('.cartitem-' + id); 
        removedCartItem.slideUp();
        break;
    }
  })
});
JS;
$this->registerJs($script);


$style = <<<CSS
.pe-7s-like.liked {
  text-shadow: 2px 2px red, -2px -2px blue, -2px 0 red, 0 -2px blue;
}
CSS;
$this->registerCss($style);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head(); ?>
  <link rel="stylesheet" href="/css/style.min.css" />
</head>

<body>
  <?php $this->beginBody(); ?>
  <?= Header::widget() ?>
  <main class="main-wrapper">
    <?php if (!empty($this->params["breadcrumbs"])): ?>
      <div class="breadcrumb-area">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
              <h2 class="breadcrumb-title"><?= $this->title ?></h2>
              <?= Breadcrumbs::widget([
                "options" => [
                  "class" => "breadcrumb-list",
                ],
                "itemTemplate" => "<li class=\"breadcrumb-item\">{link}</li>",
                "activeItemTemplate" =>
                "<li class=\"breadcrumb-item active\">{link}</li>",
                "links" => $this->params["breadcrumbs"],
                "homeLink" => ["url" => "/", "label" => "Home"],
              ]) ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?= $content; ?>
  </main>
  <?= Footer::widget() ?>


  <!-- Modal -->
  <div class="modal modal-2 fade" id="productDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content p-4">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i class="pe-7s-close"></i></button>
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
              <!-- Swiper -->
              <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/zoom-image/1.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/zoom-image/2.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/zoom-image/3.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/zoom-image/4.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/zoom-image/5.webp" alt="">
                  </div>
                </div>
              </div>
              <div class="swiper-container gallery-thumbs mt-20px slider-nav-style-1 small-nav">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/small-image/1.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/small-image/2.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/small-image/3.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/small-image/4.webp" alt="">
                  </div>
                  <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="/images/product-image/small-image/5.webp" alt="">
                  </div>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-buttons">
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
              <div class="product-details-content quickview-content">
                <h2>Modern Smart Phone</h2>
                <div class="pricing-meta">
                  <ul class="d-flex">
                    <li class="new-price">$20.90</li>
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
                  <span class="read-review"><a class="reviews" href="#">( 2 Review )</a></span>
                </div>
                <p class="mt-30px">Lorem ipsum dolor sit amet, consecte adipisicing elit, sed do eiusmll tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mill veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exet commodo consequat. Duis aute irure dolor</p>
                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                  <span>SKU:</span>
                  <ul class="d-flex">
                    <li>
                      <a href="#">Ch-256xl</a>
                    </li>
                  </ul>
                </div>
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
                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                  <span>Tags: </span>
                  <ul class="d-flex">
                    <li>
                      <a href="#">Smart Device, </a>
                    </li>
                    <li>
                      <a href="#">Phone</a>
                    </li>
                  </ul>
                </div>
                <div class="pro-details-quality">
                  <div class="cart-plus-minus">
                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                  </div>
                  <div class="pro-details-cart">
                    <button class="add-cart"> Add To
                      Cart</button>
                  </div>
                  <div class="pro-details-compare-wishlist pro-details-wishlist ">
                    <a href="wishlist.html"><i class="pe-7s-like"></i></a>
                  </div>
                </div>
                <div class="payment-img">
                  <a href="#"><img src="/images/icons/payment.png" alt=""></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal end -->
  <!-- Modal Cart -->
  <div class="modal customize-class fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"></div>
    </div>
  </div>
  <!-- Modal wishlist -->
  <div class="modal customize-class fade" id="exampleModal-Wishlist" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
          <div class="tt-modal-messages">
            <i class="pe-7s-check"></i> Added to Wishlist successfully!
          </div>
          <div class="tt-modal-product">
            <div class="tt-img">
              <img src="/images/product-image/1.webp" alt="Modern Smart Phone">
            </div>
            <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal compare -->
  <div class="modal customize-class fade" id="exampleModal-Compare" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
          <div class="tt-modal-messages">
            <i class="pe-7s-check"></i> Added to compare successfully!
          </div>
          <div class="tt-modal-product">
            <div class="tt-img">
              <img src="/images/product-image/1.webp" alt="Modern Smart Phone">
            </div>
            <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="offcanvas-overlay"></div>
  <?= $this->render('@app/components/home/offcanvas/OffCanvasWishList', ['view' => &$this]) ?>
  <?= $this->render('@app/components/home/offcanvas/OffCanvasCart', ['view' => &$this]) ?>
  <?php echo OffCanvasMobileMenu::widget(); ?>
  <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>

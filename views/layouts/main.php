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
$(document).on("htmx:afterOnLoad", function afterCartItemRemove(event) {
  const contentType = event.detail.xhr
    .getResponseHeader("Content-Type")
    .split(";")[0];
  var response = event.detail.xhr.response;
  var id, action, cartGrandTotal, cartTotal, cartItemsCount, wishlistItemsCount;
  if (contentType === "application/json") {
    var { id, action, cartGrandTotal, cartTotal, cartItemsCount } =
      JSON.parse(response);
  } else if (contentType === "text/html") {
    const parser = new DOMParser();
    var doc = parser.parseFromString(response, "text/html");
    var body = $(doc.body);
    var wrapper = body.children().first();
    id = wrapper.attr("data-id");
    action = wrapper.attr("data-action");
    wishlistItemsCount = wrapper.attr('data-wishlistItemsCount')
  }

  var heartIconSvg =
    `<svg class="wishlist-icon-` +
    id +
    `" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red"/>
</svg>`;
  var likeButton = $(".wishlist-icon-" + id);
  console.log(document.querySelectorAll('#wishlist-icon-' + id));
  console.log(likeButton);
  var likeButtonHtml =
    '<i class="pe-7s-like wishlist-icon-' + id + '"' + "></i>";

  switch (action) {
    case "addToWishlist":
      likeButton.replaceWith(heartIconSvg);
      break;

    case "removeFromWishList":
      likeButton.replaceWith(likeButtonHtml);
      removeFromWishList({ id, wishlistItemsCount })
      break;

    case "removeFromCart":
      var removedCartItem = $(".cartitem-" + id);

      if (window.changeCartTotal)
        changeCartTotal({ cartGrandTotal, cartTotal }, cartItemsCount);

      removedCartItem.slideUp();
      break;

    case "applyCoupon":
      var { coupon, couponDiscountAmountAsCurrency, cartGrandTotal } = JSON.parse(response);
      applyCoupon({ coupon, couponDiscountAmountAsCurrency, cartGrandTotal });
      break;

    case "createUserAddress":
      var { ok, model, message } = JSON.parse(response);
      $('#cartModal .modal-content').html('<div class="modal-body text-center"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button><div class="tt-modal-messages"> <i class="pe-7s-check"></i>' + message + "</div></div>");
      $('#cartModal').modal('show')
      if (ok) insertNewBillingAddress(model)
    break;

    case "removeUserAddres":
      var { ok, id, message } = JSON.parse(response)
      $('#cartModal .modal-content').html('<div class="modal-body text-center"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button><div class="tt-modal-messages"> <i class="pe-7s-check"></i>' + message + "</div></div>");
      $('#cartModal').modal('show');
      if (ok) removeBillingAddress(id);

    break;

  }
  window.afterCartItemRemove = afterCartItemRemove;
});
JS;
$this->registerJs($script);


$style = <<<CSS
.pe-7s-like.liked {
  text-shadow: 2px 2px red, -2px -2px blue, -2px 0 red, 0 -2px blue;
}
.breadcrumb-area {
  background: ghostwhite !important;
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
  <link rel="stylesheet" href="/css/style.css" />
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

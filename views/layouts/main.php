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
$this->registerJsFile('@web/js/realtime-dataload.js', ['depends' => [\yii\web\JqueryAsset::class]]);


$style = <<<CSS
.pe-7s-like.liked {
  text-shadow: 2px 2px red, -2px -2px blue, -2px 0 red, 0 -2px blue;
}
.breadcrumb-area {
  background: ghostwhite !important;
}
body .product-tab-nav .nav-item .nav-link {
  width: auto ;
}
.select-shoing-wrap .shot-product {
  white-space: nowrap;
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
  <?php $this->beginBody(); ?>
  <?= $this->render('@app/components/home/Header') ?>
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
                "homeLink" => ["url" => "/", "label" => Yii::t('app',  "Home")],
              ]) ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?= $content; ?>
  </main>
  <?= $this->render('@app/components/home/Footer') ?>


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
  <?= $this->render("@app/components/home/offcanvas/OffCanvasMobileMenu"); ?>
  <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>

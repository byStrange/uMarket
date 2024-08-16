<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Button;
use yii\bootstrap5\Offcanvas;

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
$this->registerCssFile("@web/css/admin.css");
$this->registerJsFile("@web/js/upload/imagePreview.js", [
  "depends" => [\yii\web\JqueryAsset::class],
]);
$this->registerJsFile("@web/js/popup/popup.js", [
  "depends" => [\yii\web\JqueryAsset::class],
]);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head(); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column h-100">
  <?php $this->beginBody(); ?>

  <header class="hello" id="header">
    <?php
    Offcanvas::begin([
      "placement" => Offcanvas::PLACEMENT_START,
      "backdrop" => true,
      "scrolling" => true,
      "id" => "sidebar-offcanvas",
    ]);
    echo Nav::widget([
      "options" => ["class" => "nav flex-column nav-pills"], // Adjust classes for vertical layout
      "items" => [
        ["label" => Yii::t('app', 'Products'), "url" => ["product/index"]],
        [
          "label" => Yii::t('app', 'Product Translations'),
          "url" => ["product-translation/index"],
        ],
        ["label" => Yii::t('app', 'Users'), "url" => ["user/index"]],
        ["label" => Yii::t('app', 'Categories'), "url" => ["category/index"]],
        [
          "label" => Yii::t('app', 'Category Translations'),
          "url" => ["category-translation/index"],
        ],
        ["label" => Yii::t('app', 'Images'), "url" => ["image/index"]],
        ["label" => Yii::t('app', 'Carts'), "url" => ["cart/index"]],
        ["label" => Yii::t('app', 'CartItems'), "url" => ["cart-item/index"]],
        ["label" => Yii::t('app', 'Wishlistitems'), "url" => ["wishlistitem/index"]],
        ["label" => Yii::t('app', 'Coupons'), "url" => ["coupon/index"]],
        ["label" => Yii::t('app', 'User Addresses'), "url" => ["user-address/index"]],
        ["label" => Yii::t('app', 'Location Points'), "url" => ["location-point/index"]],
        ["label" => Yii::t('app', 'Order'), "url" => ["order/index"]],
        ["label" => Yii::t('app', 'Delivery Points'), "url" => ["delivery-point/index"]],
        ["label" => Yii::t('app', 'Featured Offers'), "url" => ["featured-offer/index"]],
        ["label" => Yii::t('app', 'Rating'), "url" => ["rating/index"]],
      ],
    ]);
    Offcanvas::end();
    ?>
  </header>

  <main id="main" class="flex-shrink-0" role="main">
    <div class="container">
      <?php if (!empty($this->params["breadcrumbs"])): ?>
        <div class="d-flex gap-2 justify-center align-items-baseline">
          <?php echo Button::widget([
            "label" =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM64 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L96 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>',
            "encodeLabel" => false,
            "options" => [
              "class" => "btn  p-1 btn-light navbar-toggler",
              "type" => "button",
              "data-bs-toggle" => "offcanvas",
              "data-bs-target" => "#sidebar-offcanvas", // Use the same ID from Offcanvas
            ],
          ]); ?>
          <?= Breadcrumbs::widget([
            "links" => $this->params["breadcrumbs"],
            "homeLink" => ["url" => "/admin", "label" => Yii::t('app', 'Admin')],
          ]) ?>
          <div>
            <?= Html::beginForm(['/site/language'], 'post') ?>
            <?= Html::dropDownList('language', Yii::$app->language, ['en-US' => 'English', 'ru-RU' => 'Russian', 'uz-UZ' => 'Uzbek']) ?>
            <?= Html::submitButton(Yii::t('app', 'Change')) ?>
            <?= Html::endForm() ?>
          </div>

        </div>
      <?php endif; ?>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
  </main>

  <div class="modal fade" id="pricingModal" tabindex="-1" aria-labelledby="pricingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pricingModalLabel"><?= Yii::t('app', 'Product Pricing Rules') ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= Yii::t('app', 'Close') ?>"></button>
        </div>
        <div class="modal-body">
          <h6><strong><?= Yii::t('app', 'Pricing Priority:') ?></strong></h6>
          <ol>
            <li><strong><?= Yii::t('app', 'Featured Offer (Product Type):') ?></strong> <?= Yii::t('app', 'The discount price from a featured offer specific to this product takes precedence.') ?></li>
            <li><strong><?= Yii::t('app', 'Featured Offer (Category Type):') ?></strong> <?= Yii::t('app', 'If a featured offer targets the category of this product, its discount price is used.') ?></li>
            <li><strong><?= Yii::t('app', 'Discount Price:') ?></strong> <?= Yii::t('app', 'If no featured offer applies, the available discount price will be used.') ?></li>
            <li><strong><?= Yii::t('app', 'Regular Price:') ?></strong> <?= Yii::t('app', 'In the absence of any featured offers or discount prices, the regular price is applied.') ?></li>
          </ol>
          <p><strong><?= Yii::t('app', 'Note:') ?></strong> <?= Yii::t('app', 'The final price shown (`cleanPrice`) is the most applicable based on these priority rules.') ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        </div>
      </div>
    </div>
  </div>
  <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>

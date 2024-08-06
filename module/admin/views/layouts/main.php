<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
/*use yii\widgets\Collapse;*/
/*use yii\bootstrap\Collapse;*/

/*use yii\bootstrap;*/
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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>

<header  class="hello" id="header">
    <?php
    Offcanvas::begin([
        "placement" => Offcanvas::PLACEMENT_START,
        "backdrop" => true,
        "scrolling" => true,
        "id" => "sidebar-offcanvas",
    ]);
    echo Nav::widget([
        // Use Nav widget for the navigation items
        "options" => ["class" => "nav flex-column nav-pills"], // Adjust classes for vertical layout
        "items" => [
            ["label" => "Products", "url" => ["product/index"]],
            [
                "label" => "Product Translations",
                "url" => ["product-translation/index"],
            ],
            ["label" => "Users", "url" => ["user/index"]],
            ["label" => "Categories", "url" => ["category/index"]],
            [
                "label" => "Category Translations",
                "url" => ["category-translation/index"],
            ],
            ["label" => "Images", "url" => ["image/index"]],
            ["label" => "Carts", "url" => ["cart/index"]],
            ["label" => "CartItems", "url" => ["cart-item/index"]],
            ["label" => "Wishlistitems", "url" => ["wishlistitem/index"]],
            ["label" => "Coupons", "url" => ["coupon/index"]],
            ["label" => "User addresses", "url" => ["user-address/index"]],
            ["label" => "Location Points", "url" => ["location-point/index"]],
            ["label" => "Order", "url" => ["order/index"]],
            ["label" => "Delivery Points", "url" => ["delivery-point/index"]],
            ["label" => "Featured Offers", "url" => ["featured-offer/index"]],
            ["label" => "Rating", "url" => ["rating/index"]],
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
    // Adjust icon class as needed
    "options" => [
        "class" => "btn  p-1 btn-light navbar-toggler",
        "type" => "button",
        "data-bs-toggle" => "offcanvas",
        "data-bs-target" => "#sidebar-offcanvas", // Use the same ID from Offcanvas
    ],
]); ?> 
            <?= Breadcrumbs::widget([
                "links" => $this->params["breadcrumbs"],
                "homeLink" => ["url" => "/admin", "label" => "Admin"],
            ]) ?>

</div>
        <?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>


<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

<?php

use app\models\Product;
use yii\helpers\Html;

/** @var Product $product */
$salePercentage = number_format($product->getProductSalePercentage(), 0);
$thumbnailImage = count($product->images) ? $product->images[0] : null;
?>


<div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
  <!-- Single Prodect -->
  <div class="product">
    <span class="badges">
      <?php if ($salePercentage): ?>
        <span class="sale">-<?= $salePercentage ?>%</span>
      <?php endif ?>
    </span>
    <div class="thumb">
      <a href="single-product.html" class="image">
        <?php if ($thumbnailImage): ?>
          <?= Html::img($thumbnailImage->image) ?>
        <?php else: ?>
          <img src="/images/product-image/1.webp" />
        <?php endif ?>
      </a>
    </div>
    <div class="content">
      <span class="category"><a href="#">Accessories</a></span>
      <h5 class="title">
        <a href="single-product.html"><?= $product->getProductTranslationForLanguage(Yii::$app->language)->title ?></a>
      </h5>
      <span class="price">
        <?php if ($product->discount_price): ?>
          <span class="old"><?= Yii::$app->formatter->asCurrency($product->price) ?></span>
          <span class="new"><?= Yii::$app->formatter->asCurrency($product->discount_price) ?></span>
        <?php else: ?>
          <span class="new"><?= Yii::$app->formatter->asCurrency($product->price) ?></span>
        <?php endif; ?>
      </span>
    </div>
    <div class="actions">
      <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart"><i class="pe-7s-shopbag"></i></button>
      <button class="action wishlist" title="Wishlist" data-bs-toggle="modal" data-bs-target="#exampleModal-Wishlist"><i class="pe-7s-like"></i></button>
      <button class="action quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="pe-7s-look"></i></button>
      <button class="action compare" title="Compare" data-bs-toggle="modal" data-bs-target="#exampleModal-Compare"><i class="pe-7s-refresh-2"></i></button>
    </div>
  </div>
</div>

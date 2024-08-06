<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Product $product */
$salePercentage = number_format($product->getProductSalePercentage(), 0);
$thumbnailImage = count($product->images) ? $product->images[0] : null;
$wrappedInCol = isset($wrappedInCol) ? $wrappedInCol : true;
?>


<?php if (isset($wrappedInCol) && $wrappedInCol): ?>
  <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
  <?php endif ?>
  <!-- Single Product -->
  <div class="product">
    <span class="badges">
      <?php if ($salePercentage): ?>
        <span class="sale"><?= $salePercentage ?>%</span>
      <?php endif; ?>
    </span>
    <div class="thumb">
      <a href="<?= Url::toRoute(["shop/product", "id" => $product->id]) ?>" class="image">
        <?php if ($thumbnailImage): ?>
          <?= Html::img('/' . $thumbnailImage->image) ?>
        <?php else: ?>
          <img src="/images/product-image/1.webp" />
        <?php endif; ?>
      </a>
    </div>
    <div class="content">
      <span class="category"><a href="#">Accessories</a></span>
      <h5 class="title">
        <?= Html::a(
          $product->getProductTranslationForLanguage(Yii::$app->language)
            ->title,
          Url::toRoute(["shop/product", "id" => $product->id])
        ) ?>
      </h5>
      <span class="price">
        <?php if ($product->discount_price): ?>
          <span class="old"><?= Yii::$app->formatter->asCurrency(
                              $product->price
                            ) ?></span>
          <span class="new"><?= Yii::$app->formatter->asCurrency(
                              $product->discount_price
                            ) ?></span>
        <?php else: ?>
          <span class="new"><?= Yii::$app->formatter->asCurrency(
                              $product->price
                            ) ?></span>
        <?php endif; ?>
      </span>
    </div>
    <div class="actions">
        <button title="Add To Cart" hx-target="#cartModal .modal-content" hx-trigger="click" hx-post="<?= Url::toRoute(['cart/add-to-cart']) ?>" class="action add-to-cart" hx-vals='{"id": <?= $product->id ?>}' data-bs-toggle="modal" data-bs-target="#cartModal"><i class="pe-7s-shopbag"></i></button>
      <button class="action wishlist" hx-target="#cartModal .modal-content" hx-trigger="click" hx-post="<?= Url::toRoute(['cart/add-to-wishlist']) ?>" hx-vals='{ "id": <?= $product->id ?> }' title="Wishlist" data-bs-toggle="modal" data-bs-target="#cartModal">

        <?php if ($product->isOnTheWishlist()): ?>
          <svg id="wishlist-icon-<?= $product->id ?>" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red" />
          </svg>
        <?php else: ?>

          <i class="pe-7s-like" id="wishlist-icon-<?= $product->id ?>"></i>

        <?php endif ?>
      </button>
      <button class="action quickview" hx-get="/shop/product/?id=<?= $product->id ?>&d=pjax" hx-target="#productDetailModal .modal-content" hx-trigger="click" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#productDetailModal"><i class="pe-7s-look"></i></button>
      <button class="action compare" title="Compare" data-bs-toggle="modal" data-bs-target="#exampleModal-Compare"><i class="pe-7s-refresh-2"></i></button>
    </div>
  </div>

  <?php if (isset($wrappedInCol) && $wrappedInCol): ?>
  </div>
<?php endif ?>

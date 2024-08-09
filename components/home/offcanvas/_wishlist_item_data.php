<?php

use yii\helpers\Url;

/** @var \yii\app\models\Wishlistitem[] $wishlistitems **/


use yii\helpers\Html;

?>

<ul class="minicart-product-list">
  <?php foreach ($wishlistitems as $wishlistitem): ?>
    <li class="wishlistitem-<?= $wishlistitem->product->id ?>">
      <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>" class="image">
        <?php $thumbnailImage = count($wishlistitem->product->images) ? $wishlistitem->product->images[0] : null  ?>

        <?php if ($thumbnailImage): ?>
          <?= Html::img('/' . $thumbnailImage->image, ["alt" => (string)$wishlistitem->product, 'class' => 'img-responsive']) ?>
        <?php else: ?>
          <img class="img-responsive" src="/images/product-image/1.webp" alt="<?= (string)$wishlistitem->product ?>" />
        <?php endif; ?>

      </a>
      <div class="content">
        <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>" class="title"><?= $wishlistitem->product ?></a>
        <span class="quantity-price"> <span class="amount"><?= $wishlistitem->product->priceAsCurrency() ?></span></span>
        <a class='remove' data-bs-toggle="modal" data-bs-target="#cartModal" hx-target="#cartModal .modal-content" hx-trigger="click" hx-post="<?= Url::toRoute(['cart/add-to-wishlist']) ?>" hx-vals='{ "id": <?= $wishlistitem->product->id ?> }' href="#">×</a>
      </div>
    </li>
  <?php endforeach ?>
</ul>

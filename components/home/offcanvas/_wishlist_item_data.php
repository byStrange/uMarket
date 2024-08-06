<?php

use app\models\Wishlistitem;
use yii\helpers\Url;

/** @var Wishlistitem[] $wishlistitems **/

?>

<ul class="minicart-product-list">
  <?php foreach ($wishlistitems as $wishlistitem): ?>
    <li class="wishlistitem-<?= $wishlistitem->product->id ?>">
      <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>" class="image"><img src="/images/product-image/1.webp" alt="Cart product Image"></a>
      <div class="content">
        <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>" class="title"><?= $wishlistitem->product ?></a>
        <span class="quantity-price"> <span class="amount"><?= $wishlistitem->product->priceAsCurrency() ?></span></span>
        <a class='remove' data-bs-toggle="modal" data-bs-target="#cartModal" hx-target="#cartModal .modal-content" hx-trigger="click" hx-post="<?= Url::toRoute(['cart/add-to-wishlist']) ?>" hx-vals='{ "id": <?= $wishlistitem->product->id ?> }' href="#">×</a>
      </div>
    </li>
  <?php endforeach ?>
</ul>

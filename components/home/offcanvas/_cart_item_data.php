<?php

/** @var \yii\models\CartItem[] $cartitems **/

use yii\helpers\Url;

?>

<ul class="minicart-product-list">
  <?php foreach ($cartitems as $cart_item) : ?>
    <li class="cartitem-<?= $cart_item->product->id ?>">
      <a href="<?= Url::toRoute(['shop/product', 'id' => $cart_item->product->id]) ?>" class="image"><img src="/images/product-image/1.webp" alt="Cart product Image"></a>
      <div class="content">
        <a href="<?= Url::toRoute(['shop/product', 'id' => $cart_item->product->id]) ?>" class="title"><?= $cart_item->product ?></a>
        <span class="quantity-price"><?= $cart_item->quantity ?> x <span class="amount"><?= $cart_item->product->priceAsCurrency() ?></span></span>
        <a href="#" class="remove" data-bs-toggle="modal" data-bs-target="#cartModal" hx-post="/cart/remove-cartitem" hx-vals='{"id": <?= $cart_item->product->id ?>}' hx-target="#cartModal .modal-content" hx-trigger="click">×</a>
      </div>
    </li>
  <?php endforeach ?>
</ul>

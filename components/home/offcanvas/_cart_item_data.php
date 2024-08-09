<?php

/** @var \yii\models\CartItem[] $cartitems **/

use yii\helpers\Html;
use yii\helpers\Url;

?>

<ul class="minicart-product-list">
  <?php foreach ($cartitems as $cartitem) : ?>
    <li class="cartitem-<?= $cartitem->product->id ?>">
      <?php $thumbnailImage = count($cartitem->product->images) ? $cartitem->product->images[0] : null  ?>

      <a href="<?= Url::toRoute(['shop/product', 'id' => $cartitem->product->id]) ?>" class="image">
        <?php if ($thumbnailImage): ?>
          <?= Html::img('/' . $thumbnailImage->image, ["alt" => (string)$cartitem->product, "class" => "img-responsive"]) ?>
        <?php else: ?>
          <img class="img-responsive" src="/images/product-image/1.webp" alt="<?= (string)$cartitem->product ?>" />
        <?php endif; ?>
      </a>
      <div class="content">
        <a href="<?= Url::toRoute(['shop/product', 'id' => $cartitem->product->id]) ?>" class="title"><?= $cartitem->product ?></a>
        <span class="quantity-price"><?= $cartitem->quantity ?> x <span class="amount"><?= $cartitem->product->priceAsCurrency() ?></span></span>
        <a
          href="#"
          class="remove"
          hx-post="/cart/remove-cartitem"
          hx-vals='{"id": <?= $cartitem->product->id ?>}'
          hx-target="#cartModal .modal-content"
          hx-trigger="click">
          ×
        </a>
      </div>
    </li>
  <?php endforeach ?>
</ul>

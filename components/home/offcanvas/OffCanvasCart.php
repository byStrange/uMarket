<?php

use app\models\Cart;

/** @var \yii\web\View $view */

$cart = Cart::getOrCreateCurrentInstance();
$cart_items =  $cart->cartItems;
?>
<div id="offcanvas-cart" class="offcanvas offcanvas-cart">
  <div class="inner">
    <div class="head">
      <span class="title"><?= Yii::t('app', 'Cart') ?></span>
      <button class="offcanvas-close">×</button>
    </div>
    <div class="body customScroll">
      <?= $view->render('_cart_item_data', ['cartitems' => $cart_items]) ?>
    </div>
    <div class="foot">
      <div class="buttons mt-30px">
        <a href="/cart" class="btn btn-dark btn-hover-primary mb-30px"><?= Yii::t('app', 'view cart') ?></a>
        <a href="/site/checkout" class="btn btn-outline-dark current-btn"><?= Yii::t('app', 'checkout') ?></a>
      </div>
    </div>
  </div>
</div>

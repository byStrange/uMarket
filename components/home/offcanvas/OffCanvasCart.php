<?php

use app\models\Cart;

/** @var \yii\web\View $view */

$cart = Cart::getOrCreateCurrentInstance();
$cart_items =  $cart->cartItems;
?>
<div id="offcanvas-cart" class="offcanvas offcanvas-cart">
  <div class="inner">
    <div class="head">
      <span class="title">Cart</span>
      <button class="offcanvas-close">×</button>
    </div>
    <div class="body customScroll">
      <?= $view->render('_cart_item_data', ['cartitems' => $cart_items]) ?>
    </div>
    <div class="foot">
      <div class="buttons mt-30px">
        <a href="/cart" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
        <a href="checkout.html" class="btn btn-outline-dark current-btn">checkout</a>
      </div>
    </div>
  </div>
</div>

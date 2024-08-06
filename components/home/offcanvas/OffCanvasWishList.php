<?php

use app\models\Cart;

/** @var \yii\web\View $view */

$cart = Cart::getOrCreateCurrentInstance();
$wishlistitems = $cart->wishlistitems;
?>
<div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
  <div class="inner">
    <div class="head">
      <span class="title">Wishlist</span>
      <button class="offcanvas-close">×</button>
    </div>
    <div class="body customScroll">
      <?= $view->render('_wishlist_item_data', ['wishlistitems' => $wishlistitems]) ?>
    </div>
    <div class="foot">
      <div class="buttons">
        <a href="/cart/wishlist" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
      </div>
    </div>
  </div>
</div>

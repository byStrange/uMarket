<?php

use app\models\Cart;
use app\models\CartItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var CartItem[] $cartitems */
/** @var Cart $cart */
/** @var View $this */

$cartEmptyTemplate = $this->render('_cart_empty');
$script = <<<JS
function changeCartTotal({ cartTotal, cartGrandTotal }, cartItemsCount) {
  if (!cartItemsCount) {
    $('.cart-section').html(`{$cartEmptyTemplate}`)
  }
  var cartTotalProducts = $("#cartTotalProducts");
  var cartGrandTotalEl = $('#cartGrandTotal');
  cartTotalProducts.text(cartTotal); 
  cartGrandTotalEl.text(cartGrandTotal);
}

function afterQuantityChange(event) {
  var response = JSON.parse(event.detail.xhr.response);
  var { id, subtotal, cartTotal, cartGrandTotal, totalQuantity } = response;
  var cartItem = $('.cartitem-' + id);
  var cartItemSubTotal = cartItem.find('.product-subtotal');
  cartItemSubTotal.text(subtotal)

  changeCartTotal({ cartTotal, cartGrandTotal }, totalQuantity)
}

window.changeCartTotal = changeCartTotal;
window.afterQuantityChange = afterQuantityChange;

function initQuantityHtmx(el, productId) {
  var incBtn = el.querySelector('.inc.qtybutton')
  var decBtn = el.querySelector('.dec.qtybutton')

  setHtmxAttributes(incBtn, productId, 'increment');
  setHtmxAttributes(decBtn, productId, 'decrement');

  function setHtmxAttributes(button, productId, action) {
    button.setAttribute('hx-post', '/cart/add-to-cart')
    button.setAttribute('hx-trigger', 'click')
    button.setAttribute('hx-vals', JSON.stringify({id: productId, action}))
    button.setAttribute('hx-target', "#cartModal .modal-content")

    button.setAttribute('hx-on::after-on-load', "afterQuantityChange(event)")
    htmx.process(button)
  }
}

var cartItems = document.querySelectorAll('.cartitem');
cartItems.forEach((cartItem) => {
  var id = cartItem.dataset.id;
  initQuantityHtmx(cartItem, id)
})
JS;
$this->registerJs($script);
?>
<section id="section" class="cart-section">
  <?php if (isset($cartitems) && count($cartitems)): ?>
    <div class="cart-main-area pt-100px pb-100px">
      <div class="container">
        <h3 class="cart-page-title">Your cart items</h3>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <form action="#">
              <div class="table-content table-responsive cart-table-content">
                <table>
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>Until Price</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($cartitems as $cartitem) : ?>
                      <tr class="cartitem cartitem-<?= $cartitem->product->id ?>" data-id="<?= $cartitem->product->id ?>">
                        <td class="product-thumbnail">
                          <?php $thumbnailImage = count($cartitem->product->images) ? $cartitem->product->images[0] : null  ?>
                          <a href="<?= Url::toRoute(['shop/product', 'id' => $cartitem->product->id]) ?>" class="image">
                            <?php if ($thumbnailImage): ?>
                              <?= Html::img('/' . $thumbnailImage->image, ["alt" => (string)$cartitem->product, "class" => "img-responsive ml-15px"]) ?>
                            <?php else: ?>
                              <img class="img-responsive ml-15px" src="/images/product-image/1.webp" alt="<?= (string)$cartitem->product ?>" />
                            <?php endif; ?>
                          </a>
                        </td>
                        <td class="product-name">
                          <a href="<?= Url::toRoute(['shop/product', 'id' => $cartitem->product->id]) ?>"><?= $cartitem->product ?></a>
                        <td class="product-price-cart"><span class="amount"><?= $cartitem->product->priceAsCurrency() ?></span></td>
                        <td class="product-quantity">
                          <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box" type="text" readonly name="qtybutton" value="<?= $cartitem->quantity ?>" />
                          </div>
                        </td>
                        <td class="product-subtotal">
                          <?= $cartitem->subTotalAsCurrency() ?>
                        </td>
                        <td class="product-remove">
                          <a href="#"
                            hx-target="#cartModal .modal-content"
                            hx-trigger="click" hx-post="<?= Url::toRoute(['cart/remove-cartitem']) ?>"
                            hx-vals='{ "id": <?= $cartitem->product->id ?> }'
                            hx-on::after-on-load="afterCartItemRemove(event, event)">
                            <i class="fa fa-times"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="cart-shiping-update-wrapper">
                    <div class="cart-shiping-update">
                      <a href="/shop">Continue Shopping</a>
                    </div>
                    <div class="cart-clear">
                      <a href="#" hx-post="/cart/clean">Clear Shopping Cart</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">


              <div class="col-lg-4 col-md-12 mt-md-30px">
                <div class="grand-totall">
                  <div class="title-wrap">
                    <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                  </div>
                  <h5>Total products <span id="cartTotalProducts"><?= $cart->totalPriceAsCurrency() ?></span></h5>
                  <div class="total-shipping">
                    <h5>Total shipping</h5>
                    <ul>
                      <li>Standard <span>Free</span></li>
                    </ul>
                  </div>
                  <h4 class="grand-totall-title">Grand Total <span id="cartGrandTotal"><?= $cart->totalPriceAsCurrency() ?></span></h4>
                  <a href="/site/checkout">Proceed to Checkout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php else: ?>
    <?= $this->render('_cart_empty') ?>


</section><?php endif ?>

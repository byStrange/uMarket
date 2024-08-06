<?php

use app\models\Cart;
use app\models\CartItem;
use yii\helpers\Url;
use yii\web\View;

/** @var CartItem $cartitems */
/** @var Cart $cart */
/** @var View $this */

$script = <<<JS
$(document).on('htmx:afterOnLoad', function (event) {
  var response = JSON.parse(event.detail.xhr.response);
  var { id, subtotal } = response;
  var cartItem = document.querySelector('.cartitem-' + id);
  var cartItemSubTotal = cartItem.querySelector('.product-subtotal');
  cartItemSubTotal.innerText = subtotal
  console.log(cartItem)
})
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

<?php if (count($cartitems)): ?>
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
                      <a href="#"><img class="img-responsive ml-15px" src="/images/product-image/1.webp" alt="" /></a>
                    </td>
                    <td class="product-name">
                      <a href="<?= Url::toRoute(['shop/product', 'id' => $cartitem->product->id]) ?>"><?= $cartitem->product ?></a>
                    <td class="product-price-cart"><span class="amount"><?= $cartitem->product->priceAsCurrency() ?></span></td>
                    <td class="product-quantity">
                      <div class="cart-plus-minus">
                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?= $cartitem->quantity ?>" />
                      </div>
                    </td>
                    <td class="product-subtotal">
                      <?= $cartitem->subTotalAsCurrency() ?>
                    </td>
                    <td class="product-remove">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#cartModal" hx-target="#cartModal .modal-content" hx-trigger="click" hx-post="<?= Url::toRoute(['cart/remove-cartitem']) ?>" hx-vals='{ "id": <?= $cartitem->product->id ?> }'><i class="fa fa-times"></i></a>
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
              <h5>Total products <span><?= $cart->totalPriceAsCurrency() ?></span></h5>
              <div class="total-shipping">
                <h5>Total shipping</h5>
                <ul>
                  <li>Standard <span>Free</span></li>
                </ul>
              </div>
<h4 class="grand-totall-title">Grand Total <span><?= $cart->totalPriceAsCurrency() ?></span></h4>
              <a href="checkout.html">Proceed to Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php else: ?>
<div class="empty-cart-area pb-100px pt-100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-heading">
                    <h2>Your cart item</h2>
                </div>
                <div class="empty-text-contant text-center">
                    <i class="pe-7s-shopbag"></i>
                    <h3>There are no more items in your cart</h3>
                    <a class="empty-cart-btn" href="/shop">
                        <i class="fa fa-arrow-left"> </i> Continue shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>

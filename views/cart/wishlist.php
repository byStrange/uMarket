<?php

use app\models\Wishlistitem;
use yii\helpers\Url;

/** @var Wishlistitem $wishlistitems */
?>

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
                  <th>Add To Cart</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($wishlistitems as $wishlistitem) : ?>
                  <tr class="wishlistitem-<?= $wishlistitem->product->id ?>">
                    <td class="product-thumbnail">
                      <a href="#"><img class="img-responsive ml-15px" src="/images/product-image/1.webp" alt="" /></a>
                    </td>
                    <td class="product-name">
                      <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>"><?= $wishlistitem->product ?></a>
                    </td>
                    <td class="product-price-cart"><span class="amount"><?= $wishlistitem->product->priceAsCurrency() ?></span></td>
                    <td class="product-quantity">
                      <div class="cart-plus-minus">
                        <input class="cart-plus-minus-box" type="text" id="quantityInput<?= $wishlistitem->id ?>" name="quantity<?= $wishlistitem->id ?>" value="1" />
                      </div>
                    </td>
                    <td class="product-subtotal">
                      <?= $wishlistitem->product->priceAsCurrency() ?>
                    </td>
                    <td class="product-wishlist-cart">
                      <div>
                        <form id="addToCartForm<?= $wishlistitem->id ?>" hx-post="<?= Url::toRoute(['cart/add-to-cart']) ?>" hx-target="#cartModal .modal-content">
                          <input type="hidden" value="<?= $wishlistitem->product->id ?>" name="id" />
                          <input type="hidden" id="quantityHidden<?= $wishlistitem->id ?>" name="quantity" value="1" />
                          <a data-bs-toggle="modal" data-bs-target="#cartModal" href="#" onclick="updateQuantity(<?= $wishlistitem->id ?>)">
                            add to cart
                          </a>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>

              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  function updateQuantity(id) {
    var quantityInput = document.getElementById('quantityInput' + id);
    var quantityHidden = document.getElementById('quantityHidden' + id);
    quantityHidden.value = quantityInput.value;

    htmx.trigger('#addToCartForm' + id, 'submit');
  }
</script>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

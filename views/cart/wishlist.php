<?php

use app\models\Wishlistitem;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Wishlistitem[] $wishlistitems */
/** @var View $this */

$cartEmptyTemplate = $this->render('_wishlist_empty');


$script = <<<JS
function removeFromWishList({ id, wishlistItemsCount }) {
  // ensure when there is no wishlist item replace it with empty template
  if (!+wishlistItemsCount) {
    $('#wishlist-section').html(`{$cartEmptyTemplate}`)
  }
  var removedWishlistItem = $(".wishlistitem-" + id);
  removedWishlistItem.slideUp();
}
JS;
$this->registerJs($script);
?>

<section id="wishlist-section">
  <?php if (count($wishlistitems)): ?>
    <div class="cart-main-area pt-100px pb-100px">
      <div class="container">
        <h3 class="cart-page-title">Your wishlist</h3>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-content table-responsive cart-table-content">
              <table>
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Add To Cart</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($wishlistitems as $wishlistitem) : ?>
                    <tr class="wishlistitem-<?= $wishlistitem->product->id ?>">
                      <td class="product-thumbnail">
                        <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>" class="image">
                          <?php $thumbnailImage = count($wishlistitem->product->images) ? $wishlistitem->product->images[0] : null  ?>
                          <?php if ($thumbnailImage): ?>
                            <?= Html::img('/' . $thumbnailImage->image, ["alt" => (string)$wishlistitem->product, 'class' => 'img-responsive ml-15px']) ?>
                          <?php else: ?>
                            <img class="img-responsive ml-15px" src="/images/product-image/1.webp" alt="<?= (string)$wishlistitem->product ?>" />
                          <?php endif; ?>
                        </a>
                      </td>
                      <td class="product-name">
                        <a href="<?= Url::toRoute(['shop/product', 'id' => $wishlistitem->product->id]) ?>"><?= $wishlistitem->product ?></a>
                      </td>
                      <td class="product-price-cart"><span class="amount"><?= $wishlistitem->product->priceAsCurrency() ?></span></td>
                      <td class="product-quantity">
                        <div class="cart-plus-minus">
                          <input class="cart-plus-minus-box quantity-input" type="number" value="1" min="1" />
                        </div>
                      </td>
                      <td class="product-subtotal">
                        <?= $wishlistitem->product->priceAsCurrency() ?>
                      </td>
                      <td class="product-wishlist-cart">
                        <button
                          hx-post="<?= Url::toRoute(['cart/add-to-cart']) ?>"
                          hx-target="#cartModal .modal-content"
                          hx-vals='js:{"id": <?= $wishlistitem->product->id ?>, "quantity": parseInt(document.querySelector("tr.wishlistitem-<?= $wishlistitem->product->id ?>").querySelector(".quantity-input").value)}'
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#cartModal">
                          Add to cart
                        </button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <?= $this->render('_wishlist_empty') ?>
  <?php endif ?>
</section>
</script>
</script>
</script>

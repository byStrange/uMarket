<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use app\models\Wishlistitem;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;


class CartController extends Controller
{
  public $enableCsrfValidation = false;

  public function behaviors()
  {
    return [
      "verb" => [
        "class" => VerbFilter::class,
        "actions" => [
          'add-to-wishlist' => ['post'],
          'add-to-cart' => ['post']
        ]
      ],
    ];
  }

  public function actionWishlist($d = false)
  {
    $cart = Cart::getOrCreateCurrentInstance();
    $wishlistitems = $cart->wishlistitems;

    if ($d) {
      return $this->renderPartial('@app/components/home/offcanvas/_wishlist_item_data', ['wishlistitems' => $wishlistitems]);
    }

    return $this->render('wishlist', ['wishlistitems' => $wishlistitems]);
  }

  public function actionIndex($d = false)
  {
    $cart = Cart::getOrCreateCurrentInstance();
    $cartitems = $cart->cartItems;

    if ($d) {
      return $this->renderPartial('@app/components/home/offcanvas/_cart_item_data', ['cartitems' => $cartitems, 'cart' => $cart]);
    }

    return $this->render('cart', ['cartitems' => $cartitems, 'cart' => $cart]);
  }

  /**
   * AddToWishlist action (adds product to wishlist)
   *
   * @return Response|string
   */

  public function actionAddToWishlist()
  {
    $id = Yii::$app->request->getBodyParam('id');
    $cart = Cart::getOrCreateCurrentInstance();

    # only get product id from a database to optimize query
    $product = Product::find()->select(['id'])->where(['id' => $id])->one();

    # product does not exist
    if (!$product) {
      return $this->renderPartial('@app/components/product/_modal_response', ['message' => "Could not find product with id: $id"]);
    }

    # try to get wishlist item associated with this cart and product
    $wishlistitem = $cart->getWishlistitems()->where(['cart_id' => $cart->id, 'product_id' => $id])->one();

    # wishlist item not found create new one
    if (!$wishlistitem) {
      $wishlistitem = new Wishlistitem(['product_id' => $product->id, 'cart_id' => $cart->id]);
      $wishlistitem->save();
      return $this->renderPartial(
        '@app/components/product/_modal_response',
        [
          'message' => 'Added to wishlist successfully',
          "dataAttributes" => ['id' => $id, 'action' => 'addToWishlist']
        ]
      );
    }

    # there was already a wishlist item delete it from wishlist to create toggling effect
    $wishlistitem->delete();
    return $this->renderPartial(
      '@app/components/product/_modal_response',
      [
        'message' => 'Removed from wishlist successfully',
        'dataAttributes' => ['id' => $id, 'action' => 'removeFromWishList', 'wishlistItemsCount' => count($cart->wishlistitems)]
      ]
    );
  }


  /**
   * AddToCart action (adds to cart|increments quantity|decrements quantity) 
   *
   * @return string
   */

  public function actionAddToCart()
  {
    $req = Yii::$app->request;
    [$id, $quantity, $action] = [(int)$req->getBodyParam('id'), (int)$req->getBodyParam('quantity', 1), $req->getBodyParam('action', 'add_to_cart')];

    $actions = ['increment', 'decrement'];

    # only get product id from a database to optimize query
    $product = Product::find()->select(['id'])->where(['id' => $id])->one();

    # product does not exist
    if (!$product) {
      return $this->renderPartial('@app/components/product/_modal_response', ["message" => "Could not find product with id: $id"]);
    }

    $cart = Cart::getOrCreateCurrentInstance();

    # try to get cart item associated with this cart and product
    $cart_item = $product->getCartItems()->where(['cart_id' => $cart->id, 'product_id' => $id])->one();

    # check if the action is increment or decrement
    if (in_array($action, $actions)) {

      # increment quantity or decrement
      $adjustment = $action == 'increment' ? 1 : -1;
      $finalQuantity = $cart_item->quantity + $adjustment;
      $cart_item->quantity = $finalQuantity <= 0 ? 1 : $finalQuantity;
      if ($cart_item->save()) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true, 'cartTotal' => $cart->totalPriceAsCurrency(), 'cartGrandTotal' => $cart->totalPriceAsCurrency(), 'totalQuantity' => $cart_item->quantity, 'subtotal' => $cart_item->subTotalAsCurrency(), 'id' => $cart_item->product->id];
      } else {
        return ['success' => false, 'totalQuantity' => $cart_item->quantity];
      }
    }

    # there is already cart item associated with the product
    if ($cart_item) {
      # user is trying to add this product to cart again, just increase the quantity
      $cart_item->quantity = $cart_item->quantity + $quantity;
      if ($cart_item->save()) {
        return $this->renderPartial('@app/components/product/_modal_response', ['message' => "Added to cart successfully"]);
      }
    }


    # no cart item found, create new one
    $cart_item = new CartItem();
    $cart_item->product_id = $product->id;
    $cart_item->cart_id = $cart->id;
    $cart_item->quantity = $quantity;

    if ($cart_item->save()) {
      return $this->renderPartial("@app/components/product/_modal_response", ['message' => 'Added to cart successfully!']);
    }
  }

  /** 
   * RmoveCartItem action (removes given product from cart)
   *
   * @return Response|string
   *
   */
  public function actionRemoveCartitem()
  {
    $id = Yii::$app->request->getBodyParam('id');

    # try to get current cart instance but do not create new one
    $cart = Cart::getOrCreateCurrentInstance(false);

    # user does not have cart 
    if (!$cart) {
      return $this->renderPartial('@app/components/product/_modal_response', ['message' => 'You have no cart']);
    }


    $product = Product::find()
      ->select(['main_product.id'])
      ->joinWith('cartItems', true, 'LEFT JOIN')
      ->where(['main_product.id' => $id])
      ->one();

    # product does not exist
    if (!$product) {
      return $this->renderPartial('@app/components/product/_modal_response', ["message" => "Could not find product with id: $id"]);
    }

    $cartItem = $product->getCartItems()->where(['cart_id' => $cart->id, 'product_id' => $id])->one();

    # cart item does not exist
    if (!$cartItem) {
      return $this->renderPartial('@app/components/product/_modal_response', ['message' => 'There is no cart item with this product']);
    }

    # delete the cart item
    $cartItem->delete();

    # set format to json
    Yii::$app->response->format = Response::FORMAT_JSON;

    return ['id' => $id, 'action' => 'removeFromCart', 'cartItemsCount' => count($cart->cartItems), 'cartGrandTotal' => $cart->totalPriceAsCurrency(), 'cartTotal' => $cart->totalPriceAsCurrency()];
  }


  public function actionClean()
  {
    # try to get current cart instance but do not create new one
    $cart = Cart::getOrCreateCurrentInstance();

    $cart->delete();
    return $this->goHome();
  }
}

<?php

use app\models\Cart;
use app\models\CartItem;
use app\models\DeliveryPoint;
use app\models\UserAddress;
use app\widgets\RadioItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var CartItem[] $cartitems */
/** @var Cart $cart */

$cities = ['andjina' => 'Andijan', 'Tashkent', 'Fargona'];
$paymentTypes = ['click' => "Click", 'payme' => "Payme", 'cash' => "Cash"];
$addressesJson = "";
if (!Yii::$app->user->isGuest) {
  global $addressesJson;
  $addressesJson = UserAddress::getAddressesJson(Yii::$app->user->id);
}

$script = <<<javascript
function makeCouponTemplate(label, amount) {
  return '<div class="your-order-bottom" id="coupon-wrapper" style="border-top: 1px solid #dee0e4; padding-top: 19px"><ul><li class="couponlist-item">Coupon (' + label  +')</li> <li>- '+ amount +'</li> </ul> </div>'
}

const userAddresses = JSON.parse(`{$addressesJson}`)
$('#orderform-selectedaddressid').change(function() {
  var selectedAddressId = $(this).val();
  if (selectedAddressId) {
    var address = userAddresses.find(function (item) {
        return item.id == selectedAddressId;
    });
    if (address) {
        $('#orderform-streetaddress').val(address.street_address);
        $('#orderform-apartment').val(address.apartment);
        $('#orderform-postalcode').val(address.zip_code);
        $('#orderform-firstname').val(address.user_first_name);
        $('#orderform-lastname').val(address.user_last_name);
        $('#orderform-phonenumber').val(address.user_phone_number);
        $('#orderform-city').val(address.city);
    } else {
        $('#orderform-streetaddress').val('');
        $('#orderform-apartment').val('');
        $('#orderform-postalcode').val('');
        $('#orderform-firstname').val('');
        $('#orderform-lastname').val('');
        $('#orderform-phonenumber').val('');
        $('#orderform-city').val('');
    }
  }

});

function applyCoupon({ coupon , couponDiscountAmountAsCurrency, cartGrandTotal }) {
  var couponWrapper =  $('#coupon-wrapper');
  var couponItemLabel = couponWrapper.find('.couponlist-item-label');
  var couponItemValue = couponWrapper.find('.couponlist-item-value');
  $("#grandTotal").text(cartGrandTotal);
  var beforeCouponWrapper = $('#middle');
  var label = coupon.label ? coupon.label : coupon.code
  if (couponWrapper.length) {
    couponItemLabel.html('<b>Coupon (' + label + ')</b>');
    couponItemValue.text('-'  + couponDiscountAmountAsCurrency)
  } else {
    var template = makeCouponTemplate(label, couponDiscountAmountAsCurrency)
    beforeCouponWrapper.after(template)
  }
}

window.applyCoupon = applyCoupon;
  $('input[name="OrderForm[deliveryOption]"]').each(function() {
    $(this).on('change', function() {
      var courierDetails = $('#courierDetails');
      var submitPointDetails = $('#submitPointDetails');
      courierDetails.find('.help-block').text('') 
      submitPointDetails.find('.help-block').text('') 
      if ($(this).val() === 'courier') {
        courierDetails.show();
        submitPointDetails.hide();
      } else {
        courierDetails.hide();
        submitPointDetails.show();
      }
    });
  });
javascript;

$this->registerJs($script);

?>

<style>
  #orderform-deliveryoption {
    margin-top: 8px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;

  }


  #orderform-paymenttype {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
  }

  .options label {
    cursor: pointer;
    transition: background-color 200ms;
  }

  input[type="radio"] {
    width: 16px;
    height: 16px;
  }

  .form-check-input:checked+.form-check-label .card {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 2px rgba(216, 216, 216, 0.5);
  }

  .help-block {
    color: var(--bs-danger)
  }
</style>

<div class="checkout-area pt-100px pb-100px">
  <?php if (count($cartitems)): ?>
    <div class="container">
      <?php $form = ActiveForm::begin() ?>
      <div class="row">
        <div class="col-lg-7">
          <div class="order-info-wrap">
            <h3>Order Details</h3>

            <!-- City Selection -->
          <?php if($addressesJson): ?>
            <div class="section mb-4 border p-3 rounded">
              <h4>Apply address</h4>
              <p class="text-muted">You already have pre-defined user addresses, u can just appy one! </p>
              <?php
              $addresses = UserAddress::find()->where(['user_id' => Yii::$app->user->id])->all();
              $addressList = \yii\helpers\ArrayHelper::map($addresses, 'id', function ($address) {
                return $address->label . ' - ' . $address->street_address . ', ' . $address->city;
              });
              ?>
              <?= $form->field($model, 'selectedAddressId')->dropDownList(
                $addressList,
                ['prompt' => '--- Select an address ---']
              ) ?>
            </div>
          <?php endif ?>

            <div class="section my-4">
              <h4>City</h4>
              <div class="form-group">
                <?= $form->field($model, 'city', ['template' => '{input}{hint}{error}', 'inputOptions' => ['list' => 'dropDownList', 'class' => 'form-control']])->textInput($cities) ?>
                <datalist id="dropDownList">
                  <?php foreach ($cities as $key => $value): ?>
                    <option value="<?= $value ?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>

            <!-- Delivery Options -->
            <div class="border p-3 rounded mb-3">

              <div class="section">
                <h4>Delivery Options</h4>
                <div class="options" id="deliveryOptions">
                  <?= $form->field($model, 'deliveryOption', ['template' => '{input}{hint}{error}'])->radioList(['courier' => 'Courier', 'submitpoint' => 'Submit Point'], [
                    "item" => function ($index, $label, $name, $checked, $value) {
                      return RadioItem::widget([
                        "name" => $name,
                        "showRadioInput" => false,
                        "value" => $value,
                        "id" => $index . $label,
                        "label" => $label,
                        "checked" => $checked
                      ]);
                    }
                  ]) ?>
                </div>
              </div>

              <!-- Courier Details -->
              <div id="courierDetails">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <?= $form->field($model, 'streetAddress')->textInput() ?>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <?= $form->field($model, 'apartment')->textInput() ?>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <?= $form->field($model, 'postalCode')->textInput() ?>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <?= $form->field($model, 'commentForCourier')->textarea() ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Submit Point Details -->
              <div id="submitPointDetails" class="mt-3" style="display: none;">
                <h5>Select a Submit Point</h5>
                <?= $form->field($model, 'submitPoint')->dropDownList(DeliveryPoint::toOptionsList(),  ['prompt' => '--- Select a delivery point ---']) ?>
              </div>
            </div>
          </div>

          <!-- Order Taker Details -->
          <div class="section mb-4 border p-3 rounded">
            <h4>Order Taker Details</h4>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <?= $form->field($model, 'firstName')->textInput() ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <?= $form->field($model, 'lastName')->textInput() ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <?= $form->field($model, 'phoneNumber')->textInput() ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Details -->
          <div class="section mb-4 border rounded p-3">
            <h4>Payment type</h4>

            <div class="options" id="paymentTypes">
              <?= $form->field($model, 'paymentType', ['template' => '{input}{hint}{error}'])->radioList($paymentTypes, [
                "item" => function ($index, $label, $name, $checked, $value) {
                  return RadioItem::widget([
                    "showRadioInput" => false,
                    "name" => $name,
                    "value" => $value,
                    "id" => $index . $label,
                    "label" => $label,
                    "checked" => $checked
                  ]);
                }
              ]) ?>
            </div>

            <!-- Card Details (shown only when card is selected) -->
            <div id="card-details" style="display: none;">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" class="form-control" id="card-number">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" class="form-control" id="expiry-date" placeholder="MM/YY">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" class="form-control" id="cvv">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if (!empty($cartitems)): ?>
          <div class="col-lg-5 mt-md-30px mt-lm-30px">
            <div class="your-order-area" style="position: sticky; top: 70px">
              <h3>Your order</h3>
              <div class="your-order-wrap gray-bg-4">
                <div class="your-order-product-info">
                  <div class="your-order-top">
                    <ul>
                      <li>Product</li>
                      <li>Total</li>
                    </ul>
                  </div>
                  <div class="your-order-middle" id="middle" style="border-bottom: none; margin-bottom: 0;">
                    <ul>
                      <?php foreach ($cartitems as $cartitem): ?>
                        <li><span class="order-middle-left"><?= $cartitem->product ?> X <?= $cartitem->quantity ?></span> <span
                            class="order-price"><?= $cartitem->subTotalAsCurrency() ?></span></li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                  <?php if ($cart->couponDiscountAmount()): ?>
                    <div class="your-order-bottom" id="coupon-wrapper" style="border-top: 1px solid #dee0e4; padding-top: 19px">
                      <ul>
                        <li class="couponlist-item-label"><b>Coupon (<?= $cart->coupon->label ? $cart->coupon->label : $cart->coupon->code ?>)</b></li>
                        <li class="couponlist-item-value">-<?= $cart->couponDiscountAmountAsCurrency() ?></li>
                      </ul>
                    </div>
                  <?php endif ?>
                  <div class="your-order-total">
                    <ul>
                      <li class="order-total">Total</li>
                      <li id="grandTotal"><?= $cart->totalPriceAsCurrency() ?></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="Place-order mt-25">
                <?= Html::submitButton('Place Order', ['class' => 'btn-hover']) ?>
              </div>
              <div class="discount-code-wrapper mt-4">
                <div class="title-wrap">
                  <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                </div>
                <div class="discount-code">
                  <p>Enter your coupon code if you have one.</p>
                  <input type="text" id="couponCode" name="coupon">
                  <button class="cart-btn-2" hx-post="/site/apply-coupon" hx-trigger="click" hx-include="#couponCode" hx-target="#cartModal .modal-content">Apply Coupon</button>
                </div>
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>
      <?php ActiveForm::end() ?>
    </div>
  <?php else: ?>
    <div class="empty-cart-area pb-100px pt-100px">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="cart-heading">
              <h2>Checkout</h2>
            </div>
            <div class="empty-text-contant text-center">
              <i class="pe-7s-upload"></i>
              <h3>There is nothing to order, go to shop and select few products and add it to your cart!</h3>
              <a class="empty-cart-btn" href="/shop">
                <i class="fa fa-arrow-left"> </i> Go to shopping
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
</div>

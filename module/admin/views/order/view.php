<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => "Orders", "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

  <div class="container mt-5">
    <h1 class="mb-4">Order Details</h1>

    <div class="row gy-4">
      <div class="col-7">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Order Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Order ID:</strong> <span id="orderId"><?= $model->id ?></span></p>
                <p><strong>Status:</strong> <span id="status" class="badge bg-info"><?= $model->status ?></span></p>
                <p><strong>Created At:</strong> <span id="createdAt"><?= $model->created_at ?></span></p>
                <p><strong>Updated At:</strong> <span id="updatedAt"><?= $model->updated_at ?></span></p>
              </div>
              <div class="col-md-6">
                <p><strong>Payment Type:</strong> <span id="paymentType"><?= $model->payment_type ?></span></p>
                <p><strong>Delivery Type:</strong> <span id="deliveryType"><?= $model->delivery_type ?></span></p>
                <?php if ($model->coupon) : ?>
                  <p><strong>Coupon:</strong> <span id="couponId"><?= $model->coupon ?></span></p>
                <?php endif ?>

                <?php if ($model->deliveryPoint): ?>
                  <p><strong>Delivery point:</strong> <span id="deliveryType"><?= $model->deliveryPoint ?></span></p>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div class="card h-100">
          <div class="card-header bg-secondary text-white">
            <h5 class="card-title mb-0">User Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>User ID:</strong> <span id="userId"></span></p>
                <p><strong>First Name:</strong> <span id="userFirstName"><?= $model->address->user_first_name ?></span></p>
                <p><strong>Last Name:</strong> <span id="userLastName"><?= $model->address->user_last_name ?></span></p>
              </div>
              <div class="col-md-6">
                <p><strong>Phone Number:</strong> <span id="userPhoneNumber"><?= $model->address->user_phone_number ?></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Additional Information</h5>
          </div>
          <div class="card-body">
            <p><strong>Comment for Courier:</strong> <span id="commentForCourier"><?= $model->comment_for_courier ?></span></p>
            <p><strong>Order overall price</strong> <span id="commentForCourier"><?= $model->totalPriceAsCurrency() ?></span></p>
          </div>
        </div>
      </div>

      <div class="col-7">
        <div class="card h-100">
          <div class="card-header bg-warning">
            <h5 class="card-title mb-0">Cart Items</h5>
          </div>
          <div class="card-body">
            <div id="cartItems">
              <?php foreach ($model->cartItems as $cartItem): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?= $cartItem->product ?>
                  <span class="badge bg-primary rounded-pill"><?= $cartItem->quantity ?> x <?= $cartItem->product->priceAsCurrency() ?></span>
                </li>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>

      <?php if ($model->address): ?>
        <div class="col-12">
          <div class="card h-100">
            <div class="card-header bg-secondary">
              <h5 class="card-title mb-0">User address</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <p><strong>City:</strong> <span id="orderId"><?= $model->address->city; ?></span></p>
                  <p><strong>Street address:</strong> <span id="orderId"><?= $model->address->street_address; ?></span></p>
                  <p><strong>Zip code:</strong> <span id="orderId"><?= $model->address->zip_code; ?></span></p>
                  <p><strong>Apartment:</strong> <span id="orderId"><?= $model->address->apartment; ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>

    </div>
    <div class="mt-4">
      <?= Html::a(
        "Update",
        ["update", "id" => $model->id],
        ["class" => "btn btn-primary"]
      ) ?>
      <?= Html::a(
        "Delete",
        ["delete", "id" => $model->id],
        [
          "class" => "btn btn-danger",
          "data" => [
            "confirm" => "Are you sure you want to delete this item?",
            "method" => "post",
          ],
        ]
      ) ?>
    </div>
  </div>
</div>

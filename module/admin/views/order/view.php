<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = Yii::t('app', 'Order {id}', ['id' => $model->id]);
$this->params["breadcrumbs"][] = ["label" => Yii::t('app', 'Orders'), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

  <div class="container mt-5">
    <h1 class="mb-4"><?= Yii::t('app', 'Order Details') ?></h1>

    <div class="row gy-4">
      <div class="col-7">
        <div class="card h-100">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><?= Yii::t('app', 'Order Information') ?></h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong><?= Yii::t('app', 'Order ID') ?>:</strong> <span id="orderId"><?= Html::encode($model->id) ?></span></p>
                <p><strong><?= Yii::t('app', 'Status') ?>:</strong> <span id="status" class="badge bg-info"><?= Html::encode($model->status) ?></span></p>
                <p><strong><?= Yii::t('app', 'Created At') ?>:</strong> <span id="createdAt"><?= Html::encode($model->created_at) ?></span></p>
                <p><strong><?= Yii::t('app', 'Updated At') ?>:</strong> <span id="updatedAt"><?= Html::encode($model->updated_at) ?></span></p>
              </div>
              <div class="col-md-6">
                <p><strong><?= Yii::t('app', 'Payment Type') ?>:</strong> <span id="paymentType"><?= Html::encode($model->payment_type) ?></span></p>
                <p><strong><?= Yii::t('app', 'Delivery Type') ?>:</strong> <span id="deliveryType"><?= Html::encode($model->delivery_type) ?></span></p>
                <?php if ($model->coupon) : ?>
                  <p><strong><?= Yii::t('app', 'Coupon') ?>:</strong> <span id="couponId"><?= Html::encode($model->coupon) ?></span></p>
                <?php endif ?>

                <?php if ($model->deliveryPoint): ?>
                  <p><strong><?= Yii::t('app', 'Delivery Point') ?>:</strong> <span id="deliveryPoint"><?= Html::encode($model->deliveryPoint) ?></span></p>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div class="card h-100">
          <div class="card-header bg-secondary text-white">
            <h5 class="card-title mb-0"><?= Yii::t('app', 'User Information') ?></h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong><?= Yii::t('app', 'User ID') ?>:</strong> <span id="userId"><?= Html::encode($model->address->user_id) ?></span></p>
                <p><strong><?= Yii::t('app', 'First Name') ?>:</strong> <span id="userFirstName"><?= Html::encode($model->address->user_first_name) ?></span></p>
                <p><strong><?= Yii::t('app', 'Last Name') ?>:</strong> <span id="userLastName"><?= Html::encode($model->address->user_last_name) ?></span></p>
              </div>
              <div class="col-md-6">
                <p><strong><?= Yii::t('app', 'Phone Number') ?>:</strong> <span id="userPhoneNumber"><?= Html::encode($model->address->user_phone_number) ?></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0"><?= Yii::t('app', 'Additional Information') ?></h5>
          </div>
          <div class="card-body">
            <p><strong><?= Yii::t('app', 'Comment for Courier') ?>:</strong> <span id="commentForCourier"><?= Html::encode($model->comment_for_courier) ?></span></p>
            <p><strong><?= Yii::t('app', 'Order Overall Price') ?>:</strong> <span id="orderPrice"><?= Html::encode($model->totalPriceAsCurrency()) ?></span></p>
          </div>
        </div>
      </div>

      <div class="col-7">
        <div class="card h-100">
          <div class="card-header bg-warning">
            <h5 class="card-title mb-0"><?= Yii::t('app', 'Cart Items') ?></h5>
          </div>
          <div class="card-body">
            <ul id="cartItems" class="list-group">
              <?php foreach ($model->cartItems as $cartItem): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?= Html::encode($cartItem->product) ?>
                  <span class="badge bg-primary rounded-pill"><?= Html::encode($cartItem->quantity) ?> x <?= Html::encode($cartItem->product->priceAsCurrency()) ?></span>
                </li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>

      <?php if ($model->address): ?>
        <div class="col-12">
          <div class="card h-100">
            <div class="card-header bg-secondary">
              <h5 class="card-title mb-0"><?= Yii::t('app', 'User Address') ?></h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <p><strong><?= Yii::t('app', 'City') ?>:</strong> <span id="city"><?= Html::encode($model->address->city) ?></span></p>
                  <p><strong><?= Yii::t('app', 'Street Address') ?>:</strong> <span id="streetAddress"><?= Html::encode($model->address->street_address) ?></span></p>
                  <p><strong><?= Yii::t('app', 'Zip Code') ?>:</strong> <span id="zipCode"><?= Html::encode($model->address->zip_code) ?></span></p>
                  <p><strong><?= Yii::t('app', 'Apartment') ?>:</strong> <span id="apartment"><?= Html::encode($model->address->apartment) ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>

    </div>
    <div class="mt-4">
      <?= Html::a(
        Yii::t('app', 'Update'),
        ["update", "id" => $model->id],
        ["class" => "btn btn-primary"]
      ) ?>
      <?= Html::a(
        Yii::t('app', 'Delete'),
        ["delete", "id" => $model->id],
        [
          "class" => "btn btn-danger",
          "data" => [
            "confirm" => Yii::t('app', 'Are you sure you want to delete this item?'),
            "method" => "post",
          ],
        ]
      ) ?>
    </div>
  </div>
</div>

<?php

use app\models\Order;
use app\models\User;
use yii\helpers\Html;

/** @var Order[] $orders */
/** @var User $user */

$csrfToken = Yii::$app->request->csrfToken;
$script = <<<JS
var make = (tag, content) => `<` + tag + `>` + content + `</` + tag + `>`;

function insertNewBillingAddress(userAddress) {
  $('.user-address-table-wrapper').show()
  $('#billingAddressesEmpty').hide()
  console.log(
    $('.user-address-table-wrapper').css({ display: 'block'})
  )
  const newRow = $('<tr>');
  newRow.attr('id', 'useraddress-item-' + userAddress.id)
  newRow.append(make('td', $('#userAddressTable tbody').children().length + 1))
  newRow.append(make('td', userAddress.user_first_name + " " + userAddress.user_last_name));
  newRow.append(make('td', userAddress.city));
  newRow.append(make('td', userAddress.apartment));
  newRow.append(make('td', userAddress.street_address));
  newRow.append(make('td', userAddress.user_phone_number));
  newRow.append(make('td', userAddress.label));
  newRow.append(make('td', userAddress.zip_code));
  var actionTd = $('<td>')
  var actionBtn = $('<a class="view" href="#">Delete</a>');
  actionBtn.attr('hx-post', '/site/delete-useraddress');
  actionBtn.attr('hx-vals', JSON.stringify({ id: userAddress.id, _csrf: "{$csrfToken}" }))
  actionBtn.attr('data-bs-toggle', 'modal');
  actionBtn.attr('data-bs-target', '#cartModal');
  actionBtn.attr('hx-target', '#cartModal .modal-content')
  actionBtn.attr('hx-trigger', 'click')
  
  actionTd.append(actionBtn);
  newRow.append(actionTd)
  htmx.process(actionBtn[0]);
  $('#userAddressTable tbody').append(newRow);
}

function removeBillingAddress(id) {
  console.log(id)
  if ($('#userAddressTable tbody tr').length < 1) {
    $('.user-address-table-wrapper').hide()
    $('#billingAddressesEmpty').show();
  }
  $('#useraddress-item-' + id).remove();
}
window.insertNewBillingAddress = insertNewBillingAddress;
window.removeBillingAddress = removeBillingAddress
JS;

$this->registerJs($script);

$this->title = Yii::t('app', "Account");
$this->params["breadcrumbs"][] = $this->title;
?>
<style>
  table td {
    white-space: nowrap;
  }
</style>
<div class="account-dashboard pt-100px pb-100px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <!-- Nav tabs -->
        <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
          <ul role="tablist" class="nav flex-column dashboard-list">
            <li>
              <a href="#dashboard" data-bs-toggle="tab" class="nav-link active"><?= Yii::t('app', 'Dashboard') ?></a>
            </li>
            <li>
              <a href="#orders" data-bs-toggle="tab" class="nav-link"><?= Yii::t('app', 'Orders') ?></a>
            </li>
            <li>
              <a href="#address" data-bs-toggle="tab" class="nav-link"><?= Yii::t('app', 'Addreses') ?></a>
            </li>
            <li>
              <a href="#account-details" data-bs-toggle="tab" class="nav-link"><?= Yii::t('app', 'Account details') ?></a>
            </li>
            <li>
              <?= Html::beginForm(["/site/logout"]) .
                Html::submitButton(Yii::t('app', 'Logout'), ["class" => "nav-link"]) .
                Html::endForm() ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-sm-12 col-md-9 col-lg-9">
        <!-- Tab panes -->
        <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
          <div class="tab-pane fade show active" id="dashboard">
            <h4><?= Yii::t('app', 'Dashboard') ?> </h4>

            <p><?= Yii::t('app', 'From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a> and <a href="#">Edit your password and account details.</a>') ?></p>

          </div>
          <div class="tab-pane fade" id="orders">
            <h4>Orders</h4>
            <div class="table_page table-responsive">
              <?php if (!empty($orders)): ?>
                <table>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?= Yii::t('app', 'Order ID') ?></th>
                      <th><?= Yii::t('app', 'Date') ?></th>
                      <th><?= Yii::t('app', 'Status') ?></th>
                      <th><?= Yii::t('app', 'Total') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($orders as $index => $order) : ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $order->id ?></td>
                        <td><?= Yii::$app->formatter->asDate($order->created_at, 'medium') ?></td>
                        <td><?= $order->status ?></td>
                        <td style="white-space: nowrap;"><?= $order->totalPriceAsCurrency() ?> for <?= count($order->cartItems) ?> item<?= count($order->cartItems) > 1 ? 's' : '' ?> </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              <?php else: ?>
                <div class="empty-text-contant text-center">
                  <i class="pe-7s-shopbag"></i>
                  <h3><?= Yii::t('app', "You haven't ordered anything yet") ?></h3>
                  <a class="empty-cart-btn" href="/shop">
                    <i class="fa fa-arrow-left"> </i><?= Yii::t('app', 'Go to shopping') ?>
                  </a>
                </div>
              <?php endif ?>
            </div>
          </div>
          <div class="tab-pane" id="address">
            <h4><?= Yii::t('app', 'Billing addresses') ?></h4>
            <div class="user-address-table-wrapper" style="display: <?= empty($user->userAddresses) ? 'none' : 'block' ?>">
              <div class="table_page table-responsive">
                <div>
                  <table id="userAddressTable">
                    <thead>
                      <tr>
                        <th><?= Yii::t('app', '#') ?></th>
                        <th><?= Yii::t('app', 'Full Name') ?></th>
                        <th><?= Yii::t('app', 'City') ?></th>
                        <th><?= Yii::t('app', 'Apartment') ?></th>
                        <th><?= Yii::t('app', 'Street Address') ?></th>
                        <th><?= Yii::t('app', 'Phone number') ?></th>
                        <th><?= Yii::t('app', 'Label') ?></th>
                        <th><?= Yii::t('app', 'Zip code') ?></th>
                        <th><?= Yii::t('app', 'Action') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($user->userAddresses as $index => $userAddress): ?>
                        <tr id="useraddress-item-<?= $userAddress->id ?>">
                          <td><?= $index + 1 ?></td>
                          <td><?= $userAddress->user_first_name . ' ' . $userAddress->user_last_name ?></td>
                          <td><?= $userAddress->city ?></td>
                          <td><?= $userAddress->apartment ?></td>
                          <td><?= $userAddress->street_address ?></td>
                          <td><?= $userAddress->user_phone_number ?></td>
                          <td><?= $userAddress->label ?></td>
                          <td><?= $userAddress->zip_code ?></td>
                          <td>
                            <a hx-swap="none" hx-post="/site/delete-useraddress" hx-target="#cartModal .modal-content" hx-trigger="click" hx-vals='{"id": <?= $userAddress->id ?>, "_csrf": "<?= Yii::$app->request->csrfToken ?>"}' href="#" class="view">Delete</a>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <button
                class="btn-secondary mt-3"
                data-bs-toggle="modal"
                data-bs-target="#addressModal"
                hx-get="/admin/user-address/create/?d=true"
                hx-target="#addressModal .modal-content">
                <i class="fa fa-plus"> </i>
                <?= Yii::t('app', 'Add User Address') ?>
              </button>
            </div>

            <div id="billingAddressesEmpty" class="empty-text-contant text-center" style="display: <?= empty($user->userAddresses) ? 'block' : 'none' ?>">

              <i class="pe-7s-id"></i>
              <h3 class="mb-2"><?= Yii::t('app', 'You do not have any addresses') ?></h3>
              <p class="text-muted"><?= Yii::t('app', 'You can use these billing address information while ordering something') ?></p>
              <a
                href="#"
                class="empty-cart-btn mt-2"
                data-bs-toggle="modal"
                data-bs-target="#addressModal"
                hx-get="/admin/user-address/create/?d=true"
                hx-target="#addressModal .modal-content">
                <i class="fa fa-plus"> </i> <?= Yii::t('app', 'Create new one') ?>
              </a>
            </div>
          </div>
          <div class="tab-pane fade" id="account-details">
            <h3><?= Yii::t('app', 'Account details') ?></h3>
            <p><?= Yii::t('app', 'working on this feature') ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addressModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content p-3"></div>
      </div>
    </div>
  </div>
</div>

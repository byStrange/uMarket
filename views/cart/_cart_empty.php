<div class="empty-cart-area pb-100px pt-100px">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="cart-heading">
          <h2><?= Yii::t('app', 'Your cart item') ?></h2>
        </div>
        <div class="empty-text-contant text-center">
          <i class="pe-7s-shopbag"></i>
          <h3><?= Yii::t('app', 'There are no more items in your cart') ?></h3>
          <a class="empty-cart-btn" href="/shop">
            <i class="fa fa-arrow-left"> </i> <?= Yii::t('app', 'Continue shopping') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

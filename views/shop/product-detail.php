<?php

use app\models\Product;
use app\models\Rating;
use app\models\User;

/** @var Product $product **/
/** @var yii\web\View $this */
/** @var Rating $review_model */

/** @var User $user */
$user = Yii::$app->user->identity;

if ($user) {

  $viewedProducts = $user->getViewedProducts([$product->id])->all();
} else {
  $viewedProducts = User::getRecentlySeenProducts(5, [$product->id]);
  /*Utils::printAsError($viewedProducts);*/
}

$this->title = Yii::t('app', 'Product detail');
$this->params["breadcrumbs"][] = $this->title;
?>
<script>
  setTimeout(function() {
    htmx.ajax('GET', '/shop/product-view?id=' + '<?= $product->id ?>', {
      swap: 'none'
    })
  }, 100)
</script>

<div class="pt-100px pb-100px">
  <?= $this->render('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => true, "review_model" => $review_model]) ?>
</div>

<?php if (count($product->getToProducts()->where(['status' => Product::VISIBLE_STATUSES])->all())): ?>
  <div class="product-area related-product">
    <div class="container">
      <!-- Section Title & Tab Start -->
      <div class="row">
        <div class="col-12">
          <div class="section-title text-center m-0">
            <h2 class="title"><?= Yii::t('app', 'Related Products') ?></h2>
            <p><?= Yii::t('app', 'Check out these products that might interest you') ?></p>
          </div>
        </div>
      </div>
      <!-- Section Title & Tab End -->
      <?= $this->render('@app/components/product/_products_list', ["products" => $product->toProducts, "view" => &$this, "swiperEnabled" => true]); ?>
    </div>
  </div>
<?php endif ?>

<?php if ($viewedProducts && count($viewedProducts)): ?>
  <div class="product-area related-product">
    <div class="container">
      <!-- Section Title & Tab Start -->
      <div class="row">
        <div class="col-12">
          <div class="section-title text-center m-0">
            <h2 class="title"><?= Yii::t('app', 'Recently viewed') ?></h2>
            <p><?= Yii::t('app', 'You have recenlty viewed these products.') ?></p>
          </div>
        </div>
      </div>
      <!-- Section Title & Tab End -->
      <?= $this->render('@app/components/product/_products_list', ["products" => $viewedProducts, "view" => &$this, "swiperEnabled" => true]); ?>
    </div>
  </div>
<?php endif ?>

<?php

use app\models\Product;

/** @var Product $product **/
/** @var yii\web\View $this */

$this->title = "Product detail";
$this->params["breadcrumbs"][] = $this->title;
?>

<div class="pt-100px pb-100px">
  <?= $this->render('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => true]) ?>
</div>

<?php if (count($product->toProducts)): ?>
<div class="product-area related-product">
  <div class="container">
    <!-- Section Title & Tab Start -->
    <div class="row">
      <div class="col-12">
        <div class="section-title text-center m-0">
          <h2 class="title">Related Products</h2>
          <p>There are many variations of passages of Lorem Ipsum available</p>
        </div>
      </div>
    </div>
    <!-- Section Title & Tab End -->
    <?= $this->render('@app/components/product/_products_list', ["products" => $product->toProducts, "view" => &$this, "swiperEnabled" => true]); ?>
  </div>
</div>
<?php endif ?>

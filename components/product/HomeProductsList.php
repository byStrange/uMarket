<?php
use app\models\Product;
/** @var Product[] $products */
/** @var Product[] $famous8 */
/** @var yii\web\View $view */
?>
<div class="product-area pb-100px">
  <div class="container">
    <!-- Section Title & Tab Start -->
    <div class="row">
      <div class="col-12">
        <!-- Tab Start -->
        <div class="tab-slider d-md-flex justify-content-md-between align-items-md-center">
          <ul class="product-tab-nav nav justify-content-start align-items-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#newarrivals">New Arrivals</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#toprated">Top Rated</button>
            </li>
          </ul>
        </div>
        <!-- Tab End -->
      </div>
    </div>
    <!-- Section Title & Tab End -->
    <div class="row">
      <div class="col">
        <div class="tab-content mt-60px">
          <!-- 1st tab start -->
          <div class="tab-pane fade show active" id="newarrivals">
            <div class="row mb-n-30px">
              <?= $view->render('@app/components/product/_products_list', ["view" => &$view, "products" => $products]) ?>
            </div>
          </div>
          <!-- 1st tab end -->

          <!-- 2nd tab start -->
          <div class="tab-pane fade" id="toprated">
            <div class="row">
              <?= $view->render('@app/components/product/_products_list', ["view" => &$view, "products" => $famous8]) ?>
            </div>
          </div>
          <!-- 2nd tab end -->
        </div>
      </div>
    </div>
  </div>
</div>

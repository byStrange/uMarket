<?php
use app\models\Product;
use Yii;

/** @var Product[] $products */
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
              <?php
                foreach ($products as $product) {
                  echo $view->render('_product_card', ["product" => $product]);
                }
              ?>

            </div>
          </div>
          <!-- 1st tab end -->

          <!-- 2nd tab start -->
          <div class="tab-pane fade" id="toprated">
            <div class="row">
              <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                <!-- Single Prodect -->
                <div class="product">
                  <span class="badges">
                    <span class="sale">-5%</span>
                  </span>
                  <div class="thumb">
                    <a href="single-product.html" class="image">
                      <img src="/images/product-image/8.webp" alt="Product" />
                      <img class="hover-image" src="/images/product-image/8.webp" alt="Product" />
                    </a>
                  </div>
                  <div class="content">
                    <span class="category"><a href="#">Accessories</a></span>
                    <h5 class="title"><a href="single-product.html">Power Bank 10000Mhp
                      </a>
                    </h5>
                    <span class="price">
                      <span class="old">$260.00</span>
                      <span class="new">$238.50</span>
                    </span>
                  </div>
                  <div class="actions">
                    <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart"><i class="pe-7s-shopbag"></i></button>
                    <button class="action wishlist" title="Wishlist" data-bs-toggle="modal" data-bs-target="#exampleModal-Wishlist"><i class="pe-7s-like"></i></button>
                    <button class="action quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="pe-7s-look"></i></button>
                    <button class="action compare" title="Compare" data-bs-toggle="modal" data-bs-target="#exampleModal-Compare"><i class="pe-7s-refresh-2"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- 2nd tab end -->
        </div>
      </div>
    </div>
  </div>
</div>

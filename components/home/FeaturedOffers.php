<?php
namespace app\components\home;

use yii\base\Widget;

class FeaturedOffers extends Widget {
  public function run()
  {
    return <<<HTML
      <div class="feature-product-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Featured Offers</h2>
                        <p>There are many variations of passages of Lorem Ipsum available</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 mb-md-35px mb-lm-35px">
                    <div class="single-feature-content">
                        <div class="feature-image">
                            <img src="/images/feature-image/1.webp" alt="">
                        </div>
                        <div class="top-content">
                            <h4 class="title"><a href="single-product.html">Bluetooth Headphone </a></h4>
                            <span class="price">
                                <span class="old"><del>$48.50</del></span>
                                <span class="new">$38.50</span>
                            </span>
                        </div>
                        <div class="bottom-content">
                            <div class="deal-timing">
                                <div data-countdown="2021/09/15"></div>
                            </div>
                            <a href="single-product-variable.html" class="btn btn-primary  m-auto"> Shop
                                Now </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="feature-right-content">
                        <div class="image-side">
                            <img src="/images/feature-image/2.webp" alt="">
                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart"><i class="pe-7s-shopbag"></i></button>
                        </div>
                        <div class="content-side">
                            <div class="deal-timing">
                                <span>End In:</span>
                                <div data-countdown="2021/09/15"></div>
                            </div>
                            <div class="prize-content">
                                <h5 class="title"><a href="single-product.html">Ladies Smart Watch</a></h5>
                                <span class="price">
                                    <span class="old">$48.50</span>
                                    <span class="new">$38.50</span>
                                </span>
                            </div>
                            <div class="product-feature">
                                <ul>
                                    <li>Predecessor : <span>None.</span></li>
                                    <li>Support Type : <span>Neutral.</span></li>
                                    <li>Cushioning : <span>High Energizing.</span></li>
                                    <li>Total Weight : <span> 300gm</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="feature-right-content mt-30px">
                        <div class="image-side">
                            <img src="/images/feature-image/3.webp" alt="">
                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart"><i class="pe-7s-shopbag"></i></button>
                        </div>
                        <div class="content-side">
                            <div class="deal-timing">
                                <span>End In:</span>
                                <div data-countdown="2021/09/15"></div>
                            </div>
                            <div class="prize-content">
                                <h5 class="title"><a href="single-product.html">Ladies Smart Watch</a></h5>
                                <span class="price">
                                    <span class="old">$48.50</span>
                                    <span class="new">$38.50</span>
                                </span>
                            </div>
                            <div class="product-feature">
                                <ul>
                                    <li>Predecessor : <span>None.</span></li>
                                    <li>Support Type : <span>Neutral.</span></li>
                                    <li>Cushioning : <span>High Energizing.</span></li>
                                    <li>Total Weight : <span> 300gm</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    HTML; 
  }
}

?>
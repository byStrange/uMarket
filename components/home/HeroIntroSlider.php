<?php
namespace app\components\home;
use yii\base\Widget;
class HeroIntroSlider extends Widget {
  public function run()
  {
    return <<<HTML
      <div class="section">
        <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1 swiper-container-fade swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
            <!-- Hero slider Active -->
            <div class="swiper-wrapper" style="transition-duration: 0ms;" id="swiper-wrapper-4eab022c2bedd1c6" aria-live="off">
                <div class="hero-slide-item slider-height-2 swiper-slide bg-color1 swiper-slide-duplicate swiper-slide-duplicate-active" data-bg-image="/images/hero/bg/hero-bg-2-1.webp" style="background-image: url(&quot;/images/hero/bg/hero-bg-2-1.webp&quot;); width: 1144px; transition-duration: 0ms; opacity: 1; transform: translate3d(0px, 0px, 0px);" data-swiper-slide-index="1" role="group" aria-label="1 / 4">
                    <div class="container h-100">
                        <div class="row h-100 flex-row-reverse">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                <div class="hero-slide-content hero-slide-content-2 slider-animated-1">
                                    <h2 class="title-1">Lorem ipsum <br>
                                        For Smart Device </h2>
                                    <span class="price">
                                        <span class="mini-title">Only</span>
                                        <span class="amount">$48.00</span>
                                    </span>
                                    <a href="shop-left-sidebar.html" class="btn btn-primary text-capitalize">Shop All Devices</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-center">
                                <div class="show-case">
                                    <div class="hero-slide-image slider-2">
                                        <img src="/images/hero/inner-img/hero-2-1.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single slider item -->
                <div class="hero-slide-item slider-height-2 swiper-slide bg-color1 swiper-slide-prev swiper-slide-duplicate-next" data-bg-image="/images/hero/bg/hero-bg-2-1.webp" style="background-image: url(&quot;/images/hero/bg/hero-bg-2-1.webp&quot;); width: 1144px; transition-duration: 0ms; opacity: 1; transform: translate3d(-1144px, 0px, 0px);" data-swiper-slide-index="0" role="group" aria-label="2 / 4">
                    <div class="container h-100">
                        <div class="row h-100 flex-row-reverse">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                <div class="hero-slide-content hero-slide-content-2 slider-animated-1">
                                    <h2 class="title-1">Easy Your Life <br>
                                        For Smart Device </h2>
                                    <span class="price">
                                        <span class="mini-title">Only</span>
                                        <span class="amount">$24.00</span>
                                    </span>
                                    <a href="shop-left-sidebar.html" class="btn btn-primary text-capitalize">Shop All Devices</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-center">
                                <div class="show-case">
                                    <div class="hero-slide-image slider-2">
                                        <img src="/images/hero/inner-img/hero-2-1.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single slider item -->
                <div class="hero-slide-item slider-height-2 swiper-slide bg-color1 swiper-slide-active" data-bg-image="/images/hero/bg/hero-bg-2-1.webp" style="background-image: url(&quot;/images/hero/bg/hero-bg-2-1.webp&quot;); width: 1144px; transition-duration: 0ms; opacity: 1; transform: translate3d(-2288px, 0px, 0px);" data-swiper-slide-index="1" role="group" aria-label="3 / 4">
                    <div class="container h-100">
                        <div class="row h-100 flex-row-reverse">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                <div class="hero-slide-content hero-slide-content-2 slider-animated-1">
                                    <h2 class="title-1">Lorem ipsum <br>
                                        For Smart Device </h2>
                                    <span class="price">
                                        <span class="mini-title">Only</span>
                                        <span class="amount">$48.00</span>
                                    </span>
                                    <a href="shop-left-sidebar.html" class="btn btn-primary text-capitalize">Shop All Devices</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-center">
                                <div class="show-case">
                                    <div class="hero-slide-image slider-2">
                                        <img src="/images/hero/inner-img/hero-2-1.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-slide-item slider-height-2 swiper-slide bg-color1 swiper-slide-duplicate swiper-slide-next swiper-slide-duplicate-prev" data-bg-image="/images/hero/bg/hero-bg-2-1.webp" style="background-image: url(&quot;/images/hero/bg/hero-bg-2-1.webp&quot;); width: 1144px; transition-duration: 0ms; opacity: 0; transform: translate3d(-3432px, 0px, 0px);" data-swiper-slide-index="0" role="group" aria-label="4 / 4">
                    <div class="container h-100">
                        <div class="row h-100 flex-row-reverse">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                <div class="hero-slide-content hero-slide-content-2 slider-animated-1">
                                    <h2 class="title-1">Easy Your Life <br>
                                        For Smart Device </h2>
                                    <span class="price">
                                        <span class="mini-title">Only</span>
                                        <span class="amount">$24.00</span>
                                    </span>
                                    <a href="shop-left-sidebar.html" class="btn btn-primary text-capitalize">Shop All Devices</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-center">
                                <div class="show-case">
                                    <div class="hero-slide-image slider-2">
                                        <img src="/images/hero/inner-img/hero-2-1.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-white"></div>
            <!-- Add Arrows -->
            <div class="swiper-buttons">
                <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-4eab022c2bedd1c6"></div>
                <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-4eab022c2bedd1c6"></div>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>    
    HTML;
  } 
}

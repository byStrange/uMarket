<?php

namespace app\components\home;

use app\models\Cart;
use Yii;
use yii\base\Widget;

class Header extends Widget
{
  public function run()
  {
    $cart = Cart::getOrCreateCurrentInstance();
    $cart_items = $cart->cartItems;
    $cart_items_count = count($cart_items);

    $content = <<<HTML



      <header>
          <!-- Header top area start -->
          <div class="header-top">
              <div class="container">
                  <div class="row justify-content-between align-items-center">
                      <div class="col">
                          <div class="welcome-text">
                              <p>World Wide Completely Free Returns and Shipping</p>
                          </div>
                      </div>
                      <div class="col d-none d-lg-block">
                          <div class="top-nav">
                              <ul>
HTML;
    if (!Yii::$app->user->isGuest) {
      $content .= <<<HTML
                        <li><a href="/site/account"><i class="fa fa-user"></i>Profile</a></li>
HTML;
      if (Yii::$app->user->identity->is_superuser) {
        $content .= <<<HTML
                        <li><a href="/admin"><i class="fa fa-wrench"></i> Admin panel</a></li>
HTML;
      }
    } else {
      $content .= <<<HTML
                        <li><a href="site/login">Login</a></li>
HTML;
    }

    $content .= <<<HTML
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header top area end -->
    <!-- Header action area start -->
    <div class="header-bottom  d-none d-lg-block">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-3 col">
                    <div class="header-logo">
                        <a href="/"><img src="/images/logo/logo.png" alt="Site Logo" /></a>
                    </div>
                </div>
                <!-- <div class="col-lg-6 d-none d-lg-block">
                        <div class="search-element">
                            <form action="#">
                                <input type="text" placeholder="Search" />
                                <button><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                    </div> -->
                <div class="col-lg-3 col">
                    <div class="header-actions">
                        <!-- Single Wedge Start -->
                        <a href="#offcanvas-wishlist" hx-get="/cart/wishlist?d=true" hx-target="#offcanvas-wishlist .body" hx-trigger="click" class="header-action-btn offcanvas-toggle">
                            <i class="pe-7s-like"></i>
                        </a>
                        <!-- Single Wedge End -->
                        <a href="#offcanvas-cart" hx-get="/cart/?d=true" hx-target="#offcanvas-cart .body" hx-trigger="click" class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                            <i class="pe-7s-shopbag"></i>
                                  
                        </a>
                        <a href="#offcanvas-mobile-menu" class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                            <i class="pe-7s-menu"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header action area end -->
    <!-- Header action area start -->
    <div class="header-bottom d-lg-none sticky-nav style-1">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-3 col">
                    <div class="header-logo">
                        <a href="index.html"><img src="/images/logo/logo.png" alt="Site Logo" /></a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="search-element">
                        <form action="#">
                            <input type="text" placeholder="Search" />
                            <button><i class="pe-7s-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col">
                    <div class="header-actions">
                        <!-- Single Wedge Start -->
                        <a href="#offcanvas-wishlist" class="header-action-btn offcanvas-toggle">
                            <i class="pe-7s-like"></i>
                        </a>
                        <!-- Single Wedge End -->
                        <a href="#offcanvas-cart" class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                            <i class="pe-7s-shopbag"></i>
                                            <span class="header-action-num">
    HTML;
    $content .= $cart_items_count;
    $content .= <<<HTML

                                            </span>
                            <!-- <span class="cart-amount">€30.00</span> -->
                        </a>
                        <a href="#offcanvas-mobile-menu" class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                            <i class="pe-7s-menu"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header action area end -->
    <!-- header navigation area start -->
    <div class="header-nav-area d-none d-lg-block sticky-nav">
        <div class="container">
            <div class="header-nav">
                <div class="main-menu position-relative">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/shop">Shop</a>
                            <!-- <li class="dropdown "><a href="#">Blog <i class="fa fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li class="dropdown position-static"><a href="blog-grid-left-sidebar.html">Blog Grid
                                            <i class="fa fa-angle-right"></i></a>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><a href="blog-grid.html">Blog Grid</a></li>
                                            <li><a href="blog-grid-left-sidebar.html">Blog Grid Left Sidebar</a></li>
                                            <li><a href="blog-grid-right-sidebar.html">Blog Grid Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown position-static"><a href="blog-list-left-sidebar.html">Blog List
                                            <i class="fa fa-angle-right"></i></a>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><a href="blog-list.html">Blog List</a></li>
                                            <li><a href="blog-list-left-sidebar.html">Blog List Left Sidebar</a></li>
                                            <li><a href="blog-list-right-sidebar.html">Blog List Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown position-static"><a href="blog-single-left-sidebar.html">Single
                                            Blog <i class="fa fa-angle-right"></i></a>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><a href="blog-single.html">Single Blog</a>
                                            <li><a href="blog-single-left-sidebar.html">Single Blog Left Sidebar</a>
                                            </li>
                                            <li><a href="blog-single-right-sidebar.html">Single Blog Right Sidebar</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- header navigation area end -->
    <div class="mobile-search-box d-lg-none">
        <div class="container">
            <!-- mobile search start -->
            <div class="search-element max-width-100">
                <form action="#">
                    <input type="text" placeholder="Search" />
                    <button><i class="pe-7s-search"></i></button>
                </form>
            </div>
            <!-- mobile search start -->
        </div>
    </div>
</header>
HTML;

    return $content;
  }
}

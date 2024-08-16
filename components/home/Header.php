<?php

use app\models\Cart;

// Get the current cart instance and items
$cart = Cart::getOrCreateCurrentInstance();
$cart_items = $cart->cartItems;
$cart_items_count = count($cart_items);

?>

<header>
  <!-- Header top area start -->
  <div class="header-top">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col">
          <div class="welcome-text">
            <p><?= Yii::t('app', 'World Wide Completely Free Returns and Shipping') ?></p>
          </div>
        </div>
        <div class="col d-none d-lg-block">
          <div class="top-nav">
            <ul>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Language
                </a>
                <ul class="dropdown-menu dropdown-menu-dark flex-column" style="display: none" aria-labelledby="navbarDarkDropdownMenuLink">
                  <li class="w-100 m-0 p-1"><a class="dropdown-item" href="/site/language?l=uz-UZ">Uz</a></li>
                  <li class="w-100 m-0 p-1"><a class="dropdown-item" href="/site/language?l=en-US">En</a></li>
                  <li class="w-100 m-0 p-1"><a class="dropdown-item" href="/site/language?l=ru-RU">Ru</a></li>
                </ul>
              </li>

              <?php if (!Yii::$app->user->isGuest): ?>
                <li><a href="/site/account"><i class="fa fa-user"></i> <?= Yii::t('app', 'Profile') ?></a></li>
                <?php if (Yii::$app->user->identity->is_superuser): ?>
                  <li><a href="/admin"><i class="fa fa-wrench"></i> <?= Yii::t('app', 'Admin panel') ?></a></li>
                <?php endif; ?>
              <?php else: ?>
                <li><a href="/site/login"><?= Yii::t('app', 'Login') ?></a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Header top area end -->

  <!-- Header action area start -->
  <div class="header-bottom d-none d-lg-block">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-3 col">
          <div class="header-logo">
            <a href="/"><img src="/images/logo/logo.png" alt="Site Logo" /></a>
          </div>
        </div>
        <div class="col-lg-3 col">
          <div class="header-actions">
            <!-- Single Wedge Start -->
            <a href="#offcanvas-wishlist" hx-get="/cart/wishlist?d=true" hx-target="#offcanvas-wishlist .body" hx-trigger="click" class="header-action-btn offcanvas-toggle">
              <i class="pe-7s-like"></i>
            </a>
            <!-- Single Wedge End -->
            <a href="#offcanvas-cart" hx-get="/cart/?d=true" hx-target="#offcanvas-cart .body" hx-trigger="click" class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
              <i class="pe-7s-shopbag"></i>
              <span class="header-action-num"><?= $cart_items_count ?></span>
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

  <!-- Header action area start for mobile -->
  <div class="header-bottom d-lg-none sticky-nav style-1">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-3 col">
          <div class="header-logo">
            <a href="/"><img src="/images/logo/logo.png" alt="Site Logo" /></a>
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
              <span class="header-action-num"><?= $cart_items_count ?></span>
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
            <li><a href="/"><?= Yii::t('app', 'Home') ?></a></li>
            <li><a href="/shop"><?= Yii::t('app', 'Shop') ?></a></li>
            <li><a href="/shop/categories"><?= Yii::t('app', 'Categories') ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- header navigation area end -->

</header>

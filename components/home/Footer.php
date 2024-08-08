<?php
namespace app\components\home;
use yii\base\Widget;

class Footer extends Widget
{
    public function run()
    {
        return <<<HTML
  <footer class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <!-- Start single blog -->
                    <div class="col-md-6 col-lg-3 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <div class="footer-logo">
                                <a href="index.html"><img src="/images/logo/footer-logo.png" alt=""></a>
                            </div>
                            <p class="about-text">Hmart: Your one-stop digital shop for quality products and great deals.</p>
                            <!--<ul class="link-follow">-->
                            <!--    <li>-->
                            <!--        <a class="m-0" title="Twitter" target="_blank" rel="noopener noreferrer" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a title="Tumblr" target="_blank" rel="noopener noreferrer" href="#"><i class="fa fa-tumblr" aria-hidden="true"></i>-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a title="Facebook" target="_blank" rel="noopener noreferrer" href="#"><i class="fa fa-twitter" aria-hidden="true"></i>-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a title="Instagram" target="_blank" rel="noopener noreferrer" href="#"><i class="fa fa-instagram" aria-hidden="true"></i>-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </div>
                    </div>
                    <!-- End single blog -->
                    <!-- Start single blog -->
                    <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-60px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Site</h4>
                            <div class="footer-links">
                                <div class="footer-row">
                                    <ul class="align-items-center">
                                        <li class="li"><a class="single-link" href="/site/account">My Account</a></li>
                                        <li class="li"><a class="single-link" href="/shop">Shop</a></li>
                                        <li class="li"><a class="single-link" href="/login">Services Login</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End single blog -->
                    <!-- Start single blog -->
                    <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-40px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Cart</h4>
                            <div class="footer-links">
                                <div class="footer-row">
                                    <ul class="align-items-center">
                                        <li class="li"><a class="single-link" href="/cart/wishlist">Wishlist</a></li>
                                        <li class="li"><a class="single-link" href="/cart">Cart</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="line-shape-top line-height-1">
                    <div class="row flex-md-row-reverse align-items-center">
                        <div class="col-md-6 text-center text-md-end">
                            <div class="payment-mth"><a href="#"><img class="img img-fluid" src="/images/icons/payment.png" alt="payment-image"></a></div>
                        </div>
                        <div class="col-md-6 text-center text-md-start">
                            <p class="copy-text"> © 2024 <strong>Hmart</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
HTML;
    }
}

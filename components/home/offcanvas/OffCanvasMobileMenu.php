<?php
namespace app\components\home\offcanvas;

use yii\base\Widget;

class OffCanvasMobileMenu extends Widget {
  public function run()
  {
      return <<<HTML
        <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
          <button class="offcanvas-close"></button>
          <div class="user-panel">
              <ul>
                  <li><a href="tel:974144145"><i class="fa fa-phone"></i> +998 97 414 41 45</a></li>
                  <li><a href="mailto:demo@example.com"><i class="fa fa-envelope-o"></i> demo@example.com</a></li>
                  <li><a href="my-account.html"><i class="fa fa-user"></i> Account</a></li>
              </ul>
          </div>
          <div class="inner customScroll">
              <div class="offcanvas-menu mb-4">
                  <ul>
                      <li><a href="index.html">Home</a>
                      <li><a href="about.html">About</a></li>
                      <li><a href="shop-3-column.html"></a></li>
                      <li><a href="contact.html">Contact Us</a></li>
                  </ul>
              </div>
              <!-- OffCanvas Menu End -->
              <div class="offcanvas-social mt-auto">
                  <ul>
                      <li>
                          <a href="#"><i class="fa fa-facebook"></i></a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-twitter"></i></a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-google"></i></a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-youtube"></i></a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-instagram"></i></a>
                      </li>
                  </ul>
              </div>
          </div>
        </div>
      HTML; 
  }
}

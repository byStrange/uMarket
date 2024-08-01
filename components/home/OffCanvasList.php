<?php
namespace app\components\home;

use app\components\home\offcanvas\OffCanvasMobileMenu;
use app\components\home\offcanvas\OffCanvasCart;
use app\components\home\offcanvas\OffCanvasWishList;

use yii\base\Widget;

class OffCanvasList extends Widget
{
    public function run()
    {
        echo "<div class=\"offcanvas-overlay\"></div>";
        echo OffCanvasWishList::widget();
        echo OffcanvasCart::widget();
        echo OffCanvasMobileMenu::widget();
    }
}

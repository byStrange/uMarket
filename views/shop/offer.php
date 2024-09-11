<?php

use app\models\FeaturedOffer;
use yii\web\View;


/** @var View $this */
/** @var FeaturedOffer $offer */


$this->title = $offer;
$this->params["breadcrumbs"][] = $this->title;

?>


<div class="shop-category-area pt-100px pb-100px">
  <?= $this->render('@app/components/product/_products_list', ["view" => &$this, "products" => $offer->products]) ?>
</div>


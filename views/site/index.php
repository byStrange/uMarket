<?php

/** @var yii\web\View $this */

use app\models\Product;

/** @var Product[] $products */

$this->title = "My Yii Application";
?>
<div>

  <!-- Hero/Intro Slider Start -->
  <?= $this->render("@app/components/home/HeroIntroSlider", [
    "featuredOffers" => $featuredOffers,
  ]) ?>
  <!-- Hero/Intro Slider End -->

  <!-- Banner Area Start -->
  <?= $this->render('@app/components/home/PinnedCategoriesList', [
    "view" => &$this,
    "categories" => &$pinned_categories
  ]) ?>
  <!-- Banner Area End -->

  <!-- Product Area Start -->
  <?= $this->render("@app/components/product/HomeProductsList", [
    "products" => $products,
    "famous8" => $famous8,
    "view" => &$this,
  ]) ?>
  <!-- Product Area End -->

  <!-- Feature product area start -->
  <?= $this->render('@app/components/home/FeaturedOffers', ["featuredOffers" => $featuredOffers, "view" => $this]) ?>
  <!-- Feature product area End -->
</div>

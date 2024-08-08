<?php

use app\models\Category;
use yii\helpers\Url;

/** @var Category $category */

?>
<div class="single-banner nth-child-2 mb-30px mb-lm-30px mt-lm-30px">
  <img src="/images/banner/4.webp" alt="">
  <div class="banner-content nth-child-2">
    <h3 class="title"><?= $category ?>></h3>
    <span class="category">From <?= $category->startingFromPriceAsCurrency() ?></span>
    <a href="<?= Url::toRoute(['shop/category', 'id' => $category->id]) ?>" class="shop-link"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  </div>
</div>

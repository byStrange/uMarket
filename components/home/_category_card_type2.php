<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Category $category */

$categoryImage = $category->getCategoryTranslationForLanguage()->image;
?>
<div class="single-banner nth-child-2 mb-30px mb-lm-30px mt-lm-30px border">
  <?= Html::img($categoryImage ? "/" . $categoryImage : '/images/banner/2.webp', ['alt' => $category->label, 'class' => 'img-responsive']) ?>
  <div class="banner-content nth-child-2">
    <h3 class="title"><?= $category ?>></h3>
    <span class="category"><?= Yii::t('app', 'From') ?> <?= $category->startingFromPriceAsCurrency() ?></span>
    <a href="<?= Url::toRoute(['shop/category', 'id' => $category->id]) ?>" class="shop-link"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  </div>
</div>

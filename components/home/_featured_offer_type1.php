<?php

/** @var app\models\FeaturedOffer $offer */

use yii\helpers\Html;
?>

<div class="single-feature-content" style="max-width: 570px;">
  <div class="feature-image">
    <?= Html::img("https://placehold.co/570x790", ['alt' => $offer->title]) ?>
  </div>
  <div class="top-content">
    <h4 class="title">
      <?php if ($offer->type === 'category'): ?>
        <?= Html::a($offer->title, ['category/view', 'id' => $offer->category_id]) ?>
      <?php else: ?>
        <?= Html::a($offer->title, ['product/view', 'id' => $offer->product_id]) ?>
      <?php endif; ?>
    </h4>
    <?php if ($offer->type !== 'category'): ?>
      <span class="price">
        <span class="old">
          <del>$<?= number_format($offer->product->price, 2) ?></del>
        </span>
        <span class="new">$<?= number_format($offer->dicount_price, 2) ?></span>
      </span>
    <?php endif; ?>
  </div>
  <div class="bottom-content">
    <div class="deal-timing" data-countdown="<?= $offer->end_time ?>"></div>
    <?php if ($offer->type === 'category'): ?>
      <?= Html::a('Shop Now', ['category/view', 'id' => $offer->category_id], ['class' => 'btn btn-primary m-auto']) ?>
    <?php else: ?>
      <?= Html::a('Shop Now', ['product/view', 'id' => $offer->product_id], ['class' => 'btn btn-primary m-auto']) ?>
    <?php endif; ?>
  </div>
</div>

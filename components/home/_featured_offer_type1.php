<?php

/** @var app\models\FeaturedOffer $offer */

use yii\helpers\Html;
?>

<div class="single-feature-content" style="max-width: 570px;">
  <div class="feature-image">
    <?= Html::img($offer->image_portrait ? '/' . $offer->image_portrait : 'https://placehold.co/570x790', ['alt' => $offer->title]) ?>
  </div>
  <div class="top-content">
    <h4 class="title">
      <?php if ($offer->type === 'category'): ?>
        <?= Html::a($offer->title, ['category/view', 'id' => $offer->category_id]) ?>
      <?php else: ?>
        <?php if (count($offer->products) === 1): ?>
          <?= Html::a($offer->title, ['shop/product', 'id' => $offer->products[0]->id]) ?>
        <?php else: ?>
          <?= Html::a($offer->title, ['shop/offer', 'id' => $offer->id]) ?>
        <?php endif ?>
      <?php endif; ?>
    </h4>
    <?php if ($offer->type !== 'category'): ?>
      <?php if (count($offer->products) === 1): ?>
        <span class="price">
          <span class="old">
            <del>$<?= $offer->products[0]->price ?></del>
          </span>
          <span class="new">$<?= $offer->startingFromPrice() ?></span>
        </span>
      <?php else: ?>
        <div class="price">
          <div class="new">
            <?= $offer->startingFromPriceAsCurrency() ?>
          </div>
        </div>
      <?php endif ?>

    <?php endif; ?>
  </div>
  <div class="bottom-content">
    <div class="deal-timing" data-countdown="<?= $offer->offerOffset() ?>"></div>
    <?php if ($offer->type === 'category'): ?>
      <?= Html::a('Shop Now', ['category/view', 'id' => $offer->category_id], ['class' => 'btn btn-primary m-auto']) ?>
    <?php else: ?>
      <?php if (count($offer->products) === 1): ?>
        <?= Html::a(Yii::t('app', 'Shop now'), ['shop/product', 'id' => $offer->products[0]->id], ['class' => 'btn btn-primary m-auto']) ?>
      <?php else: ?>
        <?= Html::a(Yii::t('app', 'Shop now'), ['shop/offer', 'id' => $offer->id], ['class' => 'btn btn-primary m-auto']) ?>
      <?php endif ?>
    <?php endif; ?>
  </div>
</div>

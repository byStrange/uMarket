<?php

/** @var app\models\FeaturedOffer $offer */

use yii\helpers\Html;
?>
<div class="feature-right-content">
  <div class="image-side">
    <?= Html::img('https://placehold.co/270x380', ['alt' => $offer->title]) ?>
    <?php if ($offer->type !== 'category'): ?>
      <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
        <i class="pe-7s-shopbag"></i>
      </button>
    <?php endif; ?>
  </div>
  <div class="content-side">
    <div class="deal-timing">
      <span>End In:</span>
      <div data-countdown="<?= $offer->end_time ?>"></div>
    </div>
    <div class="prize-content">
      <h5 class="title">
        <?php if ($offer->type === 'category'): ?>
          <?= Html::a($offer->title, ['shop/category', 'id' => $offer->category_id]) ?>
        <?php else: ?>
          <?= Html::a($offer->title, ['shop/offer', 'id' => $offer->id]) ?>
        <?php endif; ?>
      </h5>
      <?php if ($offer->type !== 'category'): ?>
        <span class="price">
          <span class="old">$<?= number_format($offer->product->price, 2) ?></span>
          <span class="new">$<?= number_format($offer->dicount_price, 2) ?></span>
        </span>
      <?php endif; ?>
    </div>
    <div class="product-feature">
      <ul>
        <?php if ($offer->type === 'category'): ?>
          <li>Category: <span><?= Html::encode($offer->category) ?></span></li>
        <?php else: ?>
          <li>Discount: <span><?= $offer->percentage ?>% OFF</span></li>
        <?php endif; ?>
        <li>Available Until: <span><?= Yii::$app->formatter->asDate($offer->end_time, 'php:F j, Y') ?></span></li>
      </ul>
    </div>
  </div>
</div>
<style>
  .feature-offer-card {
    display: flex;
    max-width: 400px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
  }

  .offer-image {
    position: relative;
    width: 40%;
  }

  .offer-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
  }

  .add-to-cart-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    /* Add styles for the button */
  }

  .offer-details {
    width: 60%;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .offer-title {
    margin: 0 0 10px;
    font-size: 1.1em;
  }

  .offer-info {
    margin-bottom: 10px;
  }

  .price-info {
    display: flex;
    flex-wrap: wrap;
    align-items: baseline;
    gap: 5px;
  }

  .old-price {
    text-decoration: line-through;
    color: #999;
  }

  .new-price {
    font-weight: bold;
    color: #e44d26;
  }

  .discount {
    background-color: #e44d26;
    color: white;
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 0.8em;
  }

  .category-info {
    font-weight: bold;
  }

  .offer-timer {
    font-size: 0.9em;
  }

  .countdown {
    font-weight: bold;
  }
</style>

<?php

use app\models\FeaturedOffer;
use yii\web\View;

/** @var FeaturedOffer[] $featuredOffers */
/** @var View $view */

usort($featuredOffers, function ($a, $b) {
  return strtotime($a->end_time) - strtotime($b->end_time);
});

$featuredOffers = array_slice($featuredOffers, 0, 3);
$offerCount = count($featuredOffers);

function renderOffer($offer, $type, $view) {
  return $view->render(
    "@app/components/home/_featured_offer_type{$type}",
    ['offer' => $offer]
  );
}
?>

<div class="feature-product-area pt-100px pb-100px">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title text-center">
          <h2 class="title">Featured Offers</h2>
          <p>Check out our latest featured products and categories</p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php if ($offerCount === 1): ?>
        <div class="col-12">
          <?= renderOffer($featuredOffers[0], 1, $view) ?>
        </div>
      <?php elseif ($offerCount === 2): ?>
        <div class="col-xl-6 col-lg-6 mb-md-35px mb-lm-35px">
          <?= renderOffer($featuredOffers[0], 1, $view) ?>
        </div>
        <div class="col-xl-6 col-lg-6">
          <?= renderOffer($featuredOffers[1], 2, $view) ?>
        </div>
      <?php elseif ($offerCount === 3): ?>
        <div class="col-xl-6 col-lg-6 mb-md-35px mb-lm-35px">
          <?= renderOffer($featuredOffers[0], 1, $view) ?>
        </div>
        <div class="col-xl-6 col-lg-6">
          <?= renderOffer($featuredOffers[1], 2, $view) ?>
          <div class="mt-30px">
            <?= renderOffer($featuredOffers[2], 2, $view) ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


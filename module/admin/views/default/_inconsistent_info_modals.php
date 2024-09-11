<?php

use app\models\FeaturedOffer;
?>

<div tabindex="-1" class="modal fade" id="<?= FeaturedOffer::INCONSISTY_DUPLICATE_OFFER_FOR_A_PRODUCT ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= Yii::t("app", "Duplicate offered Product") ?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          <?= Yii::t("app", "This warning indicates that there are products in the database that are associated with more than one featured offer. Specifically, a single product is linked to multiple featured offers. In simpler terms a lot of featured offers that u have created are using a same product more than once.") ?>
        </p>
        <p>
          <strong><?= Yii::t("app", "Why This May Happen:") ?></strong>
        <ul>
          <li><strong><?= Yii::t("app", "Manual Overrides:") ?></strong><?= Yii::t("app",  "Administrative actions or manual updates in the database might have bypassed application-level validations.") ?></li>
        </ul>
        </p>
        <p>
          <strong><?= Yii::t("app", "How to Resolve It:") ?></strong>
        <ul>
          <li><strong><?= Yii::t("app", "Identify Duplicates:") ?></strong> <?= Yii::t("app", "Review the list of affected products and featured offers to identify which products have multiple offers.") ?></li>
          <li><strong><?= Yii::t("app", "Correct Data:") ?></strong><?= Yii::t("app",  "Decide which offers should be kept and remove or update the incorrect entries to ensure each product has only one active featured offer.") ?></li>
        </ul>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Yii::t("app", "Close") ?></button>
      </div>
    </div>
  </div>
</div>


<div tabindex="-1" class="modal fade" id="<?= FeaturedOffer::INCONSISTY_INACTIVE_PRODUCT_INCLUDED ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= Yii::t("app", "Inactive Product Included in Featured Offer") ?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          <?= Yii::t("app", "This warning indicates that a featured offer includes one or more products that are currently inactive. In a well-functioning system, inactive products should not be included in featured offers due to the validation logic implemented in the application.") ?>
        </p>
        <p>
          <strong><?= Yii::t("app", "Why This May Happen:") ?></strong>
        <ul>
          <li><strong><?= Yii::t("app", "Data Integrity Issues:") ?></strong><?= Yii::t("app",  "There may have been a lapse in data validation or integrity checks, allowing inactive products to be mistakenly included in featured offers.") ?></li>
          <li><strong><?= Yii::t("app", "Manual Data Manipulation:") ?></strong><?= Yii::t("app",  "If the database was manually updated or if there were direct changes bypassing application logic, inactive products might have been added to the offers.") ?></li>
        </ul>
        </p>
        <p>
          <strong><?= Yii::t("app", "How to Resolve It:") ?></strong>
        <ul>
          <li><strong><?= Yii::t("app", "Review Affected Data:") ?></strong><?= Yii::t("app",  "Identify which featured offers contain inactive products and assess the extent of the issue.") ?></li>
          <li><strong><?= Yii::t("app", "Update Records:") ?></strong><?= Yii::t("app",  "Correct the data by either activating the affected products if applicable or removing them from the featured offers to ensure only active products are included.") ?></li>
        </ul>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Yii::t("app", "Close") ?></button>
      </div>
    </div>
  </div>
</div>

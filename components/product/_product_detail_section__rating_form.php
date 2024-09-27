<?php

use app\models\Rating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Rating $review_model */
?>
<script>
  setTimeout(function() {
    window.initRatingField();
  }, 500)
</script>
<div class="rating-form p-3 description-review-bottom">
  <?php $form = ActiveForm::begin(['id' => 'rating-form']); ?>

  <div class="star-box">
    <span><?= Yii::t('app', 'Your rating') ?>:</span>
    <div class="rating-product">
      <?php
      $currentRating = $review_model->score; // Get the current rating value
      for ($i = 1; $i <= 5; $i++):
        $checkedClass = $i <= $currentRating ? 'active' : ''; // Add 'checked' class if star is less than or equal to current rating
      ?>
        <i class="fa fa-star rating-star <?= $checkedClass ?>" data-rating="<?= $i ?>"></i>
      <?php endfor; ?>
    </div>
    <?= $form->field($review_model, 'score')->hiddenInput(['id' => 'rating-score'])->label(false) ?>
  </div>

  <div class="row ratting-form-wrapper">
    <div class="col-md-12">
      <div class="rating-form-style form-submit">
        <?= $form->field($review_model, 'comment')->textarea(['placeholder' => Yii::t("app",  'Message')])->label(false) ?>
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-hover-color-primary']) ?>
      </div>
    </div>
  </div>

  <?php ActiveForm::end(); ?>
</div>

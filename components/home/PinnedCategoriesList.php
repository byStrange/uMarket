<?php

use app\models\Category;
use yii\web\View;

/** @var Category[] $categories */
/** @var View $view */
?>

<div class="banner-area style-one pt-100px pb-100px">
  <div class="container">
    <?php if (count(Category::find()->select(['id'])->all()) > 3): ?>
      <div class="mb-2 d-flex justify-content-end">
        <a href="/shop/categories">
          <?= Yii::t('app', 'Browse all categories') ?>
          <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </a>
      </div>
    <?php endif ?>
    <div class="row">
      <?php if (count($categories) == 3): ?>
        <div class="col-md-6">
          <?= $view->render('@app/components/home/_category_card_type1', ["category" => $categories[0]]) ?>
        </div>
        <div class="col-md-6">
          <?= $view->render('@app/components/home/_category_card_type2', ["category" => $categories[1]]) ?>
          <?= $view->render('@app/components/home/_category_card_type2', ["category" => $categories[2]]) ?>
        </div>
      <?php elseif (count($categories) == 2): ?>
        <div class="col-md-6">
          <?= $view->render('@app/components/home/_category_card_type2', ["category" => $categories[0]]) ?>
        </div>

        <div class="col-md-6">
          <?= $view->render('@app/components/home/_category_card_type2', ["category" => $categories[1]]) ?>
        </div>
      <?php elseif (count($categories) == 1): ?>

        <div class="col-md-12 d-flex justify-content-center">
          <?= $view->render('@app/components/home/_category_card_type1', ["category" => $categories[0]]) ?>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

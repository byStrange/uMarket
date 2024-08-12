<?php

use app\models\Category;
use yii\web\View;


/** @var View $this */
/** @var Category $categories */

$this->title = Yii::t('app', 'Categories');
$this->params["breadcrumbs"][] = $this->title;
?>


<div class="banner-area style-one pt-100px pb-100px">

  <div class="container">

    <div class="row">
      <?php foreach ($categories as $category): ?>
        <div class="col-md-6">
          <?= $this->render('@app/components/home/_category_card_type2', ["category" => $category]) ?>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

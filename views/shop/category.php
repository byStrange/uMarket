<?php

use app\models\Category;
use yii\web\View;


/** @var View $this */
/** @var Product[] $products */
/** @var View $view */
/** @var Pagination $pagination */
/** @var number $totalCount */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Category $category */

$sort = $dataProvider->getSort();

$this->title = $category;
$this->params["breadcrumbs"][] = $this->title;

?>


<div class="shop-category-area pt-100px pb-100px">
  <?= $this->render('@app/components/product/_products_list', ["view" => &$this, "totalCount" => $totalCount, "pagination" => $pagination, "products" => $products, "sort" => $sort]) ?>
</div>

<?php if ($category->categories): ?>
  <div class="banner-area style-one pt-100px pb-100px">

    <div class="container">

      <div class="row">
        <?php foreach ($category->categories as $category): ?>
          <div class="col-md-6">
            <?= $this->render('@app/components/home/_category_card_type2', ["category" => $category]) ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
<?php endif ?>

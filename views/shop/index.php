<?php
use yii\web\View;


/** @var View $this */
/** @var Product[] $products */
/** @var View $view */
/** @var Pagination $pagination */
/** @var number $totalCount */
/** @var yii\data\ActiveDataProvider $dataProvider */

$sort = $dataProvider->getSort();

$this->title = "Shop All Products";
$this->params["breadcrumbs"][] = $this->title;

?>


<div class="shop-category-area pt-100px pb-100px">
  <?= $this->render('@app/components/product/_products_list', ["view" => &$this, "totalCount" => $totalCount, "pagination" => $pagination, "products" => $products, "sort" => $sort]) ?>
</div>

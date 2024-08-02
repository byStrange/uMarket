<?php

use app\models\Product;

/** @var Product $product **/
/** @var yii\web\View $this */

$this->title = "Product detail";
$this->params["breadcrumbs"][] = $this->title;

?>

<div class="pt-100px pb-100px">
  <?= $this->render('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => true]) ?> 
</div>

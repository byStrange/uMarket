<?php

use app\widgets\CollapsibleTranslations;
use yii\bootstrap5\Button;
use yii\bootstrap5\Offcanvas;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var app\models\ProductTranslation $translationModel */

$this->title = "Update Product: " . $model->id;
$this->params["breadcrumbs"][] = ["label" => "Products", "url" => ["index"]];
$this->params["breadcrumbs"][] = [
    "label" => $model->id,
    "url" => ["view", "id" => $model->id],
];
$this->params["breadcrumbs"][] = "Update";
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

    <?php echo Button::widget([
        "label" => "Add translations",
        "options" => [
            "class" => "btn btn-primary",
            "type" => "button",
            "data-bs-toggle" => "offcanvas",
            "data-bs-target" => "#form-offcanvas", // Use the same ID from Offcanvas
        ],
    ]); ?>

    <?php
    Offcanvas::begin([
        "placement" => Offcanvas::PLACEMENT_START,
        "backdrop" => true,
        "scrolling" => true,
        "id" => "form-offcanvas",
    ]);

    echo CollapsibleTranslations::widget([
        "translations" => $model->translations,
        "titleFieldName" => "title",
        "descriptionFieldName" => "description",
        "controllerId" => "product-translation",
    ]);

    echo "<h3 class=" . "pt-4" . ">Add translation</h3>";

    echo $this->render("../product-translation/_form", [
        "model" => $translationModel,
        "product_id" => $model->id,
    ]);

    Offcanvas::end();
    ?>

</div>

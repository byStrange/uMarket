<?php

use app\models\ProductTranslation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ProductTranslationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Product Translations";
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="product-translation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            "Create Product Translation",
            ["create"],
            ["class" => "btn btn-success"]
        ) ?>
    </p>

    <?php
// echo $this->render('_search', ['model' => $searchModel]);
?>

    <?= GridView::widget([
        "dataProvider" => $dataProvider,
        "filterModel" => $searchModel,
        "columns" => [
            ["class" => "yii\grid\SerialColumn"],

            "id",
            "created_at",
            "updated_at",
            "language_code",
            "title",
            //'product_id',
            [
                "class" => ActionColumn::className(),
                "urlCreator" => function (
                    $action,
                    ProductTranslation $model,
                    $key,
                    $index,
                    $column
                ) {
                    return Url::toRoute([$action, "id" => $model->id]);
                },
            ],
        ],
    ]) ?>


</div>

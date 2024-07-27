<?php

use app\models\LocationPoint;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\LocationPointSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Location Points";
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="location-point-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            "Create Location Point",
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
            "lon",
            "lat",
            //'address_label',
            [
                "class" => ActionColumn::className(),
                "urlCreator" => function (
                    $action,
                    LocationPoint $model,
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

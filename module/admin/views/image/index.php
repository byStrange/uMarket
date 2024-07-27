<?php

use app\models\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ImageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Images";
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            "Create Image",
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
            "image",
            "alt",
            [
                "class" => ActionColumn::className(),
                "urlCreator" => function (
                    $action,
                    Image $model,
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

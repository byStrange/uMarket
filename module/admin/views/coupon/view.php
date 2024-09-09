<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Coupon $model */

$this->title = Yii::t('app', 'Coupon: {id}', ['id' => $model->id]);
$this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', 'Coupons'),
    "url" => ["index"]
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="coupon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            Yii::t('app', 'Update'),
            ["update", "id" => $model->id],
            ["class" => "btn btn-primary"]
        ) ?>
        <?= Html::a(
            Yii::t('app', 'Delete'),
            ["delete", "id" => $model->id],
            [
                "class" => "btn btn-danger",
                "data" => [
                    "confirm" => Yii::t('app', 'Are you sure you want to delete this item?'),
                    "method" => "post",
                ],
            ]
        ) ?>
    </p>

    <?= DetailView::widget([
        "model" => $model,
        "attributes" => [
            "id",
            "created_at",
            "updated_at",
            "code",
            "discount_percentage",
            "discount_price",
            "start_date",
            "end_date",
            "is_active:boolean",
        ],
    ]) ?>

</div>

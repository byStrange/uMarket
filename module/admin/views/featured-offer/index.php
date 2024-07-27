<?php

use app\models\FeaturedOffer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\FeaturedOfferSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Featured Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="featured-offer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Featured Offer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'dicount_price',
            'start_time',
            //'end_time',
            //'product_id',
            //'category_id',
            //'image_banner_id',
            //'image_portrait_id',
            //'image_small_landscape_id',
            //'type',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, FeaturedOffer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

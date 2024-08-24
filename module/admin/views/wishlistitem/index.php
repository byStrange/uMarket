<?php

use app\models\Wishlistitem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\WishlistitemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Wishlist Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlistitem-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('app', 'Create Wishlist Item'), ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?php // echo $this->render('_search', ['model' => $searchModel]); 
  ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      [
        'attribute' => 'id',
        'label' => Yii::t('app', 'ID'),
      ],
      [
        'attribute' => 'cart_id',
        'label' => Yii::t('app', 'Cart ID'),
      ],
      [
        'attribute' => 'product_id',
        'label' => Yii::t('app', 'Product ID'),
      ],
      [
        'class' => ActionColumn::className(),
        "template" => "{view}",
        'urlCreator' => function ($action, Wishlistitem $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'header' => Yii::t('app', 'Actions'),
      ],
    ],
  ]); ?>

</div>

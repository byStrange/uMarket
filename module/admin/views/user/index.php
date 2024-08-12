<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t("app",  "Users");
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="user-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create User"),
      ["create"],
      ["class" => "btn btn-success"]
    ) ?>
  </p>

  <?php
  // echo $this->render('_search', ['model' => $searchModel]);
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
        'attribute' => 'is_superuser',
        'format' => 'boolean',
        'label' => Yii::t('app', 'Is Superuser'),
      ],
      [
        'attribute' => 'username',
        'label' => Yii::t('app', 'Username'),
      ],
      // Uncomment and translate the following fields as needed
      /*
        [
            'attribute' => 'first_name',
            'label' => Yii::t('app', 'First Name'),
        ],
        [
            'attribute' => 'last_name',
            'label' => Yii::t('app', 'Last Name'),
        ],
        [
            'attribute' => 'email',
            'format' => 'email',
            'label' => Yii::t('app', 'Email'),
        ],
        [
            'attribute' => 'is_active',
            'format' => 'boolean',
            'label' => Yii::t('app', 'Is Active'),
        ],
        [
            'attribute' => 'created_at',
            'label' => Yii::t('app', 'Created At'),
        ],
        [
            'attribute' => 'updated_at',
            'label' => Yii::t('app', 'Updated At'),
        ],
        */

      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, User $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        },
        'header' => Yii::t('app', 'Actions'),
      ],
    ],
  ]) ?>


</div>

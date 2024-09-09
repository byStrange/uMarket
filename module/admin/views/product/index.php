<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', "Products");
$this->params["breadcrumbs"][] = $this->title;
?>
<style>
  .published-row>* {
    background-color: lightgreen !important;
  }

  .has-no-translations:not(.published-row)>* {
    background-color: #FFD580 !important;
  }

  .published-row.has-no-translations>* {
    background-color: orangered !important;
  }

  .published-row.has-no-translations .not-set {
    color: white;
  }

  .color-box {
    width: 40px;
    height: 20px;
  }

  .color-box div {
    width: 100%;
    height: 100%;
  }
</style>
<div class="product-index">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Create Product"),
      ["create"],
      ["class" => "btn btn-success"]
    ) ?>
    <?= Html::a(
      Yii::t('app', "How product prices work?"),
      ["#"],
      ["style" => 'margin-left: 12px', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#pricingModal']
    ) ?>
  </p>

  <div class="d-flex flex-column gap-3">
    <div class="d-flex d-flex gap-3">
      <div class="color-box published-row">
        <div></div>
      </div>
      <p><?= Yii::t("app", "Published product") ?></p>
    </div>
    <div class="d-flex gap-3">
      <div class="color-box has-no-translations">
        <div></div>
      </div>
      <p><?= Yii::t("app", "Does not have any translation") ?></p>
    </div>
    <div class="d-flex gap-3">
      <div class="color-box published-row has-no-translations">
        <div></div>
      </div>
      <p><?= Yii::t("app", "Published product that has no translations") ?></p>
    </div>
  </div>

  <?php
  // echo $this->render('_search', ['model' => $searchModel]);
  ?>


  <?= GridView::widget([
    "dataProvider" => $dataProvider,
    "filterModel" => $searchModel,
    "rowOptions" => function ($model, $index, $widget, $grid) {
      $classList = '';
      if ($model->status == Product::STATUS_PUBLISHED) {
        $classList .= strlen($classList) ? " " : "";
        $classList .= 'published-row';
      }
      if (!count($model->translations)) {
        $classList .= strlen($classList) ? " " : "";
        $classList .= 'has-no-translations';
      }

      return ['class' => $classList];
    },
    "columns" => [

      ["class" => "yii\grid\SerialColumn"],

      [
        'attribute' => 'id',
        'label' => Yii::t('app', 'ID'),
        'filter' => false
      ],
      [
        'attribute' => 'created_at',
        'label' => Yii::t('app', 'Created At'),
        'filter' => false
      ],
      [
        'value' => function ($model) {
          return $model->priceAsCurrency();
        },
        'label' => Yii::t('app', 'Clean price'),

        'filter' => false
      ],
      [
        'attribute' => 'updated_at',
        'label' => Yii::t('app', 'Updated At'),


        'filter' => false
      ],
      [
        'attribute' => 'price',
        'label' => Yii::t('app', 'Price'),
        'value' => function ($model) {
          return Yii::$app->formatter->asCurrency($model->price);
        },
        'filter' => false
      ],
      [
        'attribute' => 'discount_price',
        'label' => Yii::t('app', 'Discount Price'),

        'filter' => false
      ],
      // Uncomment and translate these columns if needed
      [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
        'value' => function ($model) {
          $statusOptions = Product::getStatusOptions();
          $option = $statusOptions[$model->status] ?? Yii::t('app', 'Unknown');

          return $option;
        },

        'filter' => false
      ],
      [
        "attribute" => 'is_deleted',
        "format" => 'boolean',
        'label' => Yii::t('app', 'Is Deleted'),

        'filter' => false
      ],
      [
        'attribute' => 'views',
        'label' => Yii::t('app', 'Views'),

        'filter' => false
      ],
      [
        'attribute' => 'created_by_id',
        'label' => Yii::t('app', 'Created By'),
        'value' => "createdBy.username",

        'filter' => false
      ],

      [
        "class" => ActionColumn::className(),
        'template' => '{publish} {disable} {view} {update} {delete}',
        "urlCreator" => function (
          $action,
          Product $model,
          $key,
          $index,
          $column
        ) {
          return Url::toRoute([$action, "id" => $model->id]);
        },
        'header' => Yii::t('app', 'Actions'),
        'buttons' => [
          'publish' => function ($url, $model, $key) {
            return Html::a(
              '<i class="fa fa-upload" aria-hidden="true"></i>',
              ['product/mark-as-published', 'id' => $model->id],
              [
                'title' => Yii::t('app', 'Mark as Published'),
                'data-pjax' => '0',
              ]
            );
          },
          'disable' => function ($url, $model, $key) {
            return Html::a(
              '<i class="fa fa-ban" aria-hidden="true"></i>',
              ['product/mark-as-disabled', 'id' => $model->id],
              [
                'title' => Yii::t('app', 'Mark as Disabled'),
                'data-pjax' => '0',
              ]
            );
          },
        ]
      ],

    ],
  ]) ?>

</div>

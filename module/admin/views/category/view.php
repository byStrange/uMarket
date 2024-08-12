<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', 'Categories'),
  "url" => ["index"]
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

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
      [
        'attribute' => 'label',
        'label' => Yii::t('app', 'Label'),
      ],
      "updated_at",
      [
        'attribute' => 'parent_id',
        'label' => Yii::t('app', 'Parent ID'),
      ],
      /*[
                "label" => Yii::t('app', 'Name'),
                "value" => $model->getCategoryTranslationForLanguage(Yii::$app->language),
            ],*/
    ],
  ]) ?>

</div>

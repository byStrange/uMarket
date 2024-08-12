<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

class TranslatedNameColumn extends \yii\grid\DataColumn
{
  public function init()
  {
    $this->label = Yii::t('app', 'Name'); // Set the column label
    parent::init();
  }

  public function renderDataCellContent($model, $key, $index)
  {
    $translation = $model->getCategoryTranslationForLanguage(
      Yii::$app->language
    );
    return isset($translation) ? $translation->name : "";
  }
}

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="category-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', 'Create Category'),
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
      [
        "class" => TranslatedNameColumn::class,
      ],
      "id",
      [
        'attribute' => 'label',
        'label' => Yii::t('app', 'Label'),
      ],
      [
        'attribute' => 'is_pinned',
        'label' => Yii::t('app', 'Is Pinned'),
        'format' => 'boolean',
      ],
      [
        'attribute' => 'created_at',
        'label' => Yii::t('app', 'Created At'),
      ],
      [
        'attribute' => 'updated_at',
        'label' => Yii::t('app', 'Updated At'),
      ],
      [
        'attribute' => 'parent_id',
        'label' => Yii::t('app', 'Parent ID'),
      ],
      [
        "class" => ActionColumn::class,
        "urlCreator" => function ($action, Category $model) {
          /*$key,*/
          /*$index,*/
          /*$column*/
          return Url::toRoute([$action, "id" => $model->id]);
        },
      ],
    ],
  ]) ?>

</div>

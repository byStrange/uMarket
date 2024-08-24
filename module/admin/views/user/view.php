<?php

use yii\helpers\Html;
use yii\jui\Accordion;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t("app", "Users"), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t('app', "Update"),
      ["update", "id" => $model->id],
      ["class" => "btn btn-primary"]
    ) ?>
    <?= Html::a(
      Yii::t('app', "Delete"),
      ["delete", "id" => $model->id],
      [
        "class" => "btn btn-danger",
        "data" => [
          "confirm" => Yii::t("app", "Are you sure you want to delete this item?"),
          "method" => "post",
        ],
      ]
    ) ?>
  </p>

  <?= DetailView::widget([
    "model" => $model,
    "attributes" => [
      "id",
      "is_superuser:boolean",
      "username",
      "first_name",
      "last_name",
      "email:email",
      "is_active:boolean",
      [
        "attribute" => "image_small_landscape",
        "label" => Yii::t('app', 'Small Landscape Image'),
        'value' => function ($model) {
          if (!$model->profile_picture) {
            return '<span class="not-set">(not set)</span>';
          }
          return Accordion::widget([
            'items' => [
              [
                'header' => 'Click to view',
                'label' => Yii::t('app', 'Small Landscape Image'),
                'content' => Html::img('/' . $model->profile_picture, ['style' => 'max-height: 400px; max-width: 100%;'])
              ],
            ],
            'clientOptions' => [
              'collapsible' => true,
              'active' => true,
            ],
          ]);
        },
        'format' => 'raw'
      ],
      "created_at",
      "updated_at",
    ],
  ]) ?>

</div>

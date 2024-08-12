<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\UserAddress $model */

$this->title = $model->id;
$this->params["breadcrumbs"][] = [
  "label" => Yii::t('app', "User Addresses"),
  "url" => ["index"],
];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-address-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(
      Yii::t("app", "Update"),
      ["update", "id" => $model->id],
      ["class" => "btn btn-primary"]
    ) ?>
    <?= Html::a(
      Yii::t('app', "Delete"),
      ["delete", "id" => $model->id],
      [
        "class" => "btn btn-danger",
        "data" => [
          "confirm" => Yii::t('app', "Are you sure you want to delete this item?"),
          "method" => "post",
        ],
      ]
    ) ?>
  </p>


  <?= DetailView::widget([
    "model" => $model,
    "attributes" => [
      [
        'attribute' => 'id',
        'label' => Yii::t('app', 'ID'),
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
        'attribute' => 'label',
        'label' => Yii::t('app', 'Label'),
      ],
      [
        'attribute' => 'city',
        'label' => Yii::t('app', 'City'),
      ],
      [
        'attribute' => 'user_first_name',
        'label' => Yii::t('app', 'User First Name'),
      ],
      [
        'attribute' => 'user_last_name',
        'label' => Yii::t('app', 'User Last Name'),
      ],
      [
        'attribute' => 'user_phone_number',
        'label' => Yii::t('app', 'User Phone Number'),
      ],
      [
        'attribute' => 'apartment',
        'label' => Yii::t('app', 'Apartment'),
      ],
      [
        'attribute' => 'street_address',
        'label' => Yii::t('app', 'Street Address'),
      ],
      [
        'attribute' => 'zip_code',
        'label' => Yii::t('app', 'Zip Code'),
      ],
      [
        'attribute' => 'user_id',
        'label' => Yii::t('app', 'User ID'),
      ],
    ],
  ]) ?>

</div>

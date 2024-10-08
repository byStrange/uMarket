<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserAddress $model */

$this->title = Yii::t('app', "Create User Address");
if (!$popup) {
  $this->params["breadcrumbs"][] = [
    "label" => Yii::t('app', "User Addresses"),
    "url" => ["index"],
  ];
  $this->params["breadcrumbs"][] = $this->title;
}
?>
<div class="user-address-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render("_form", [
    "model" => $model,
    "d" => isset($d) ? $d : false
  ]) ?>

</div>

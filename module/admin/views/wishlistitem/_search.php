<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\WishlistitemSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="wishlistitem-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'id')->label(Yii::t('app', 'ID')) ?>

  <?= $form->field($model, 'cart_id')->label(Yii::t('app', 'Cart ID')) ?>

  <?= $form->field($model, 'product_id')->label(Yii::t('app', 'Product ID')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

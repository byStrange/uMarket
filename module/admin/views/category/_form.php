<?php

use app\components\Utils;
use app\models\Category;
use yii\bootstrap5\Alert;

use app\widgets\RadioItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */

$pinned_categories = Category::find()
  ->where(['is_pinned' => true, 'parent_id' => null])
  ->orderBy(['id' => SORT_DESC])
  ->all()
?>

<style>
  #category-type {
    margin-top: 8px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
  }
</style>
<div class="category-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= Utils::popupField($form, $model, "category", function ($form, $model) {
    return $form
      ->field($model, "parent_id")
      ->dropDownList(Category::toOptionsList(), [
        "prompt" => Yii::t('app', '--- Select a Category ---'),
      ]);
  }) ?>

  <?= $form->field($model, "label")->textInput(['label' => Yii::t('app', 'Label')]) ?>

  <?= $form->field($model, 'is_pinned')->checkbox(['label' => Yii::t('app', 'Is Pinned')]) ?>

  <?php if (count($pinned_categories) >= 3): ?>
    <?php Alert::begin([
      'options' => ['class' => 'alert-warning'],
    ]) ?>
    <p>
      <?= Yii::t('app', 'You are about to pin a new category, but you already have three pinned categories. Adding this new category will push the last pinned category out of the list.') ?>
    </p>
    <hr />
    <p class="mb-0">
      <?= Yii::t('app', 'If you proceed, the new category will be added to the first position, and the last one will be automatically removed.') ?>
    </p>
    <?php Alert::end() ?>
  <?php endif ?>


  <?= $form
    ->field($model, "type")
    ->radioList(array_column(Category::getTypeOptions(), 'label', 'value'), [
      "value" => $model->type,
      "item" => function ($index, $label, $name, $checked, $value) {
        $description = Category::getTypeOptions()[$value]["description"];
        return RadioItem::widget([
          "checked" => $checked,
          "name" => $name,
          "value" => $value,
          "id" => $index . $label,
          "label" => $label,
          "description" => $description,
        ]);
      },
    ]) ?>


  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

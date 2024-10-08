<?php

use app\components\Utils;
use app\models\Category;
use app\models\Image;
use yii\helpers\Html;
use yii\jui\Accordion;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategoryTranslation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-translation-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "language_code")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, "name")->textInput(["maxlength" => true]) ?>

  <?php if (isset($category_id)): ?>
    <?= $form
      ->field($model, "category_id")
      ->hiddenInput(["value" => $category_id])
      ->label(Yii::t('app', "Category Id: $category_id")) ?>

  <?php else: ?>
    <?= Utils::popupField($form, $model, "category_id", function (
      $form,
      $model
    ) {
      return $form
        ->field($model, "category_id")
        ->dropDownList(Category::toOptionsList())
        ->label(Yii::t('app', 'Category'));
    }) ?>
  <?php endif; ?>
  <?= $form->field($model, "image")->fileInput()->label($model->image ? Yii::t('app', 'Change Image') : Yii::t('app', 'Upload Image')) ?>

  <?php if ($model->image): ?>
    <?php echo Accordion::widget([
      'items' => [
        [
          'header' => Yii::t('app', 'Show current image preview'),
          'content' => Html::img("/" . $model->image, ["width" => 400]),
        ],
      ],
      'clientOptions' => ['collapsible' => true, 'active' => false],
      'options' => ['class' => 'mb-3']
    ]); ?>
  <?php endif ?>



  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

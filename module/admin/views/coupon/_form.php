<?php

use app\widgets\RadioItem;
use Yii2\Extensions\DateTimePicker\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Coupon $model */
/** @var yii\widgets\ActiveForm $form */

$script = <<<JS
$(function () {
  var discountPercentageField = $('.field-coupon-discount_percentage')
  var discountPriceField = $('.field-coupon-discount_price')
  var type = $('[name="Coupon[type]"]');

  type.each(function () {
   if ($(this).attr('checked')) toggleDiscountVal($(this).val(), 0) 
  })
  type.on('change', function () {
      toggleDiscountVal($(this).val()) 
  })

  function toggleDiscountVal(value, speed) {
    if (value === 'raw') {
      discountPercentageField.find('input').val('')
      discountPercentageField.slideUp(speed);
      discountPriceField.slideDown(speed)
    }  else if (value === 'percentage') {
      discountPriceField.find('input').val('')
      discountPercentageField.slideDown(speed);
      discountPriceField.slideUp(speed);
    }
  }
});
JS;

$this->registerJs($script)
?>

<style>
  #coupon-type {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
  }
</style>

<div class="coupon-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "code")->textInput(["maxlength" => true]) ?>

  <?= $form->field($model, 'type')->radioList([
    'percentage' => Yii::t('app', 'Percentage'),
    'raw' => Yii::t('app', 'Discount price')
  ], [
    "value" => $model->discount_percentage ? 'percentage' : 'raw',
    "item" => function ($index, $label, $name, $checked, $value) {
      return RadioItem::widget([
        "name" => $name,
        "value" => $value,
        "id" => $index . $label,
        "label" => $label,
        "checked" => $checked
      ]);
    }
  ]) ?>

  <?= $form->field($model, "discount_percentage")->textInput()->label(Yii::t('app',  "discount_percentage")) ?>

  <?= $form->field($model, "discount_price")->textInput()->label(Yii::t('app',  "Discount Price")) ?>

  <?= $form->field($model, "label")->textInput()->label(Yii::t('app',  "Label")) ?>

  <?= $form->field($model, 'start_date')->widget(
    DateTimePicker::class,
    [
      "id" => "start_time",
      "config" => [
        "display" => [
          "theme" => 'light',
          "value" => Yii::$app->formatter->asDatetime($model->start_date,)
        ],
      ],
      'icon' => '<i class="fa fa-calendar"></i>'
    ]
  )
    ->label(Yii::t('app', 'Start time')) ?>

  <?= $form->field($model, 'end_date')->widget(
    DateTimePicker::class,
    [
      "id" => "end_time",
      "config" => [
        "display" => [
          "theme" => 'light',
          "value" => Yii::$app->formatter->asDatetime($model->end_date)
        ],
      ],

      'icon' => '<i class="fa fa-calendar"></i>'
    ]
  )
    ->label(Yii::t('app', 'End Time')) ?>


  <?= $form->field($model, "is_active")->checkbox()->label(Yii::t('app',  "Is Active")) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

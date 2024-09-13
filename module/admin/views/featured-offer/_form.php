<?php

use app\components\Utils;
use app\models\Category;
use app\models\FeaturedOffer;
use app\models\Product;
use app\widgets\CheckBoxItem;
use app\widgets\RadioItem;
use yii\helpers\Html;
use yii\web\View as WebView;
use Yii2\Extensions\DateTimePicker\DateTimePicker;
use yii\widgets\ActiveForm;


$script = <<<JS
$(function () {
  var discountPercentageField = $('.field-featuredoffer-discount_percentage')
  var discountPriceField = $('.field-featuredoffer-dicount_price')
  var type = $('[name="FeaturedOffer[price_type]"]');

  type.each(function () {
   if ($(this).attr('checked')) toggleDiscountVal($(this).val(), 0) 
  })

  type.on('change', function () {
      toggleDiscountVal($(this).val()) 
  })

  function toggleDiscountVal(value, speed) {
    console.log(value)
    if (value === 'raw') {
      discountPercentageField.slideUp(speed);
      discountPriceField.slideDown(speed)
    }  else if (value === 'percentage') {
      discountPercentageField.slideDown(speed);
      discountPriceField.slideUp(speed);
    }
  }
});
JS;

$this->registerJs($script)


/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
  #featuredoffer-type,
  #featuredoffer-price_type {
    margin-top: 8px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
  }

  #featuredoffer-products {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 24px;
  }
</style>
<div class="featured-offer-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, "title")->textInput()->label(Yii::t('app', 'Title')) ?>

  <?= $form
    ->field($model, "type")
    ->radioList(
      array_column(FeaturedOffer::getTypeOptions(), "label", "value"),
      [
        "value" => $model->type,
        "item" => function ($index, $label, $name, $checked, $value) {
          $description = FeaturedOffer::getTypeOptions()[$value]["description"];
          return RadioItem::widget([
            "name" => $name,
            "value" => $value,
            "id" => $index . $label,
            "label" => $label,
            "description" => $description,
            "checked" => $checked
          ]);
        },
        "itemOptions" => [
          "class" => "form-check-input",
        ],
      ]
    )->label(Yii::t('app', 'Type')) ?>
  <?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
      ->field($model, "category_id")
      ->dropDownList(Category::toOptionsList(), ['prompt' => Yii::t('app', '--- Select a Category ---'),])
      ->label(Yii::t('app', 'Category'));
  }) ?>

  <div id="selectProductWrapper">

    <?php $productOptionList = Product::toOptionsList(true); ?>

    <?= $form->field($model, 'products[]')->checkboxList(
      array_map(
        function ($item) {
          return $item['label']; // Use the label as the value for radio buttons
        },
        $productOptionList
      ),
      [
        'item' => function ($index, $label, $name, $checked, $value) use ($productOptionList) {
          $options = $productOptionList;
          $description = isset($options[$value]['description']) ? $options[$value]['description'] : '';
          return CheckBoxItem::widget([
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'id' => $index . $label,
            'label' => $label,
            'checked' => $checked,
          ]);
        },
        "value" => array_map(function ($product) {
          return  $product['id'];
        }, $model->products)
      ]
    )->label(Yii::t('app', 'Select a product')) ?>

  </div>

  <?= $form->field($model, 'price_type')->radioList([
    'percentage' => Yii::t('app', 'Percentage'),
    'raw' => Yii::t('app', 'Discount price')
  ], [
    "value" => $model->dicount_price ? 'raw' : 'percentage',
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

  <?= $form->field($model, 'discount_percentage', [
    'template' => "{label}\n<div class='input-group'>{input}<span class='input-group-text'>%</span></div>\n{hint}\n{error}"
  ])->textInput()->label(Yii::t('app', 'Discount Percentage')) ?>

  <?= $form->field($model, "dicount_price", [
    'template' => "{label}\n<div class='input-group'>{input}<span class='input-group-text'>$</span></div>\n{hint}\n{error}"
  ])->textInput()->label(Yii::t('app', 'Discount Price'))->hint(Yii::t('app', 'Given price will be the price, it wont get discounted')) ?>




  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="specifyTime">
    <label class="form-check-label" for="specifyTime"><?= Yii::t('app', 'Specify Time') ?></label>
  </div>

  <div style="display: none; max-width: 400px;" id="timeField">
    <?= $form->field($model, 'start_time')->widget(
      DateTimePicker::class,
      [
        "id" => "start_time",
        "config" => [
          "display" => [
            "theme" => 'dark',
            "buttons" => ['today' => true]
          ]
        ],
        'icon' => '<i class="fa fa-calendar"></i>'
      ]
    )->label(Yii::t('app', 'Start time')) ?>

    <?= $form->field($model, 'end_time')->widget(
      DateTimePicker::class,
      [
        "id" => "end_time",
        "config" => [
          "display" => [
            "theme" => 'dark',
            "buttons" => ['today'],
            "todayBtn" => true
          ]
        ],
        'icon' => '<i class="fa fa-calendar"></i>'
      ]
    )->label(Yii::t('app', 'End Time')) ?>

  </div>

  <div class="container mt-5">
    <h2 class="mb-4"><?= Yii::t('app', 'Image Upload') ?></h2>
    <div class="row">
      <!-- Banner Image -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-header">
            <?= Yii::t('app', 'Banner Image (406x404)') ?>
          </div>
          <div class="card-body">
            <div class="image-preview mb-3" id="banner-preview">
              <img src="/<?= $model->image_banner ?>" alt="<?= Yii::t('app', 'Banner') ?>" class="img-fluid">
            </div>
            <div class="input-group">
              <input type="file" class="form-control" name="FeaturedOffer[image_banner_file]" id="image_banner_file">
              <label class="input-group-text" for="image_banner_file"><?= Yii::t('app', 'Upload') ?></label>
            </div>
          </div>
        </div>
      </div>

      <!-- Portrait Image -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-header">
            <?= Yii::t('app', 'Portrait Image (570x790)') ?>
          </div>
          <div class="card-body">
            <div class="image-preview mb-3" id="portrait-preview">
              <img src="/<?= $model->image_portrait ?>" alt="<?= Yii::t('app', 'Portrait') ?>" class="img-fluid">
            </div>
            <?= $form->field($model, 'image_portrait_file', [
              "template" => "{input}\n{hint}\n{error}\n<label class='input-group-text' for='image_portrait_file'>" . Yii::t('app', 'Upload') . "</label>",
              "options" => ["class" => 'input-group']
            ])->fileInput(["class" => 'form-control']) ?>
          </div>
        </div>
      </div>

      <!-- Small Landscape Image -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-header">
            <?= Yii::t('app', 'Small Landscape Image (270x380)') ?>
          </div>
          <div class="card-body">
            <div class="image-preview mb-3" id="small-landscape-preview">
              <img src="/<?= $model->image_small_landscape ?>" alt="<?= Yii::t('app', 'Small Landscape') ?>" class="img-fluid">
            </div>
            <div class="input-group">
              <input type="file" class="form-control" name="FeaturedOffer[image_small_landscape_file]" id="image_small_landscape_file">
              <label class="input-group-text" for="image_small_landscape_file"><?= Yii::t('app', 'Upload') ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

  <?php
  $type = $model->type;
  $start_date = $model->start_time;
  $end_date = $model->end_time;
  $jsCode = <<<javascript
  $(function () {
    function handleFileSelect(input, previewId) {
        $(input).change(function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              $(`#` + previewId + `img`).attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
          }
        });
      }

      handleFileSelect('#image_banner_file', 'banner-preview');
      handleFileSelect('#image_portrait_file', 'portrait-preview');
      handleFileSelect('#image_small_landscape_file', 'small-landscape-preview');
    const specifyTime = $('#specifyTime')
    const productIdField = $("#selectProductWrapper");
    const categoryIdField = $(".field-featuredoffer-category_id").parent().parent();
    const offerTypeRadioInputs = $('[name="FeaturedOffer[type]"]');

    var value = "{$type}";
    value == "category" ? productIdField.hide() : value == 'product' ? categoryIdField.hide() : productIdField.hide() && categoryIdField.hide();

    offerTypeRadioInputs.on("change", function (event) {
      value = event.target.value;
      if (value === "category") {
        productIdField.slideUp();
        categoryIdField.slideDown();
      } else if (value === "product") {
        categoryIdField.slideUp();
        productIdField.slideDown();
      }
    });

    if ("{$start_date}" || "{$end_date}") {
      specifyTime.prop('checked', true);
      $('#timeField').slideDown();
    }

    specifyTime.on('change', function (event)  {
      $('#featuredoffer-start_time').val('');
      $('#featuredoffer-end_time').val('');
      if ($(this).prop('checked')) {
       $('#timeField').slideDown(); 
      } else {
        $('#timeField').slideUp()
      }
    })
  });
javascript;

  $this->registerJs($jsCode, WebView::POS_READY, "uniqueid");
  ?>
</div>

<?php

use app\components\Utils;
use app\models\Category;
use app\models\FeaturedOffer;
use app\models\Product;
use app\widgets\RadioItem;
use yii\helpers\Html;
use yii\web\View as WebView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\FeaturedOffer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
  #featuredoffer-type {
    margin-top: 8px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
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

  <div id="selectProductWrapper">
    <?= Utils::popupField($form, $model, "", function ($form, $model) {
      return $form
        ->field($model, "product_id")
        ->dropDownList(Product::toOptionsList())
        ->label(Yii::t('app', 'Product'));
    }) ?>

    <?= $form->field($model, "dicount_price")->textInput()->label(Yii::t('app', 'Discount Price')) ?>
  </div>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
      ->field($model, "category_id")
      ->dropDownList(Category::toOptionsList())
      ->label(Yii::t('app', 'Category'));
  }) ?>

  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="specifyTime">
    <label class="form-check-label" for="specifyTime"><?= Yii::t('app', 'Specify Time') ?></label>
  </div>

  <div style="display: none" id="timeField">
    <?= $form->field($model, "start_time")->input("datetime-local")->label(Yii::t('app', 'Start Time')) ?>

    <?= $form->field($model, "end_time")->input("datetime-local")->label(Yii::t('app', 'End Time')) ?>
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

    specifyTime.on('change', function (event)  {
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

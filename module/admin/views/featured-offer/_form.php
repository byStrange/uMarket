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

    <?= $form->field($model, "title")->textInput() ?>

    <?= $form
        ->field($model, "type")
        ->radioList(
            array_column(FeaturedOffer::getTypeOptions(), "label", "value"),
            [
                "item" => function ($index, $label, $name, $checked, $value) {
                    $description = FeaturedOffer::getTypeOptions()[$value][
                        "description"
                    ];
                    return RadioItem::widget([
                        "name" => $name,
                        "value" => $value,
                        "id" => $index . $label,
                        "label" => $label,
                        "description" => $description,
                    ]);
                },
            ]
        ) ?>

 <div id="selectProductWrapper"> 
<?= Utils::popupField($form, $model, "", function ($form, $model) {
    return $form
        ->field($model, "product_id")
        ->dropDownList(Product::toOptionsList())
        ->label("Product");
}) ?>

  <?= $form->field($model, "dicount_price")->textInput() ?>
    </div>

  <?= Utils::popupField($form, $model, "", function ($form, $model) {
      return $form
          ->field($model, "category_id")
          ->dropDownList(Category::toOptionsList())
          ->label("Category");
  }) ?>

  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="specifyTime">
    <label class="form-check-label" for="specifyTime">Specify time</label>
  </div>

  <div style="display: none" id="timeField"> 
    <?= $form->field($model, "start_time")->input("datetime-local") ?>

    <?= $form->field($model, "end_time")->input("datetime-local") ?>
  </div>



  <?= $form
      ->field($model, "image_banner")
      ->fileInput()
      ->label("Banner image") ?>

  <?= $form
      ->field($model, "image_portrait")
      ->fileInput()
      ->label("Portrait image") ?>

  <?= $form
      ->field($model, "image_small_landscape")
      ->fileInput()
      ->label("Small landscape image") ?>


  <div class="form-group">
    <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
  </div>

  <?php ActiveForm::end(); ?>

  <?php
  $jsCode = <<<javascript
  $(function () {
    const specifyTime = $('#specifyTime')
    const productIdField = $("#selectProductWrapper");
    const categoryIdField = $(".field-featuredoffer-category_id").parent().parent();
    const offerTypeRadioInputs = $('[name="FeaturedOffer[type]"]');

    var value;
    productIdField.hide();
    categoryIdField.hide();

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

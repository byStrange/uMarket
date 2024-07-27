<?php

use app\models\Category;
use app\models\FeaturedOffer;
use app\models\Image;
use app\models\Product;
use app\widgets\RadioItem;
use yii\base\View;
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

  <?= $form->field($model, 'dicount_price')->textInput() ?>

  <?= $form->field($model, 'start_time')->input('datetime-local') ?>

  <?= $form->field($model, 'end_time')->input('datetime-local') ?>
  <?= $form->field($model, 'type')->radioList(
    array_column(FeaturedOffer::getTypeOptions(), "label", "value"),
    [
      "item" => function ($index, $label, $name, $checked, $value) {
        $description = FeaturedOffer::getTypeOptions()[$value]["description"];
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

  <?= $form->field($model, 'product_id')->dropDownList(Product::findTranslatedTitlesOrIds())->label('Product') ?>

  <?= $form->field($model, 'category_id')->dropDownList(Category::find()->select(['label'])->indexBy('id')->column())->label('Category') ?>

  <?= $form->field($model, 'image_banner_id')->dropDownList(Image::find()->select(['alt'])->indexBy('id')->column())->label('Banner image') ?>

  <?= $form->field($model, 'image_portrait_id')->dropDownList(Image::find()->select(['alt'])->indexBy('id')->column())->label('Portrait image') ?>

  <?= $form->field($model, 'image_small_landscape_id')->dropDownList(Image::find()->select(['alt'])->indexBy('id')->column())->label('Small landscape image') ?>

 

  <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

<?php
$jsCode =  <<<javascript
  $(function () {
    const productIdField = $(".field-featuredoffer-product_id");
    const categoryIdField = $(".field-featuredoffer-category_id");
    const offerTypeRadioInputs = $('[name="FeaturedOffer[type]"]');
    var value;
    productIdField.hide();
    categoryIdField.hide();
    offerTypeRadioInputs.on("change", function (event) {
      console.log(value)
      value = event.target.value;
      if (value === "category") {
        productIdField.slideUp();
        categoryIdField.slideDown();
      } else if (value === "product") {
        categoryIdField.slideUp();
        productIdField.slideDown();
      }
    });
  });
javascript;

$this->registerJs($jsCode, WebView::POS_READY, 'uniqueid')  ?>
</div>

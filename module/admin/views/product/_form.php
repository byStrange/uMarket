<?php

use app\components\Utils;
use app\models\Category;
use app\models\Image;
use app\models\Product;
use app\models\User;
use app\widgets\CheckBoxItem;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\jui\Accordion;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */

// Get the current action ID for conditional display
$actionId = Yii::$app->controller->action->id;

// Generate options lists for dropdowns
$imageOptionsList = Image::toOptionsList();
$toProductsOptionsList = Product::toOptionsList();
$categoriesOptionList = Category::toOptionsList();
$usersOptionList = User::toOptionsList();
$specifications = $model->specifications;
$this->registerJsFile('@web/js/realtime-dataload.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<style>
  #product-toproducts {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
  }
</style>
<div class="product-form">

  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-6">
      <?= Utils::popupField($form, $model, "category", function ($form, $model) use ($categoriesOptionList) {
        return $form
          ->field($model, "categories[]")
          ->dropDownList($categoriesOptionList, [
            "multiple" => true,
            "options" => Utils::preSelectOptions($model->categories),
          ])->label(Yii::t('app', 'Categories'));
      }) ?>


      <?= $form->field($model, 'title')->textInput()->label(Yii::t("app", "Title"))->hint(Yii::t("app", "Used as a default title (may be overwritten by translations)")) ?>

      <?= $form->field($model, 'description')->textarea()->label(Yii::t("app", "Description"))->hint(Yii::t("app", "Used as a default description (may be overwritten by translations)")) ?>


      <?php echo $form->field($model, 'images[]')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*', 'multiple' => true, 'class' => 'no-preview-image-on-upload'],
        'pluginOptions' => [
          'showUpload' => false,
          'showRemove' => false,
          'initialPreview' => $model->_getImagesAsHTMLMarkup()["initialPreview"],
          'initialPreviewAsData' => true,
          'initialPreviewConfig' => $model->_getImagesAsHTMLMarkup()["initialPreviewConfig"]
        ],
      ]); ?>


      <?php if ($actionId != "create"): ?>

        <?=
        /*Utils::popupField($form, $model, "user", function ($form, $model) use ($usersOptionList) {*/
        /*  return $form*/
        /*    ->field($model, "viewers[]")*/
        /*    ->dropDownList($usersOptionList, [*/
        /*      "multiple" => true,*/
        /*      "options" => Utils::preSelectOptions($model->viewers),*/
        /*    ])->label(Yii::t('app', 'Viewers'));*/
        /*})*/
        ''
        ?>

        <?=
        ''
        /*$form->field($model, 'views')->input('number', [*/
        /*          'class' => 'form-control',*/
        /*          'readonly' => true*/
        /*])->label(Yii::t('app', 'Views')); */
        ?>

        <?=
        // Utils::popupField($form, $model, "user", function ($form, $model) use ($usersOptionList) {
        //   return $form
        //     ->field($model, "likedUsers[]")
        //     ->dropDownList($usersOptionList, [
        //       "multiple" => true,
        //       "options" => Utils::preSelectOptions($model->likedUsers),
        //     ])->label(Yii::t('app', 'Liked Users'));
        // })
        '' ?>

      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'price')->input('number', [
        'step' => '0.01',
        'id' => 'price-input',
        'class' => 'form-control'
      ])->label(Yii::t('app', 'Price')); ?>

      <?= $form->field($model, 'discount_price')->input('number', [
        'step' => '0.01',
        'id' => 'discount-price-input',
        'class' => 'form-control'
      ])->label(Yii::t('app', 'Discount Price')); ?>

      <?= $form->field($model, 'status')->dropDownList($model->getStatusOptions(), ['class' => 'form-select'])->label(Yii::t('app', 'Status')); ?>

      <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#selectProductWrapperModal"><?= Yii::t("app", "Related products") ?></button>

      <div class="modal fade" id="selectProductWrapperModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><?= Yii::t("app", "Related Products") ?></h5>
            </div>
            <div class="modal-body">

              <p class="text-muted">Related products is list of products that will be shown in detail page of a single product</p>

              <div id="selectProductWrapper">

                <?php $productOptionList = Product::toOptionsList(true); ?>

                <?= $form->field($model, 'toProducts[]')->checkboxList(
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
                    }, $model->toProducts)
                  ]
                ) ?>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" data-bs-toggle="modal" data-bs-target="#selectProductWrapperModal" class="btn btn-primary">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-md-12">
        <h3><?= Yii::t('app', 'Product Specifications') ?></h3>
        <?php echo Accordion::widget([
          "id" => "specifications-accordion",
          "items" => [
            [
              "header" => Yii::t('app', 'Specifications'),
              "content" => '<div id="specifications-container" class="row">' .
                implode('', array_map(function ($specification, $index) use ($form) {
                  return $this->render('_spec_form', [
                    'model' => $specification,
                    'index' => $index,
                    'form' => $form,
                  ]);
                }, $specifications, array_keys($specifications)))
                . '</div>',
              "active" => true // Set this to true if you want the section open by default
            ],
          ],
          'clientOptions' => ['collapsible' => true, 'active' => false, 'heightStyle' => 'content'],
        ]); ?>

        <?= Html::button(Yii::t('app', 'Add Specification'), [
          'class' => 'btn btn-primary my-2',
          'hx-get' => Yii::$app->urlManager->createUrl(['/admin/product/add-specification']),
          'hx-target' => '#specifications-container',
          'hx-swap' => 'beforeend',
          'hx-trigger' => 'click',
          'hx-vals' => 'js:{"index": document.getElementById("specifications-container").childElementCount}',
        ]) ?>

      </div>
    </div>

    <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Save'), ["class" => "btn btn-success"]) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

</div>

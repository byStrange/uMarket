<?php

use app\models\Category;
use app\models\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategoryTranslation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-translation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form
        ->field($model, "language_code")
        ->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "name")->textInput(["maxlength" => true]) ?>

    <?php if (isset($category_id)) {
        echo $form
            ->field($model, "category_id")
            ->hiddenInput(["value" => $category_id])
            ->label("Category Id: $category_id");
    } else {
        echo $form
            ->field($model, "category_id")
            ->dropDownList(
                Category::find()
                    ->select(["id"])
                    ->indexBy("id")
                    ->column()
            )
            ->label("Category");
    } ?>
   <?= $form
       ->field($model, "image_id")
       ->dropDownList([Image::find()->indexBy("id")->column()]) ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

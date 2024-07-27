<?php

use app\models\Category;
use app\widgets\RadioItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
#category-type {
  margin-top:8px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
gap: 24px;
}
</style>
<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form
        ->field($model, "parent_id_id")
        ->dropDownList(
            Category::find()->select("label")->indexBy("id")->column(),
            [
                "prompt" => "--- Select a Category ---",
            ]
        ) ?>

    <?= $form->field($model, "label")->textInput() ?>

    <?= $form
        ->field($model, "type")
        ->radioList(
            array_column(Category::getTypeOptions(), "label", "value"),
            [
                "item" => function ($index, $label, $name, $checked, $value) {
                    $description = Category::getTypeOptions()[$value][
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


    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

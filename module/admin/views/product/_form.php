<?php

use app\components\Utils;
use app\models\Category;
use app\models\Image;
use app\models\Product;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, "categories[]")->dropDownList(
        Category::find()
            ->select(["label"])
            ->indexBy("id")
            ->column(),
        [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
                Category::find()
                    ->select(["id"])
                    ->indexBy("id")
                    ->column(),
                $model->categories
            ),
        ]
    ) ?>

    <?= $form->field($model, "images[]")->dropDownList(
        Image::find()
            ->select(["image"])
            ->indexBy("id")
            ->column(),
        [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
                Image::find()
                    ->select(["id"])
                    ->indexBy("id")
                    ->column(),
                $model->images
            ),
        ]
    ) ?>

    <?= $form
        ->field($model, "toProducts[]")
        ->dropDownList(Product::find()->indexBy("id")->column(), [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
                Product::find()
                    ->select(["id"])
                    ->indexBy("id")
                    ->column(),
                $model->toProducts
            ),
        ]) ?>

    <?= $form->field($model, "viewers[]")->dropDownList(
        User::find()
            ->select(["username"])
            ->indexBy("id")
            ->column(),
        [
            "multiple" => true,
            "options" => Utils::preSelectOptions(
                User::find()
                    ->select(["id"])
                    ->indexBy("id")
                    ->column(),
                $model->toProducts
            ),
        ]
    ) ?> 

<?= $form->field($model, "likedUsers[]")->dropDownList(
    User::find()
        ->select(["username"])
        ->indexBy("id")
        ->column(),
    [
        "multiple" => true,
        "options" => Utils::preSelectOptions(
            User::find()
                ->select(["id"])
                ->indexBy("id")
                ->column(),
            $model->likedUsers
        ),
    ]
) ?> 
    <?= $form->field($model, "price")->textInput() ?>

    <?= $form->field($model, "discount_price")->textInput() ?>

    <?= $form->field($model, "status")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "views")->textInput() ?>

    <?= $form
        ->field($model, "created_by_id")
        ->dropDownList(User::find()->indexBy("id")->column()) ?>

    <div class="form-group">
        <?= Html::submitButton("Save", ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

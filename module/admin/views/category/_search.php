<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\module\admin\models\search\CategorySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        "action" => ["index"],
        "method" => "get",
    ]); ?>

    <?= $form->field($model, "id") ?>

    <?= $form->field($model, "created_at") ?>

    <?= $form->field($model, "updated_at") ?>

    <?= $form->field($model, "parent_id") ?>

    <div class="form-group">
        <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
        <?= Html::resetButton("Reset", [
            "class" => "btn btn-outline-secondary",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

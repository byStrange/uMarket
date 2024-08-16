<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\ProductSpecification $model */
/** @var integer $index */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="specification-form col-3 specification-<?= $model->id ?>" id="specification-<?= $index ?>">
  <h4><?= $index + 1 ?></h4>
  <?= $form->field(
    $model,
    "[$index]spec_key",
    [
      'inputOptions' => [
        'id' => 'spec-key-' . $index,
        "class" => "form-control"
      ]
    ]
  )
    ->textInput(['maxlength' => true])
    ->label(Yii::t('app', 'Specification Key'))
  ?>

  <?= $form->field(
    $model,
    "[$index]spec_value",
    [
      'inputOptions' => [
        'id' => 'spec-value-' . $index,
        "class" => "form-control"
      ]
    ]
  )
    ->textInput(['maxlength' => true])
    ->label(Yii::t('app', 'Specification Value'))
  ?>

  <div class="d-flex gap-2">
    <?php if ($model->id) {
      echo Html::button(Yii::t('app', 'Update'), [
        'class' => 'btn btn-primary btn-sm',
        'hx-post' => Url::toRoute(['product/update-specification', 'id' => $model->id]),
        'hx-vals' => 'js:{
        "id": ' . $model->id . ',
        "spec_key": document.querySelector("#spec-key-' . $index . '").value,
        "spec_value": document.querySelector("#spec-value-' . $index . '").value
      }',
        'hx-swap' => 'none',
        'hx-include' => "#spec-key-$index, #spec-value-$index",

      ]);
    }
    ?>


    <?= Html::button(Yii::t('app', 'Remove'), [
      'class' => 'btn btn-danger btn-sm',
      'hx-post' => $model->id ? Url::toRoute(['product/remove-specification', 'id' => $model->product_id, 'index' => $index, 'id' => $model->id]) : 'javascript:void(0);',
      'hx-confirm' => Yii::t('app', 'Are you sure you want to delete this specification?'),
      'hx-swap' => 'none',
      'onclick' => $model->id ? '' : 'document.getElementById("specification-' . $index . '").remove()', // Example action if ID doesn't exist
    ]) ?>

  </div>
</div>

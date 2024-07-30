<?php

namespace app\components;

use Exception;
use yii\helpers\Html;
use yii\helpers\Url;

class Utils
{
  public static function preSelectOptions($dataIds, $existingRelation)
  {
    if (empty($dataIds) || empty($existingRelation)) {
      return [];
    }
    $options = [];
    $existingIds = array_column($existingRelation, "id");
    foreach ($dataIds as $id) {
      $options[$id] = [
        "selected" => in_array($id, $existingIds),
      ];
    }
    return $options;
  }

  public static function uploadImage($image, $outputFolder = 'uploads', $generateImageId = null)
  {
    if (!$image || !$image->tempName) {
      return false;
    }

    if (!is_dir($outputFolder)) {
      if (!mkdir($outputFolder, 0755, true)) {
        throw new Exception("Failed to create upload directory: $outputFolder");
      }
    }

    $filename = ($generateImageId) ? $generateImageId($image) . '.' . $image->extension : $image->baseName . uniqid() . '.' . $image->extension;
    $filePath = $outputFolder . '/' . $filename;

    if (!$image->saveAs($filePath)) {
      throw new Exception("Failed to save uploaded image to $filePath");
    }

    return $filePath;
  }

  public static function popupField($form, $model, $modelName ='', $field) {
   echo "<div class='row'>";
     echo "<div class='col-3'>";
       $d = $field($form, $model);
       echo $d;
     echo "</div>";
     echo "<div class='col-4 d-flex align-items-center'>";
       $inputId = $d->inputId;
       $inputIdSplit = explode('-', $inputId);
       $inputIdToModelName = $modelName ? $modelName : $inputIdSplit[1];
       $inputIdModelName = explode('_', $inputIdToModelName)[0];
       echo Html::a("<i class='fa fa-plus' aria-hidden='true'></i>", Url::toRoute([$inputIdModelName . '/create']) . '/?popup=1', ["id" => 'add-' . $inputId, "data-popup" => "", "title" => "Create category object and insert it here"]);
    
    echo "</div>";
   echo "</div>";
  }
}

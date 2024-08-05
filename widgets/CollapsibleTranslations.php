<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;



class CollapsibleTranslations extends Widget
{
  public $translations; // Array of ProductTranslation objects
  public $titleFieldName;
  public $descriptionFieldName;
  public $controllerId;

  public function init()
  {
    parent::init();
  }

  public function run()
  {
    if (!empty($this->translations)) {
      echo "<h2>Product Translations</h2>";
      echo "<div class='accordion' id='productTranslationsAccordion'>";
      foreach ($this->translations as $i => $translation) {
        echo "<div class='accordion-item'>";
        echo "<h2 class='accordion-header' id='translationsHeading-$i'>";
        echo "<button class='accordion-button collapsed gap-2 d-flex' type='button' data-bs-toggle='collapse' data-bs-target='#translationsCollapse-$i' aria-expanded='false' aria-controls='translationsCollapse-$i'>";
        echo "<span>Code: <b>{$translation->language_code}</b></span> <span>Title: <b>" . ($this->titleFieldName ? $translation[$this->titleFieldName] : '') . "</b></span>";
        echo "</button>";
        echo "</h2>";
        echo "<div id='translationsCollapse-$i' class='accordion-collapse collapse' aria-labelledby='translationsHeading-$i' data-bs-parent='#productTranslationsAccordion'>";
        echo "<div class='accordion-body'>";
        if ($this->descriptionFieldName && !empty($translation[$this->descriptionFieldName])) {
          echo "<p>Description: {$translation[$this->descriptionFieldName]}</p>";
        }
        echo "<p>Created At: " . Yii::$app->formatter->asDatetime($translation->created_at) . "</p>";
        echo "<p>Updated At: " . Yii::$app->formatter->asDatetime($translation->updated_at) . "</p>";
        echo "<div class=\"d-flex gap-2\">";
        echo Html::a(
          "Update",
          ["$this->controllerId/update", "id" => $translation->id],
          ["class" => "btn btn-primary"]
        );
        echo Html::a(
          "Delete",
          ["$this->controllerId/delete", "id" => $translation->id],
          ["class" => "btn btn-danger",     "data" => [
            "confirm" => "Are you sure you want to delete this item?",
            "method" => "post",
          ]]
        );
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
      }
      echo "</div>";
    } else {
      echo "No translations found for this product.";
    }
  }
}

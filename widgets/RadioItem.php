<?php

namespace app\widgets;

use yii\base\Widget as BaseWidget;

class RadioItem extends BaseWidget
{
  public $label;
  public $description;
  public $name;
  public $id;
  public $value;
  public $checked = false;
  public $showRadioInput = true;

  public function run()
  {
    $checkedAttribute = $this->checked ? 'checked' : '';
    $visibilityStyle = $this->showRadioInput ? '' : 'visibility: hidden;';

    return <<<HTML
            <div class="position-relative">
                <input class="form-check-input position-absolute z-1 ms-3" style="z-index: 1; right: 10px; top: 10px; {$visibilityStyle}" value="{$this->value}" type="radio" name="{$this->name}" id="{$this->id}" {$checkedAttribute}>
                <label class="form-check-label w-100" for="{$this->id}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{$this->label}</h5>
                            <p class="card-text text-muted">{$this->description}</p>
                        </div>
                    </div>
                </label>
            </div>
        HTML;
  }
}

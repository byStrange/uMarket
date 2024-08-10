<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Card extends Widget
{
  public $title;
  public $content;
  public $footer;
  public $options = [];
  public $titleOptions = [];
  public $bodyOptions = [];
  public $footerOptions = [];

  public function init()
  {
    parent::init();
    Html::addCssClass($this->options, 'card');
    Html::addCssClass($this->titleOptions, 'card-header');
    Html::addCssClass($this->bodyOptions, 'card-body');
    Html::addCssClass($this->footerOptions, 'card-footer');
  }

  public function run()
  {
    $content = [];

    if ($this->title !== null) {
      $content[] = Html::tag('div', $this->title, $this->titleOptions);
    }

    if ($this->content !== null) {
      $content[] = Html::tag('div', $this->content, $this->bodyOptions);
    }

    if ($this->footer !== null) {
      $content[] = Html::tag('div', $this->footer, $this->footerOptions);
    }

    return Html::tag('div', implode("\n", $content), $this->options);
  }
}

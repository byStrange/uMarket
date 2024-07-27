<?php

namespace app\module\admin;

/**
 * admin module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "app\module\admin\controllers";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->layout = "main";
        parent::init();

        // custom initialization code goes here
    }
}

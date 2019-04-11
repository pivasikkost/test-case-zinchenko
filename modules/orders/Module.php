<?php

namespace orders;

/**
 * orders module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'orders\controllers';

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'orders';

    /**
     * {@inheritdoc}
     */
    public $layout = 'orders';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

<?php

namespace app\modules\cadastral;

/**
 * cadastral module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\cadastral\controllers';

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = '/cadastral/index';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

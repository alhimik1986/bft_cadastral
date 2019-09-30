<?php

namespace alhimik1986\bftcadastral;

/**
 * cadastral module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'alhimik1986\bftcadastral\controllers';

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

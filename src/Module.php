<?php

namespace rushstart\user;

use Yii;
use yii\base\BootstrapInterface;

/**
 * userManager module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'rushstart\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
    }

    /**
     * Module specific urlManager
     * @param \yii\base\Application $app
     */
    public function bootstrap($app) {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                'user' => "{$this->id}/user/index",
                'user/<action>' => "{$this->id}/user/<action>",
                'role' => "{$this->id}/role/index",
                'role/<action>' => "{$this->id}/role/<action>",
                'permission' => "{$this->id}/permission/index",
                'permission/<action>' => "{$this->id}/permission/<action>",
                'rule' => "{$this->id}/rule/index",
                'rule/<action>' => "{$this->id}/rule/<action>",
                    ], false);
        }
    }

}

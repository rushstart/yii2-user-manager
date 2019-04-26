<?php

namespace rushstart\usermanager\components;

use Yii;
use yii\helpers\ArrayHelper;
use rushstart\usermanager\models\AuthPermission;

/**
 * @inheritdoc
 */
class User extends \yii\web\User
{

    /**
     * @inheritdoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        //создать разрешение для доступа если оно еще не создано
        empty(AuthPermission::findOne($permissionName)) && (new AuthPermission(['name' => $permissionName]))->save();

        if (!Yii::$app->user->isGuest && in_array('root', ArrayHelper::getColumn((array) Yii::$app->user->identity->roles, 'name'))) {
            return TRUE;
        }
        return parent::can($permissionName, $params, $allowCaching);
    }

    public function getRequestedRoute()
    {
        $parts = [Yii::$app->requestedAction->id];

        $parts[] = Yii::$app->requestedAction->controller->id;
        $module = Yii::$app->requestedAction->controller->module;
        while ($module->id !== Yii::$app->id) {
            $parts[] = $module->id;
            $module = $module->module;
        }
        krsort($parts);
        return join('/', $parts);
    }

}

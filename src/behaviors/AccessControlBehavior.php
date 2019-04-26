<?php

namespace rushstart\usermanager\behaviors;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Access control for controller actions
 */
class AccessControlBehavior extends \yii\base\ActionFilter
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (empty($action->exceptionCode)) {
            $requestedRoute = Yii::$app->user->requestedRoute;

            if (Yii::$app->user->isGuest) {
                Yii::$app->user->setReturnUrl($requestedRoute);
                Yii::$app->response->redirect('/user/login');
                return FALSE;
            } elseif (!Yii::$app->user->can($requestedRoute)/* суперюзер везде пройдет */) {
                if (!Yii::$app->user->identity->roles) {
                    Yii::$app->session->setFlash('warning', 'Обратитесь к администратору, чтобы получить доступ');
                }
                throw new ForbiddenHttpException('Доступ запрещен.');
            }
            return TRUE;
        }
    }

}

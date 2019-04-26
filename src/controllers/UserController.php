<?php

namespace rushstart\user\controllers;

use rushstart\user\behaviors\AccessControlBehavior;
use rushstart\user\models\forms\LoginForm;
use rushstart\user\models\forms\SignupForm;
use rushstart\user\models\forms\UserForm;
use rushstart\user\models\Identity;
use rushstart\user\models\search\UserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [

            'access' => [
                'class'  => AccessControlBehavior::class,
                'except' => ['signup', 'login', 'logout'],
            ],

            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return \yii\web\Response|string
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return \yii\web\Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'auth';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return \yii\web\Response|string
     */
    public function actionSignup() {
        $this->layout = 'auth';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->user->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return \yii\web\Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (($model = UserForm::findOne($id)) === null) {
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
        $model->load(Yii::$app->request->post()) && $model->save();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return \yii\web\Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Identity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Identity {
        if (($model = Identity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
        }
    }

    /**
     * Logout action.
     * @return \yii\web\Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Set status deleted an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->status = Identity::STATUS_DELETED;
        $model->save();
        return $this->redirect(['index']);
    }

}

<?php

namespace rushstart\user\controllers;

use rushstart\user\behaviors\AccessControlBehavior;
use rushstart\user\models\AuthRule;
use rushstart\user\models\search\AuthRuleSearch;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RuleController implements the CRUD actions for AuthRule model.
 */
class RuleController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [

            'access' => [
                'class' => AccessControlBehavior::class,
            ],

            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'reindex' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthRule models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AuthRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Deletes an existing AuthRule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException if [[optimisticLock|optimistic locking]] is enabled and the data
     * being deleted is outdated.
     * @throws \Exception|\Throwable in case delete failed.
     */
    public function actionDelete($id) {
        if (($model = AuthRule::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * The index of the directory rules
     * @return \yii\web\Response
     */
    public function actionReindex() {

        array_map(function ($file) {
            $className = '\\' . AuthRule::getRulesNamespace() . '\\' . str_replace('.php', '', $file);
            if (class_exists($className)) {
                $rule = new $className;
                if ($rule instanceof \yii\rbac\Rule) {
                    if (!Yii::$app->authManager->getRule($rule->name)) {
                        Yii::$app->authManager->add($rule);
                    }
                }
            }
        }, array_diff(scandir(Yii::getAlias('@' . str_replace('\\', '/', AuthRule::getRulesNamespace()), false)), [
            '..',
            '.'
        ]));

        return $this->redirect(['index']);
    }
}

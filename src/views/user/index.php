<?php

use yii\bootstrap\Html;
use rushstart\user\models\AuthRole;
use rushstart\user\models\Identity;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel rushstart\user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';

$gridActions = [];
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/update')) {
    $gridActions[] = '{update}';
}
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/delete')) {
    $gridActions[] = '{delete}';
}
?>
<div class="user-index">
    <div class="box box-default">
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width:80px'],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->name, ['user/view', 'id' => $model->id]);
                        }
                    ],
                    'email',
                    [
                        'attribute' => 'status',
                        'filter' => Identity::getStatuses(),
                        'value' => 'statusViewFormat',
                    ],
                    [
                        'attribute' => 'roles',
                        'filter' => ArrayHelper::map(AuthRole::find()->all(), 'name', function ($permission) {
                                    return $permission;
                                }),
                        'value' => function ($model) {
                            return join(', ', $model->roles);
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'template' => join(' ', $gridActions)],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?php

use yii\bootstrap\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel rushstart\user\models\search\AuthRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли';

$gridActions = [];
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/update')) {
    $gridActions[] = '{update}';
}
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/delete')) {
    $gridActions[] = '{delete}';
}
?>
<div class="auth-role-index">
    <div class="box box-default">
        <div class="box-header">
            <div class="box-tools">
                <?= Html::a('<i class="fa fa-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    [
                        'attribute' => 'name',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return Html::a($model->name, ['view', 'id' => $model->primaryKey], [], TRUE);
                        },
                    ],
                    'description:ntext',
                    ['class' => 'yii\grid\ActionColumn', 'template' => join(' ', $gridActions)],
                ],
            ]); ?>
        </div>
    </div>
</div>

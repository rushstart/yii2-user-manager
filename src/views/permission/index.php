<?php

use yii\bootstrap\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel rushstart\usermanager\models\search\AuthPermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Права доступа';
$gridActions = [];
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/update')) {
    $gridActions[] = '{update}';
}
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/delete')) {
    $gridActions[] = '{delete}';
}
?>
<div class="auth-permission-index">
    <div class="box box-default">
        <div class="box-header">
            <div class="box-tools">
                <?= Html::a('<i class="fa fa-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'name',
                    'description:ntext',
                    'rule_name',
                    ['class' => 'yii\grid\ActionColumn', 'template' => join(' ', $gridActions)],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

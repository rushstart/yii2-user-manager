<?php

use yii\grid\GridView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $searchModel rushstart\usermanager\models\search\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Правила доступа';

$gridActions = [];
if (Yii::$app->user->can(dirname(Yii::$app->user->requestedRoute) . '/delete')) {
    $gridActions[] = '{delete}';
}
?>
<div class="auth-rule-index">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <?= Html::a(
                    '<i class="fa fa-refresh"></i> Индексировать',
                    ['reindex'],
                    [
                        'class'       => 'btn btn-success',
                        'data-method' => 'post'
                    ]) ?>
            </div>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    'name',
                    ['class' => 'yii\grid\ActionColumn', 'template' => join(' ', $gridActions)],
                ],

            ]); ?>
        </div>
    </div>
</div>

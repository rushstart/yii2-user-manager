<?php

use yii\bootstrap\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model rushstart\user\models\AuthRole */

$this->title = StringHelper::truncate($model->name, 60);
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];

?>
<div class="auth-role-view">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <?= Html::a('<i class="fa fa-pencil"></i>', [
                    'update',
                    'id' => $model->primaryKey
                ], ['class' => 'btn btn-primary'], true) ?>
            </div>
        </div>
        <div class="box-body">

            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'name',
                    'description:ntext',
                    [
                        'attribute' => 'permissions',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return join('<br>', array_map(function ($permission) {
                                return '<span class="label label-default" title="' . $permission . '">' . $permission . '</span> ';
                            }, $model->permissions));
                        },
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>

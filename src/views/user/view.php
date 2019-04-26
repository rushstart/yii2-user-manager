<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model rushstart\usermanager\models\Identity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <?= Html::a('<i class="fa fa-pencil"></i>', [
                    'update',
                    'id' => $model->id
                ], ['class' => 'btn btn-primary'], true) ?>
            </div>
        </div>
        <div class="box-body">

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'email:email',
                    [
                        'attribute' => 'roles',
                        'value'     => function ($model) {
                            return join(', ', $model->roles);
                        },
                    ],
                    'statusViewFormat',
                ],
            ])
            ?>

        </div>
    </div>
</div>

<?php

use yii\bootstrap\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model rushstart\usermanager\models\AuthPermission */

$this->title = 'Редактировать: ' . StringHelper::truncate($model->name, 60);
$this->params['breadcrumbs'][] = ['label' => 'Права доступа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->name, 60), 'url' => ['view', 'id' => $model->name]];
?>
<div class="auth-permission-update">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

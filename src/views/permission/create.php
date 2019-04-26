<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model rushstart\usermanager\models\AuthPermission */

$this->title = 'Добавить полномочие';
$this->params['breadcrumbs'][] = ['label' => 'Права доступа', 'url' => ['index']];

?>
<div class="auth-permission-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

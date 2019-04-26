<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model rushstart\user\models\AuthRole */

$this->title = 'Добавить роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];

?>
<div class="auth-role-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

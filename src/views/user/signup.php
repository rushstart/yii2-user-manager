<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model rushstart\usermanager\models\forms\SignupForm */

$this->title = 'Регистрация';
$fieldNameOptions = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='fa fa-user form-control-feedback'></i>"
];
$fieldEmailOptions = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='fa fa-envelope-o form-control-feedback'></i>"
];

$fieldPasswordOptions = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='fa fa-lock form-control-feedback'></i>"
];
?>
<div class="register-box">
    <div class="register-logo">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="register-box-body">
        <p class="register-box-msg">Заполните все поля для регистрации</p>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?=
        $form
            ->field($model, 'name', $fieldNameOptions)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('name') . ' (Например: Иванов Иван)'])
        ?>

        <?=
        $form
            ->field($model, 'email', $fieldEmailOptions)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')])
        ?>

        <?=
        $form
            ->field($model, 'password', $fieldPasswordOptions)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a('Войти', ['login']) ?><br>
    </div>
</div>


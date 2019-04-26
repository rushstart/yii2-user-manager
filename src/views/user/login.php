<?php


use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model rushstart\usermanager\models\forms\LoginForm */

$this->title = 'Вход в систему';

$fieldEmailOptions = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='fa fa-envelope-o form-control-feedback'></i>"
];

$fieldPasswordOptions = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<i class='fa fa-lock form-control-feedback'></i>"
];

?>

<div class="login-box">
    <div class="login-logo">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Заполните поля чтобы начать работу</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

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

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Войти', [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'name'  => 'login-button'
                ]) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <?= Html::a('Зарегистрироваться', ['signup']) ?>
        <br>


    </div>
</div>
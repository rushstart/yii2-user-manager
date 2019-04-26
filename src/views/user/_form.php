<?php

use yii\bootstrap\Html;
use rushstart\user\models\AuthRole;
use rushstart\user\models\Identity;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model rushstart\user\models\forms\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'status')->dropDownList(Identity::getStatuses()) ?>
                </div>
                <?php if (Yii::$app->user->can('change_user_password')): ?>
                    <div class="col-md-2">
                        <?= $form->field($model, 'newPassword')->textInput(['maxlength' => true]) ?>
                    </div>
                <?php endif; ?>
            </div>
            <?=
            $form->field($model, 'roles')->widget(Select2::class, [
                'data'    => ArrayHelper::map(AuthRole::find()->all(), 'name', 'description'),
                'options' => [
                    'placeholder' => 'Выберите роли ...',
                    'multiple'    => true,
                    'value'       => ArrayHelper::getColumn($model->roles, 'name')
                ],
            ]);
            ?>

        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

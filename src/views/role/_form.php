<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use rushstart\user\widgets\MultiSelectWidget;
use yii\helpers\ArrayHelper;
use rushstart\user\models\AuthPermission;

/* @var $this yii\web\View */
/* @var $model rushstart\user\models\AuthRole */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="auth-role-form">

    <?php $form = ActiveForm::begin([
        'id' => 'auth-role-form',
    ]); ?>

    <div class="box <?= $model->isNewRecord ? 'box-success' : 'box-primary' ?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?=
                    $form->field($model, 'permissions')->widget(MultiSelectWidget::class, [
                        'data'   => ArrayHelper::map(AuthPermission::find()->all(), 'name', function ($permission) {
                            return $permission;
                        }),
                        'search' => TRUE,
                    ]);
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

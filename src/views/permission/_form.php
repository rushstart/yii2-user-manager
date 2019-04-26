<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use rushstart\usermanager\models\AuthRule;

/* @var $this yii\web\View */
/* @var $model rushstart\usermanager\models\AuthPermission */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="auth-permission-form">

    <?php $form = ActiveForm::begin([
        'id' => 'auth-permission-form',
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
                <div class="col-md-9">
                    <?=
                    $form->field($model, 'rule_name')
                        ->dropDownList(ArrayHelper::map(AuthRule::find()->all(), 'name', 'name'), ['prompt' => ''])
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

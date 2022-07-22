<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактировать данные пользователя';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="lwsuser-edit">


    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>


        <?php if (Yii::$app->session->hasFlash('Wrongeditpassword')): ?>

            <div class="alert alert-danger">
                Не правильно введён пароль пользователя!
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('Nopeeditpassword')): ?>

            <div class="alert alert-danger">
                Введите пароль пользователя для изменения данных пользователя!
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('Wrongchecknewpassword')): ?>

            <div class="alert alert-danger">
                Введёный новый пароль повторили не правильно!
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-5">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => strval(Yii::$app->user->identity->username)])->label('Логин') ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'value' => strval(Yii::$app->user->identity->name)])->label('ФИО') ?>

            <?= $form->field($model, 'edit_password')->passwordInput()->label('Пароль<font color="f33810">*</font>') ?>

            <?= $form->field($model, 'new_password')->passwordInput()->label('Новый пароль') ?>

            <?= $form->field($model, 'check_new_password')->passwordInput()->label('Повторите новый пароль') ?>

            <?php 
            $model->password = 0;
            $model->role = 0;
            ?>
            <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <?= Html::a('Отмена', ['/site/account'], ['class'=>'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>

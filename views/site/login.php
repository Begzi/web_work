<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row align-items-center">
            <div class="col-md-4"></div>

            <div class="col-md-4">
                

                <h1><?= Html::encode($this->title) ?></h1>


                <?php $form = ActiveForm::begin([
                    'id' => 'login-form'
                ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                    <?= 
                    // $form->field($model, 'rememberMe')->checkbox([
                    //     'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    // ]) 
                    $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="col-md-4"></div>
        </div>
    </div>
</div>

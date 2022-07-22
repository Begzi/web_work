<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новый пользователь';
// $this->params['breadcrumbs'][] = $this->title;
$role = ['admin', 'manager','TZI'];
?>
<div class="lwsuser-login">


    <div class="container">
        <div class="row">
            <div class="col-lg-5">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин<font color="f33810">*</font>') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль<font color="f33810">*</font>') ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('ФИО<font color="f33810">*</font>') ?>

            <?= $form->field($model, 'role')->dropDownList($role)->label('Роль<font color="f33810">*</font>') ?>

            <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <?= Html::a('Отмена', ['/site/account'], ['class'=>'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>

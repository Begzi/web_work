<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\CastomersForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новый заказчик';
// $this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container">
    <div class="customers_add">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('HaveUHHFormSubmitted')): ?>

            <div class="alert alert-danger">
                Организация с таким ИНН существует
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('WrongUHHFormSubmitted')): ?>

            <div class="alert alert-danger">
                Не правильно введён ИНН. Длина ИНН = 10
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('WrongCPPFormSubmitted')): ?>

            <div class="alert alert-danger">
                Не правильно введён КПП. Длина КПП = 9
            </div>
        <?php endif; ?>


        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'customers-form']); ?>

                <?= $form->field($model, 'fullname')->textInput(['autofocus' => true])->label('Полное имя учреждения<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'shortname')->textInput(['autofocus' => true])->label('Короткое имя учреждения<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'leg_address')->textInput(['autofocus' => true])->label('Адрес<font color="f33810">*</font>')  ?>

                <?= $form->field($model, 'UHH')->textInput(['autofocus' => true])->label('ИНН(10)<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'CPP')->textInput(['autofocus' => true])->label('КПП(9)<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'doc_type_id')
                ->dropDownList([
                '1' => 'Электронный',
                '2' => 'Бумажный',
                ],
                [
                'prompt' => 'Выберите один вариант'
                ])->label('Тип документооборота<font color="f33810">*</font>');?>

                 <?= $form->field($model, 'customer_group_name_id')
                ->dropDownList([$customer_group_name])
                ->label('Группа<font color="f33810">*</font>');?>

                <?= $form->field($model, 'description')->textarea()->label('Примечание') ?>
                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'customers-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/index'], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
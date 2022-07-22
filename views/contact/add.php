<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление контактов';
// $this->params['breadcrumbs'][] = $this->title;
$department = ['Остальные', "Юридический отдел", "Администрация", 'Бухгалтерия', "IT отдел", "Отдел безопастности"];

?>
<div class="container">
    <div class="contact_list_add">
        <?php if (Yii::$app->session->hasFlash('NumberMustHave')): ?>

            <div class="alert alert-danger">
                У контакта должен быть рабочий либо мобильный телефон!
            </div>


        <?php endif; ?>

        <div class="row">
            <div class="col-lg-5">


                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'position')->textInput()->label('Должность') ?>

                <?= $form->field($model, 'department')
                    ->dropDownList($department)->label('Отдел<font color="f33810">*</font>');?>

                <?= $form->field($model, 'name')->textInput()->label('ФИО') ?>

                <?= $form->field($model, 'mail')->textInput()->label('Почта')  ?>

                <?= $form->field($model, 'w_tel')->textInput()->label('Рабочий телефон') ?>

                <?= $form->field($model, 'm_tel')->textInput()->label('Мобильный телефон') ?>

                <?= $form->field($model, 'description')->textInput()->label('Примечание') ?>



                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/view','id' => $customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


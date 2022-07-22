<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление схемы';
// $this->params['breadcrumbs'][] = $this->title;

?>
<br>
<br>
<br>
<div class="container">
    <div class="scheme_list_add">

        <div class="row">
            <div class="col-lg-5">


                <?php $form = ActiveForm::begin(['id' => 'scheme-form']); ?>

                <?= $form->field($model, 'sc_link')->fileInput(  ['accept'=>'.jpg, .jpeg, .png'])->label('Выберите файл, содержащий изображение схемы<font color="f33810">*</font>'); ?>

                <?= $form->field($model, 'description')->textInput()->label('Примечание') ?>



                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-add-button']) ?>
                    <?= Html::a('Отмена', ['/scheme/show','customer_id' => $customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


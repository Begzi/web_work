<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use app\models\AddressForm;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление адреса';
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="address_list_add">

        <div class="row">
            <div class="col-lg-5">


                <?php $form = ActiveForm::begin(['id' => 'address-form']); ?>

                <?= $form->field($model, 'region')
                    ->dropDownList($region)->label('Регион<font color="f33810">*</font>');?>

                <?= $form->field($model, 'district')->textInput()->label('Район') ?>

                <?= $form->field($model, 'city')->textInput()->label('Населённый пункт<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'street')->textInput()->label('Улица')  ?>

                <?= $form->field($model, 'num')->textInput()->label('Номер') ?>

                <?= $form->field($model, 'branch')->textInput()->label('Филиал<font color="f33810">*</font>') ?>



                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'address-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/view','id' => $customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


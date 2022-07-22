<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\CertForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Modal;

$this->title = 'Редактирование сертификата';
// $this->params['breadcrumbs'][] = $this->title;
$tmp=Array();
?>

<div class="container">
    <div class="cert_add">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('HaveFormatBad')): ?>

            <div class="alert alert-danger">
                Формат сертификата должен быть *.jpg, *.jpeg, *.png 
                <?php echo $check;?>
            </div>


        <?php endif; ?>

        <div class="row col-lg-5">
            <div class="col-lg-12">

                <?php $form = ActiveForm::begin(['id' => 'uz-list-form']); ?>


                <?= $form->field($model, 'num')->textInput(['autofocus' => true, 'value' => $cert->num ])->label('Номер сертификата<font color="f33810">*</font>')  ?>

                <?= $form->field($model, 'st_date')->widget(DatePicker::className(),[
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['value' => $cert->st_date],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd',
                        'autoclose'=>true,
                        'weekStart'=>1, //неделя начинается с понедельника
                        'startDate' => '01.05.2015', //самая ранняя возможная дата
                        'todayBtn'=>true, //снизу кнопка "сегодня"
                    ]
                ])->label('Начало действия сертификата<font color="f33810">*</font>'); ?>

                <div >
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'uzs-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/view','id' => $cert->customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
         <div class="col-lg-5 pull-right">

                <?php
                    Modal::begin([
                        'header' => '<h2>Вы уверены что хотите удалить сертификат?</h2>',
                        'toggleButton' => [
                            'label' => 'Удалить сертификат',
                            'tag' => 'button',
                            'class' => 'btn btn-danger',
                            'title' => 'Удалить сертификат'
                        ],
                    ]);
                ?>
                    
                    <?= Html::a('Да', ['/cert/delete', 'id' => $cert->id], ['class'=>'btn btn-danger']) ?>
                <?php Modal::end(); ?>
                              
            
            </div>

    </div>
</div>


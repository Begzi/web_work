<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\CertForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Добавление сертификата';
// $this->params['breadcrumbs'][] = $this->title;
$tmp=Array();
?>

<div class="container">
    <div class="cert_add">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('HaveNum')): ?>

            <div class="alert alert-danger">
                Сертификат с таким номер существует!
            </div>


        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('HaveFormatBad')): ?>

            <div class="alert alert-danger">
                Формат сертификата должен быть *.jpg, *.jpeg, *.png 
                <?php echo $check;?>
            </div>


        <?php endif; ?>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'uz-list-form']); ?>


                <?= $form->field($model, 'num')->textInput(['autofocus' => true])->label('Номер сертификата<font color="f33810">*</font>')  ?>

                <?= $form->field($model, 'st_date')->widget(DatePicker::className(),[
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Выберите дату...'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd',
                        'autoclose'=>true,
                        'weekStart'=>1, //неделя начинается с понедельника
                        'startDate' => '01.05.2015', //самая ранняя возможная дата
                        'todayBtn'=>true, //снизу кнопка "сегодня"
                    ]
                ])->label('Начало действия сертификата<font color="f33810">*</font>'); ?>

                <?= $form->field($model, 'sc_link')->fileInput(  ['accept'=>'.jpg, .jpeg, .png, .pdf'])->label('Выберите файл, содержащий скан-копию<font color="f33810">*</font>'); ?>

                

                <?php for($i=0; $i < count($uzs); $i++):?>
                    <?php $tmp[$uzs[$i]->id] = $uzs[$i]->id . ' - ' . $uzs[$i]->uztype->name . ' - ' . $uzs[$i]->uznet->num;?>
                <?php endfor;?>
                <?= $form->field($model, 'uzs_box[]')->
                    checkboxList($tmp)->label('Выберите узлы, которые есть в сертификате<font color="f33810">*</font>');?>

                
                    

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'uzs-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/view','id' => $customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


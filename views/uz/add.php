<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use kartik\date\DatePicker;
use app\models\ContactForm;
use yii\web\View;
use app\models\UzsForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление узлов';
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="uz_list_add">

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'uz-list-form']); ?>

                <?= $form->field($model, 'type_id')
                    ->dropDownList($type)->label('Тип узла<font color="f33810">*</font>');
                ?>

                <?= $form->field($model, 'net_id')
                    ->dropDownList($net)->label('Номер сети<font color="f33810">*</font>');
                ?>

                <?= $form->field($model, 'supply_time')->widget(DatePicker::className(),[
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Ввод даты...'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd',
                        'autoclose'=>true,
                        'weekStart'=>1, //неделя начинается с понедельника
                        'startDate' => '01.05.2015', //самая ранняя возможная дата
                        'todayBtn'=>true, //снизу кнопка "сегодня"
                    ]
                ])->label('Выберите дату ввода в эксплуатацию'); ?>

                <?= $form->field($model, 'number_for_add')->textInput(['autofocus' => true, 'value' => 1])->label('Введите количество узлов<font color="f33810">*</font>') ?>




                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'uzs-add-button']) ?>
                    <?= Html::a('Отмена', ['/customers/view','id' => $customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


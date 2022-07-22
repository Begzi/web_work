<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Событие №' . $logticketevent->id . '. Обращения №' . $logticketevent->logTicket->id;
// $this->params['breadcrumbs'][] = $this->title;

?>


<div class="container">
	

<?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить знание?</h2>',
        'toggleButton' => [
            'label' => 'Удалить событие',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить событие'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/logticket/deleteevent', 'logticketevent_id' => $logticketevent->id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?>
              
	<div class="row" style="padding:15px">
		

	    <?php $form = ActiveForm::begin(['id' => 'logticketevent-form']); ?>


	     
	        <?= $form->field($modelevent, 'text_description')->textarea(['value' => $logticketevent->text_description])->label('Описание события') ?>
	     
	        <?= $form->field($modelevent, 'next_date')->widget(DatePicker::className(),[
	                    'name' => 'dp_1',
	                    'type' => DatePicker::TYPE_INPUT,
	                    'options' => ['placeholder' => 'Выберите дату...'],
	                    'convertFormat' => true,
	                    'value' => $logticketevent->next_date,
	                    'pluginOptions' => [
	                        'format' => 'yyyy-MM-dd',
	                        'autoclose'=>true,
	                        'weekStart'=>1, //неделя начинается с понедельника
	                        'startDate' => '01.05.2015', //самая ранняя возможная дата
	                        'todayBtn'=>true, //снизу кнопка "сегодня"
	                    ]
	                ])->label('Дата следующего действия'); ?>
	     
	        <?= $form->field($modelevent, 'next_date_description')->textarea(['value' => $logticketevent->next_date_description])->label('Описание следующего действия') ?>
	     
	        <div class="form-group">
	            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
	    		<?= Html::a('Назад', ['/logticket/view', 'logticket_id' => $logticketevent->logTicket->id], ['class'=>'btn btn-primary']) ?>
	        </div>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
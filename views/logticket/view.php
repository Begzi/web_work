<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Обращение №' . $logticket->id . ": " . $logticket->topic;
// $this->params['breadcrumbs'][] = $this->title;

?>
<script>
    function logticket_description_edit_open(){
        $(".logticket_description_show_mode").hide();
        $(".logticket_description_edit_mode").show();
    }

    function logticket_description_edit_cancel() {
        $(".logticket_description_edit_mode").hide();
        $(".logticket_description_show_mode").show();
    }

    function kbase_chosen(){
        document.getElementById('kbase_model').value =  $('#kbase_select_list option:selected').val();
    }

</script>

        <h1><?= Html::encode($this->title) ?></h1>
    <div class="navbar_button">
        <?= Html::a('Назад', ['/logticket/index'], ['class'=>'btn btn-primary']) ?>

        <div class="pull-right">
            <?php if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
                <?= Html::a('Редактировать данные', ['/logticket/edit', 'logticket_id' => $logticket->id], ['class'=>'btn btn-primary']) ?>        
            <?php endif;?>
        </div>

    </div>
<br>      
<br>      
    <?php 
    
        $temp_uz;
        if ($logticket->uz_id == NULL)
        {
            $temp_uz = 'Отсутствует';
        }
        else {
            $temp_uz = $logticket->uz->uztype->name;
        }
        $temp_contact;
        if ($logticket->contact == NULL)
        {
            $temp_contact = 'Отсутствует';
        }
        else 
        {
            $temp_contact = $logticket->contact->contactPosition->name;
            if ($logticket->contact->name != NULL)
            {
                $temp_contact = $temp_contact . ' - ' . $logticket->contact->name;
            }
            if ($logticket->contact->m_tel != NULL)
            {
                $temp_contact = $temp_contact . ' - ' . $logticket->contact->m_tel;
            }
            elseif ($logticket->contact->w_tel != NULL)
            {
                $temp_contact = $temp_contact . ' - ' . $logticket->contact->w_tel;
            }
        }
    ?>
    <div class="row" id="logticket_status_panel">

        <div class="col-xs-6">
            <?php 

                $temp_status;
                switch ($logticket->status) 
                {
                    case 1:
                        $temp_status = "В работе";
                        echo('<div class="panel panel-primary mw-100" style="width: 100%;">');
                        break;
                    case 2:
                        $temp_status = "Завершен";
                        echo('<div class="panel panel-success mw-100" style="width: 100%;">');
                        break;
                    default:
                        $temp_status = "Не указан";         
                }    ?>
                <div class="panel-heading">Статус: <?php echo $temp_status; ?></div>                                       
                <div class="panel-body  mh-100" style="height: 100%;">
                            <h5>Узел:
                            <?php if ($temp_uz == 'Отсутствует'):?>
                                Отсутствует                            
                            <?php else:?>
                                <?= Html::a( $temp_uz, ["/uz/view", "id" => $logticket->uz_id ]) ?>
                            <?php endif;?> 
                            </h5>
                            <h5>Контакт: <?php echo $temp_contact;?></h5>
                            <h5>Приоритет: <?php echo $logticket->logTicketPriority->name;?></h5>
                            <h5>Краткое наименование учреждения: <?php echo $logticket->customer->shortname;?></h5>
                            <h5>Ответственный: <?php echo $logticket->user->name; ?></h5>
                            <h5>Ссылка на базу знаний: 
                            <?php if ($logticket->kbase_link == 0):?>
                                Отсутствует                            
                            <?php else:?>
                                <?= Html::a('Знание № ' . $logticket->kbase_link, ["/kbase/view", "id" => $logticket->kbase->id ]) ?>
                            <?php endif;?> 
                        <?= Html::a('<span class="glyphicon glyphicon-pencil">', ['/logticket/kbaseconnect', 'logticket_id' => $logticket->id], ['class'=>'btn btn-default']) ?>


                            </h5>
                </div>  
            </div>                                  
        </div>      
        <div class="col-xs-6">
        <?php $form = ActiveForm::begin(['id' => 'description-form']); ?>
            <div class="panel panel-info mw-100">
                    <div class="panel-heading">Примечания
                                    <div class="logticket_description_edit_mode pull-right" hidden>
                                         <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'logticket-description-button', 'title' => 'Сохранить']) ?>
                                        <button type="button" class="btn btn-xs" OnClick="logticket_description_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                    <div class="logticket_description_show_mode pull-right">
                                         <button type="button" class="btn btn-xs" OnClick="logticket_description_edit_open();" title = "Редактировать" id="logticket_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                    </div>
                    </div>
                    <div class="panel-body">
                        <div class="logticket_description_show_mode" style="word-wrap:break-word;">
                            <p type="text" id="logticket_description">
                                <?
                                if ($logticket->description == NULL){
                                    echo ('Примечания отсутствуют.');
                                }
                                else {
                                    echo ($logticket->description);
                                }
                                ?>
                            </p>
                        </div>
                        <div class="form-group logticket_description_edit_mode" style="word-wrap:break-word;" hidden>
                            <p type="text" id="logticket_description">
                            <?
                            if ($logticket->description == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                echo ($logticket->description);
                            }
                            $text = preg_replace( "#<br />#", "\n", $logticket->description );
                            $logticket->description = $text;
                            // при вводе примечания не выводились и знак следующей строки!
                            ?>
                        </p>
                        <?= $form->field($model, 'description')->textarea(['class' => "form-control",
                            'style'=>"resize:vertical",
                            'value'=>$logticket->description
                            ])->label('');?>
                        </div>  
                    </div>
            </div>
        <?php ActiveForm::end(); ?>
        </div> 
    </div>  

    <?php if ($logticket->status != 2):?>


<?php
    Modal::begin([
        'header' => '<h2>Добавление события</h2>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-plus"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);
?>
    <?php $form = ActiveForm::begin(['id' => 'logticketevent-form']); ?>
 
     
        <?= $form->field($modelevent, 'text_description')->textarea()->label('Описание события') ?>
     
        <?= $form->field($modelevent, 'next_date')->widget(DatePicker::className(),[
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
                ])->label('Дата следующего действия'); ?>
     
        <?= $form->field($modelevent, 'next_date_description')->textarea()->label('Описание следующего действия') ?>
     
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
 
    <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php
    Modal::begin([
        'header' => '<h2>Завершение события</h2>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-ok">',
            'tag' => 'button',
            'class' => 'btn btn-success',
            'title' => 'Завершить событие'
        ],
    ]);
?>
    <?php $form = ActiveForm::begin(['id' => 'logticketevent-form']); ?>
 
     
        <?= $form->field($model, 'solution_time')->textinput()->label('Время затраченное на обращение(мин)') ?>
     
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
 
    <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>


    <?php endif;?>     

    <?php if ($logticket->logTicketEvent==NULL):?>
                <br><div class="alert alert-info" role="alert" align="center" >Отсутствуют записи о ходе решения.</div>
               
    <?php else :?>
                <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>                               
                                    <th>Дата события</th>
                                    <th>Описание события</th>                                                              
                                    <th>Ответственный</th>
                                    <th>Дата следующего обращения</th>
                                    <th>Описание следующего обращения</th> 

                                     <?php if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
                                        <th>Редактировать собиытие</th> 
                                    <?php endif;?>
                                </tr>
                            </thead>
                            <tbody> 
                            <?php for ($i = 0; $i < count($logticket->logTicketEvent); $i++){
                                                            echo('
                                                                <tr>                                                
                                                                    <td>'.strftime( '%d %B %Y',strtotime($logticket->logTicketEvent[$i]->reg_date)).'</td>
                                                                    <td>'.$logticket->logTicketEvent[$i]->text_description.'</td>                                              
                                                                    <td>'.$logticket->logTicketEvent[$i]->user->name.'</td> 
                                                                ');
                                                                if (strtotime($logticket->logTicketEvent[$i]->next_date) > 0){
                                                                    echo ('<td>'.strftime( '%d %B %Y',strtotime($logticket->logTicketEvent[$i]->next_date)).'</td>');
                                                                }
                                                                else {
                                                                    echo ('<td>Отсутствует</td>');
                                                                }
                                                                if ($logticket->logTicketEvent[$i]->next_date_description != NULL) {
                                                                    echo ('<td>'.$logticket->logTicketEvent[$i]->next_date_description.'</td>');
                                                                }
                                                                else {
                                                                    echo ('<td>Отсутствует</td>');
                                                                }
                                                                echo ("<td width=5%>");
                                                                if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
                                                                    
                                                                   <?= Html::a('<span class="glyphicon glyphicon-pencil">', ['/logticket/editevent', 'logticketevent_id' => $logticket->logTicketEvent[$i]->id], ['class'=>'btn btn-default']);?>
                                                                <?php endif;
                                                                echo ("</td>");
                                                            echo('          
                                                                </tr>
                                                            ');
                            }
                            ?>

                            </tbody>
                    </table>
                 </div>          
            </div>

    <?php endif;?> 

                       
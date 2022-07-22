
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\LogTicketForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактирование обращения';
$priority = ['Низкое', "Среднее", "Высокое"]
?>


<script>
    function logticket_uz_chosen()
    {
        document.getElementById('logticket-uz_id').value =  $('#uz_select_list option:selected').val();
    }
    function logticket_contact_chosen()
    {
        document.getElementById('logticket-contact_id').value =  $('#contact_select_list option:selected').val();
    }
</script>


    <div class="container">
                <?php $form = ActiveForm::begin(['id' => 'logticket-form']); ?>


						<div>
                                	<label for="uz_id" class="form-control-label">Узлы: </label><br>
	                                <select data-placeholder="Выберите узел"  class="chosen-select" id="uz_select_list" name="uz_select_list"  OnChange = 'logticket_uz_chosen();' style="width:100%">
	                                    <option value=""></option>
	                                    <?       
	                                    $k = count($customer_uzs);   
	                                    for ($i=0;$i<$k;$i++)
	                                    {


		                                        if (($logticket->uz_id) == ($customer_uzs[$i]->id)) 
		                                        {

	                                        		echo ('<option value="'.$customer_uzs[$i]->id.'" title = "Добавить"  selected = "selected">'.$customer_uzs[$i]->uztype->name. ' - '.count($customer_uzs[$i]->logTickets).' Обращений'.'</option>');

		                                        }
		                                        else
		                                        {
	                                        		echo ('<option value="'.$customer_uzs[$i]->id.'" title = "Добавить">'.$customer_uzs[$i]->id.' - '.$customer_uzs[$i]->uztype->name. ' - '.count($customer_uzs[$i]->logTickets).' Обращений'.'</option>');
		                                        }
	                                    }   //в титл пихаем инфу про адрес и тд                                
	                                    ?>
	                                </select>                             
	                    </div><br>

                    <div>
                                <label for="contact_id" class="form-control-label">Контакты: </label><br>
                                <select data-placeholder="Выберите узел"  class="chosen-select" id="contact_select_list" name="contact_select_list"  OnChange = 'logticket_contact_chosen();' style="width:100%">
                                    <option value=""></option>
                                    <?       
                                    $k = count($customer_contacts);   
                                    for ($i=0;$i<$k;$i++)
                                    {						                

					                    $tmp_contact = $customer_contacts[$i]->id . ' - ' . $customer_contacts[$i]->contactPosition->name;
					                    if ($customer_contacts[$i]->name != NULL)
					                    {
					                        $tmp_contact = $tmp_contact . ' - ' . $customer_contacts[$i]->name;
					                    }
					                    if ($customer_contacts[$i]->m_tel != NULL)
					                    {
					                        $tmp_contact = $tmp_contact . ' - ' . $customer_contacts[$i]->m_tel;
					                    }
					                    elseif ($customer_contacts[$i]->w_tel != NULL)
					                    {
					                        $tmp_contact = $tmp_contact . ' - ' . $customer_contacts[$i]->w_tel;
					                    }

		                                if (($logticket->contact_id) == ($customer_contacts[$i]->id)) 
		                                {

	                                    	echo ('<option value="'.$customer_contacts[$i]->id.'" title = "Добавить"  selected = "selected">' . $tmp_contact . '</option>');

		                                }
		                                else
		                                {
	                                    	echo ('<option value="'.$customer_contacts[$i]->id.'" title = "Добавить">'.$tmp_contact.'</option>');
		                                }  
		                            }                           
                                    ?>
                                </select>                             
                    </div><br>


	                <?= $form->field($model, 'priority')
	                    ->dropDownList($priority)->label('Приоритет<font color="f33810">*</font>');?>

	                <?= $form->field($model, 'type')
	                    ->dropDownList( $logtickettype, ['id' => 'asdasd'])->label('Тип обращения<font color="f33810">*</font>');?>

	                <?= $form->field($model, 'topic')->textInput([ 'id' => 'logticket-topic-text', 'value' => $logticket->topic])->label('Заголовок обращения<font color="f33810">*</font>') ?>

	                <div class="form-group">
	                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'logticket-add-button', 'id' => 'logticket-add-button']) ?>
	                    <?= Html::a('Отмена', ['/logticket/view', 'logticket_id' => $logticket->id], ['class'=>'btn btn-primary']) ?>

	                </div>

	                <?= $form->field($model, 'uz_id')->textInput(['id' => 'logticket-uz_id', 'style' => 'visibility: hidden'])->label('') ?>

	                <?= $form->field($model, 'contact_id')->textInput(['id' => 'logticket-contact_id', 'style' => 'visibility: hidden'])->label('') ?>

                <?php ActiveForm::end(); ?>

    </div>
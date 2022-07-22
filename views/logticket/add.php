<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\LogTicketForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новое обращение';
$priority = ['Низкий', "Средний", "Высокий"]
?>


<script>
    function logticket_customer_chosen()
    {
        document.getElementById('logticket-customer_name').value =  $('#customer_select_list option:selected').val();
        document.getElementById('logticket-topic-text').value =  'tmp';
        $('#logticket-add-button').click();
    }
    function logticket_uz_chosen()
    {
        document.getElementById('logticket-uz_id').value =  $('#uz_select_list option:selected').val();
    }
    function logticket_contact_chosen()
    {
        document.getElementById('logticket-contact_id').value =  $('#contact_select_list option:selected').val();
    }
    function add_button_clicked()
    {
        if (document.getElementById('logticket-customer_name').value == ''  )
        {
            $('.show_click').append('<div class="alert alert-danger">Заказчик не выбран!</div>');
        }
    }
</script>
    <div class="container">
    <div class="logticket_add">
        <h1><?= Html::encode($this->title) ?></h1>


        <?php if (Yii::$app->session->hasFlash('ForgetCumstomerPicked')): ?>

            <div class="alert alert-danger">
                Заказчик не выбран!
            </div>
        <?php endif; ?>
        <div class = 'show_click'>

        </div>
        <div class="row">
            <div class="col-lg-5">
                

                <?php $form = ActiveForm::begin(['id' => 'logticket-form']); ?>


                <div>
                                <label for="customer_id" class="form-control-label">Учреждение: <font color="f33810">*</font></label><br>
                                <select data-placeholder="Выберите заказчика"  class="chosen-select" id="customer_select_list" name="customer_select_list" required  OnChange = 'logticket_customer_chosen();' style="width:100%" >
                                    <option value=""></option>
                                    <?       
                                    $k = count($customers);   
                                    for ($i=0;$i<$k;$i++){
                                        $customer_id_selected = strstr($customers[$i], ' - ', true);

                                        if (Yii::$app->session->hasFlash('ChooseUz') and ($customer_id_selected) == ($customer_id)) {
                                            echo ('<option value="'.$customer_id_selected.'" selected = "selected">'.$customers[$i].'</option>');

                                        }
                                        else{
                                            echo ('<option value="'.$customer_id_selected.'">'.$customers[$i].'</option>');
                                        }
                                    }                                   
                                    ?>
                                </select>                             
                </div><br>
                 <?php 
                 if (Yii::$app->session->hasFlash('ChooseUz')): ?>

                    <div>
                                <label for="uz_id" class="form-control-label">Узлы: </label><br>
                                <select data-placeholder="Выберите узел"  class="chosen-select" id="uz_select_list" name="uz_select_list"  OnChange = 'logticket_uz_chosen();' style="width:100%">
                                    <option value=""></option>
                                    <?       
                                    $k = count($customer_uz);   
                                    for ($i=0;$i<$k;$i++){
                                        $customer_uz_selected = strstr($customer_uz[$i], ' - ', true);
                                        echo ('<option value="'.$customer_uz_selected.'" title = "Добавить">'.$customer_uz[$i].'</option>');
                                    }   //в титл пихаем инфу про адрес и тд                                
                                    ?>
                                </select>                             
                    </div><br>

                    <div>
                                <label for="contact_id" class="form-control-label">Контакты: </label><br>
                                <select data-placeholder="Выберите контакт"  class="chosen-select" id="contact_select_list" name="contact_select_list"  OnChange = 'logticket_contact_chosen();' style="width:100%">
                                    <option value=""></option>
                                    <?       
                                    $k = count($customer_contact);   
                                    for ($i=0;$i<$k;$i++){
                                        $customer_contact_selected = strstr($customer_contact[$i], ' - ', true);
                                        echo ('<option value="'.$customer_contact_selected.'" title = "Добавить">'.$customer_contact[$i].'</option>');
                                    }   //в титл пихаем инфу про адрес и тд                                
                                    ?>
                                </select>                             
                    </div><br>
                <?php endif; ?>

                <?= $form->field($model, 'priority')
                    ->dropDownList($priority)->label('Приоритет<font color="f33810">*</font>');?>

                <?= $form->field($model, 'type')
                    ->dropDownList( $logtickettype, ['id' => 'asdasd'])->label('Тип обращения<font color="f33810">*</font>');?>

                <?= $form->field($model, 'topic')->textInput([ 'id' => 'logticket-topic-text'])->label('Заголовок обращения<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'description')->textArea()->label('Примечание') ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'logticket-add-button', 'id' => 'logticket-add-button', 'OnClick' => 'add_button_clicked()']) ?>
                    <?= Html::a('Отмена', ['/logticket/index'], ['class'=>'btn btn-primary']) ?>

                </div>

                <?= $form->field($model, 'customer_id')->textInput(['id' => 'logticket-customer_name', 'style' => 'visibility: hidden'])->label('') ?>

                <?= $form->field($model, 'uz_id')->textInput(['id' => 'logticket-uz_id', 'style' => 'visibility: hidden'])->label('') ?>

                <?= $form->field($model, 'contact_id')->textInput(['id' => 'logticket-contact_id' , 'style' => 'visibility: hidden'])->label('') ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
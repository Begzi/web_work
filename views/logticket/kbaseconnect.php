<?php 

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>                            
<script>
    function kbase_chosen(){
        document.getElementById('kbase_model').value =  $('#kbase_select_list option:selected').val();
    }

</script>







                                <div class="container">
    <?= Html::a('Назад', ['/logticket/view', 'logticket_id' => $logticket->id], ['class'=>'btn btn-primary']) ?>

                        <table class="table table-hover">
                            <thead>
                                <tr>                               
                                    <th>Дата события</th>
                                    <th>№ Обращения</th>  
                                    <th>Заголовок</th>  

                                </tr>

                            </thead>
                            <tbody> 
                                <tr>
                                    <th><?php echo $logticket->reg_date;?></th>
                                    <th><?php echo $logticket->id;?></th>
                                    <th><?php echo $logticket->topic;?></th>
                                </tr>
                            </tbody>
                   
                        </table>

                                    <div class="row">
                                    <?php $form = ActiveForm::begin(['id' => 'logticketkbase-form']); ?>

                                        <div class="col-lg-10">

                                        <label for="kbase_id_add" class="form-control-label">База знаний: <font color="f33810">*</font></label><br>
                                        <select data-placeholder="Выберите знание"  class="chosen-select" id="kbase_select_list" name="kbase_select_list" required  OnChange = 'kbase_chosen();' style="width:100%" >
                                            <option value=""></option>
                                            <?       
                                            $k = count($kbase);   
                                            for ($i=0;$i<$k;$i++){


                                                if (($logticket->kbase_link) == ($kbase[$i]->id)) {

                                                    echo ('<option value="'.$kbase[$i]->id.'" title = "Добавить"  selected = "selected">'.$kbase[$i]->id . ' - ' .$kbase[$i]->name.'</option>');

                                                }
                                                else{
                                                    echo ('<option value="'.$kbase[$i]->id.'" title = "Добавить">'.$kbase[$i]->id.' - '.$kbase[$i]->name.'</option>');
                                                }
                                                
                                            }                                   
                                            ?>
                                        </select>  
                                        </div>





                                        <?= $form->field($model, 'name') 
                                            ->textInput(['id' => 'kbase_model', 'style' => 'visibility: hidden'])->label(''); 
                                        ?>


                                        <div class="form-group">
                                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                        </div>
                                 
                                    <?php ActiveForm::end(); ?>

                                    </div>
                                </div>

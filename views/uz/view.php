<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Узел ' . $uz->id;
// $this->params['breadcrumbs'][] = $this->title;

$certuzs = $uz->certuzs;
?>
<script>
    function uz_description_edit_open(){
        $(".uz_description_show_mode").hide();
        $(".uz_description_edit_mode").show();
    }

    function uz_description_edit_cancel() {
        $(".uz_description_edit_mode").hide();
        $(".uz_description_show_mode").show();
    }

</script>
<div class="container">
    <h2><?php echo $uz->customer->shortname . ' узел: ' . $uz->id . '-' . $uz->uztype->name;?></h2>
 

    <?= Html::a('Назад', ['/customers/view', 'id' => $uz->customer->id], ['class'=>'btn btn-primary']) ?>
                  
<br>      
<br>      
<div class="container-fluid col-lg-12">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>                               
                                                <th>ID</th>
                                                <th>Номер сертификата</th>
                                                <th>Дата окончания</th>
                                                <th><span class="pull-right">Показать сертификат</span></th>
                                                <th><span class="pull-right">Редактировать сертификат</span></th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php for ($j = 0; $j < count($certuzs); $j++):?>
                                            <?php
                                            $cert = $certuzs[$j]->cert;?>
                                            <tr>
                                                <td style="width: 10%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php echo $cert->id;?>
                                                </td>
                                                <td style="width: 30%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php echo  $cert->num;?>
                                                </td>
                                                <td style="width: 30%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php echo $cert->ex_date;?>
                                                </td>
                                                <td style="width: 4%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <span class="pull-right">
                                                    <?= Html::a('<span class="glyphicon glyphicon-picture"></span>', ['scans/' . $uz->customer_id . '/' . $cert->sc_link, 'dir' => $dir.$file], ['class'=>'btn btn-default btn-xs','title' => "Показать"]); ?>
                                                    </span>
                                                </td>
                                                <td style="width: 4%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <span class="pull-right">
                                                    <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/cert/edit', 'id' => $cert->id], ['class'=>'btn btn-default btn-xs ', 'style' => 'color: green','title' => "Редактировать"]) ?>                                               
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <p></p>
<div class="col-md-12">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>                               
                                                <th>Обращение №</th>
                                                <th>Заголовок</th>
                                                <th>Дата обращения</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php for ($j = 0; $j < count($uz->logTickets); $j++):?>
                                            <tr>
                                                <td>
                                                    <?= Html::a( $uz->logTickets[$j]->id, ["/logticket/view", "logticket_id" => $uz->logTickets[$j]->id ]) ?>
                                                </td>
                                                <td>
                                                    <?php echo  $uz->logTickets[$j]->topic;?>
                                                </td>
                                                <td>
                                                    <?php echo $uz->logTickets[$j]->reg_date;?>
                                                </td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
  
</div>
</div>

              <p></p>


<div class="container-fluid col-lg-12">
        <div class="panel panel-default">
             <?php $form = ActiveForm::begin(['id' => 'uz-form']);?>
                <div class="panel-heading">Примечания
                                <div class="uz_description_edit_mode pull-right" hidden>
                                     <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'uz-description-button', 'title' => 'Сохранить']) ?>
                                    <button type="button" class="btn btn-xs" OnClick="uz_description_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                                <div class="uz_description_show_mode pull-right">
                                     <button type="button" class="btn btn-xs" OnClick="uz_description_edit_open();" title = "Редактировать" id="uz_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                </div>
                </div>
                <div class="panel-body">
                    <div class="uz_description_show_mode" style="word-wrap:break-word;">
                        <p type="text" id="uz_description">
                            <?
                            if ($uz->description == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                echo ($uz->description);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group uz_description_edit_mode" style="word-wrap:break-word;" hidden>
                        <p type="text" id="uz_description">
                        <?
                        if ($uz->description == NULL){
                            echo ('Примечания отсутствуют.');
                        }
                        else {
                            echo ($uz->description);
                        }
                        $text = preg_replace( "#<br />#", "\n", $uz->description );
                        $uz->description = $text;
                        // при вводе примечания не выводились и знак следующей строки!
                        ?>
                    </p>
                        <?= $form->field($model, 'description')->textarea(['class' => "form-control",
                        'style'=>"resize:vertical",
                        'value'=>$uz->description 
                        ])->label('');?>
                    </div>  
                </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
   
</div>

</div>

<?php
$this->title = 'ID заказчика: ' . $customer->id;
// $this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use app\models\CastomersForm;
use yii\bootstrap\ActiveForm;

//Лучше тут и индиекса кидать сам обьект, а не тольно её ИД и искать её в action



?>
<script>
    function customer_description_edit_open(){
        $(".customers_description_show_mode").hide();
        $(".customers_description_edit_mode").show();
        $(".customers_doc_edit_mode").hide();
        $(".customers_doc_show_mode").show();
    }

    function customer_description_edit_cancel() {
        $(".customers_description_edit_mode").hide();
        $(".customers_description_show_mode").show();
    }
    function customer_doc_edit_open(){
        $(".customers_doc_show_mode").hide();
        $(".customers_doc_edit_mode").show();
        $(".customers_description_edit_mode").hide();
        $(".customers_description_show_mode").show();
    }

    function customer_doc_edit_cancel() {
        $(".customers_doc_edit_mode").hide();
        $(".customers_doc_show_mode").show();
    }

</script>
<div class="container-fluid">
        <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
        <?= Html::a('Изменить данные заказчика', ['/customers/edit', 'id' => $customer->id], ['class'=>'btn btn-primary pull-right']) ?>
    <?php endif;?>
    <?php if (Yii::$app->user->can('logList', Yii::$app->user->id)):?>
                <?= Html::a('Журнал обращений', ['/logticket/searchfull', 'search' => $customer->shortname], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('Создать обращение', ['/logticket/add', 'customer_id' => $customer->id], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('Схема сети учреждения', ['/scheme/show', 'customer_id' => $customer->id], ['class'=>'btn btn-primary']) ?>
    <?php endif;?>

<br>
<br>
        <?php if (Yii::$app->session->hasFlash('HaveNotUzs')): ?>

            <div class="alert alert-danger">
                Нет узлов чтобы вводить сертификат. Сначала введите узлы!
            </div>
        <?php endif; ?>
    <div class="row" id="name_customer_panel">

        <div class="col-xs-6">
            <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">Полное наименование учреждения</div>
                <div class="panel-body">
                    <div class="normal_mode_labels">
                        <h3><?php echo $customer->fullname ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">Краткое наименование учреждения</div>
                <div class="panel-body">
                    <div class="normal_mode_labels">
                            <h4> <?php echo $customer->shortname ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="contact_panel">
        <div class="col-xs-12">
            <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">Контакты
                 <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['/contact/add', 'customer_id' => $customer->id], ['class'=>'btn btn-xs pull-right', 'title' => "Добавить"]) ?>                     
                 </div>
                <div class="panel-body">
                    <div class="normal_mode_labels">
                        <?php if ( $customer->contacts != NULL):?>
                            <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>                               
                                                <th>Должность</th>
                                                <th>ФИО</th>
                                                <th>Рабочий телефон</th>
                                                <th>Мобильный телефон</th>
                                                <th>E-mail</th>
                                                <th>Примечание</th>
                                                <th><span class="pull-right">Редактирование</span></th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                        <?php for ($i=0; $i < count($customer->contacts); $i++):?>       
                                
                                            <tr>
                                                <td>
                                                    <?php echo $customer->contacts[$i]->position?>
                                                </td>
                                                <td>
                                                   <?php echo $customer->contacts[$i]->name ?>
                                                </td>
                                                <td>
                                                    <?php echo $customer->contacts[$i]->w_tel?>
                                                </td>
                                                <td>
                                                    <?php echo $customer->contacts[$i]->m_tel?>
                                                </td>
                                                <td>
                                                    <?php echo $customer->contacts[$i]->mail?>
                                                </td>
                                                <td>
                                                    <?php if (strlen(strval($customer->contacts[$i]->description)) < 30){
                                                        echo $customer->contacts[$i]->description;
                                                    }
                                                    else{
                                                        echo 'Примечание больше 30 символов';
                                                    }?>
                                                </td>
                                                <td>
                                                    <div class="contact_edit_buttons pull-right">
                                                        <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/contact/edit', 'id' => $customer->contacts[$i]->id], ['class'=>'btn btn-xs', 'title' => "Редактировать"]) ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                            </div>          


                        <?php endif;?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="law_panel">
        <div class="col-xs-12">
            <div class="panel panel-info mw-100" style="width: 100%;">
                    <div class="panel-heading">Рекзвизиты</div>
                    <div class="panel-body">
                        <div class="normal_mode_labels">

                                <h4><span>Юридический адресс: <?php echo $customer->address ?></span></h4>
                                <h4><span>ИНН: <?php echo $customer->UHH ?></span></h4>
                                <h4><span>КПП: <?php echo $customer->CPP ?></span></h4>
                        </div>
                    </div>
            </div>
        </div>
    </div>

<?php $form = ActiveForm::begin(['id' => 'doc-form']); ?>
    <div class="row" id='doc_type_panel'>
        <div class="col-xs-12">

                    <div class="panel panel-info mw-100" style="width: 100%;">


                                <div class="panel-heading">
                                    Тип обмена документами
                                        <div class="customers_doc_show_mode pull-right" >
                                            <button type="button" class="btn btn-xs" OnClick="customer_doc_edit_open();" title = "Редактировать" id="customer_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>

                                        </div>
                                        <div class="form-group customers_doc_edit_mode pull-right" hidden>

                                                <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'customers-doc-button', 'title' => 'Сохранить']) ?>
                                                <button type="button" class="btn btn-xs" OnClick="customer_doc_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>

                                        </div>
                                </div>
                                <div class="panel-body">
                                    <div class="customers_doc_show_mode">                    
                                        <h4><span> <?php echo $customer->doctype->name ?></span></h4>
                                    </div>
                                    <div class="form-group customers_doc_edit_mode" hidden>
                                        
                                        <?= $form->field($model, 'doc_type_id')
                                            ->dropDownList([
                                                    '1' => 'Электронный',
                                                    '2' => 'Бумажный'], ['options'=>[$customer['doc_type_id']=>['Selected'=>true]]])->label('Тип обмена документами: ');
                                        ?>
                                    </div>
                                </div>
                        </div>
                </div>
    </div>
<?php ActiveForm::end(); ?>

    <div class="col-xs-12">

        <?= Html::a('Добавить узел', ['/uz/add', 'customer_id' => $customer->id], ['class'=>'btn btn-primary']) ?>

        <?= Html::a('Добавить сертификат', ['/cert/add', 'customer_id' => $customer->id], ['class'=>'btn btn-primary']) ?>
    </div>

        
    <br>
    <br>
<?php if ($realuzs != NULL):?>

<?php for ($k = 0; $k < count($realuzs); $k++):?>
    <div class="row" id="uz_accordian_panel" >
        <div class="col-xs-12" >

            <div class="normal_mode_labels">
                <button class="accordion">Узлов <?php echo    count($realuzs[$k]) .' '. $realuzs[$k][0]->uztype->name;?> 
                        <div class="alert-<?php 
                                        if ($date_check[$k] == 'У всех действующие сертификаты')
                                        {
                                            echo 'success';
                                        }
                                        elseif ($date_check[$k] == 'У всех нет действующих сертификатов') 
                                        {
                                            echo 'danger';
                                        }
                                        else
                                        {
                                            echo 'warning';
                                        }
                                    ?> pull-right" role="alert" align="center" >
                            <?php echo $date_check[$k]?>
                        </div>
                </button>

                    <div class="panel" id = "accordion-panel">

                        <!-- <div class="col-xs-8"> -->
                            <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>                               
                                                <th>ID</th>
                                                <th>Наименование</th>
                                                <th>№ сети</th>
                                                <th>Примечание</th>
                                                <th>Дата ввода в эксплуатацию</th>
                                                <th>Техподдержка</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php for ($i = 0; $i < count($realuzs[$k]); $i++):?>    
                                
                                            <tr>
                                                <td style="width: 4%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php echo $realuzs[$k][$i]->id?>
                                                </td>
                                                <td style="width: 18%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <a href="<?= \yii\helpers\Url::to(['/uz/view','id'=>$realuzs[$k][$i]->id])?>" >
                                                        <?php echo  $realuzs[$k][$i]->uztype->name ?>
                                                     </a>
                                                </td>
                                                <td style="width: 27%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php echo $realuzs[$k][$i]->uznet->num . ' ' . $realuzs[$k][$i]->uznet->name?>
                                                </td>
                                                <td style="width: 21%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <?php if (strlen(strval($realuzs[$k][$i]->description)) < 30){
                                                        echo $realuzs[$k][$i]->description;
                                                    }
                                                    else{
                                                        echo 'Примечание больше 30 символов';
                                                    }?>
                                                </td>
                                    <?php if ($realuzs[$k][$i]->supply_time == NULL or $realuzs[$k][$i]->supply_time == '1970-01-01'):?>
                                                    <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    </td>
                                    <?php else:?>

                                            <?php $base = date('Y-m-d', strtotime(''.$realuzs[$k][$i]->supply_ex_time));?>
                                            <?php if ($realuzs[$k][$i]->uztype->type == 1):?>
                                                    <?php if (strtotime($base) > strtotime(Yii::$app->formatter->asDate( time()))):?>
                                                        <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <div class="alert-success" role="alert" align="center" >
                                                                Базовая техподдержка до <?php echo strval($base);?>                                                    
                                                            </div>
                                                                
                                                        </td>
                                                    <?php else:?>
                                                        <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;"> 
                                                               
                                                        </td>
                                                    <?php endif;?>
                                            <?php else:?>
                                                        <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <div class="alert-default" role="alert" >
                                                                <?php echo strval($realuzs[$k][$i]->supply_time);?>          
                                                            </div>
                                                        </td>
                                            <?php endif;?>
                                        <?php endif;?>


                                                <?php if ($realuzs[$k][$i]->support_a == NULL):?>
                                                    <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                        <div class="alert-danger" role="alert" align="center" >
                                                            Отсутствует сертификат
                                                        </div>
                                                    </td>
                                                <?php else:?>
                                                    <?php if (strtotime(Yii::$app->formatter->asDate( $realuzs[$k][$i]->actualcert->ex_date)) > strtotime(Yii::$app->formatter->asDate( time()))):?>
                                                        
                                                        <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <div class="alert-success" role="alert" align="center" >
                                                                До <?php echo strval($realuzs[$k][$i]->actualcert->ex_date);?>                                                    
                                                            </div>
                                                                
                                                        </td>
                                                    <?php else:?>
                                                        <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;"> 
                                                            <div class="alert-danger" role="alert" align="center" >
                                                                Истекла <?php echo strval($realuzs[$k][$i]->actualcert->ex_date);?>                                                   
                                                            </div>
                                                                
                                                        </td>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                    <div class="contact_edit_buttons pull-right">
                                                        <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/uz/edit', 'id' => $realuzs[$k][$i]->id], ['class'=>'btn btn-xs ', 'style' => 'color: green']) ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                            </div> 
                    </div>
            </div>
        </div>
    </div>

<?php endfor;
endif;?>


<?php $form = ActiveForm::begin(['id' => 'description-form']); ?>
    <div class="container-fluid col-lg-12" style = "padding: 15px" id="description_panel">
        <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">Примечания
                                <div class="customers_description_edit_mode pull-right" hidden>
                                     <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'customers-description-button', 'title' => 'Сохранить']) ?>
                                    <button type="button" class="btn btn-xs" OnClick="customer_description_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                                <div class="customers_description_show_mode pull-right">
                                     <button type="button" class="btn btn-xs" OnClick="customer_description_edit_open();" title = "Редактировать" id="customer_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                </div>
                </div>
                <div class="panel-body">
                    <div class="customers_description_show_mode" style="word-wrap:break-word;">
                        <p type="text" id="customer_description">
                            <?
                            if ($customer->description == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                echo ($customer->description);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group customers_description_edit_mode" style="word-wrap:break-word;" hidden>
                        <p type="text" id="customer_description">
                        <?
                        if ($customer->description == NULL){
                            echo ('Примечания отсутствуют.');
                        }
                        else {
                            echo ($customer->description);
                        }
                        $text = preg_replace( "#<br />#", "\n", $customer->description );
                        $customer->description = $text;
                        // при вводе примечания не выводились и знак следующей строки!
                        ?>
                    </p>
                    <?= $form->field($model, 'description')->textarea(['class' => "form-control",
                        'style'=>"resize:vertical",
                        'value'=>$customer->description
                        ])->label('');?>
                    </div>  
                </div>
        </div>
    </div>    
 <?php ActiveForm::end(); ?>     


<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>



<!--<--------------'view' => function($url, $model)   {
                        return Html::a('<button class="btn btn-success">View &nbsp;<i class="glyphicon glyphicon-eye-open"></i></button>',$url);
                    },
                 'update' => function($url, $model) {
                        return Html::a('<button class="btn btn-primary">Update &nbsp;<i class="glyphicon glyphicon-pencil"></i></button>',$url);
                    },
                 'delete' => function($url, $model) {
                      return Html::a('<button class="btn btn-danger">Delete &nbsp;<i class="glyphicon glyphicon-trash"></i></button>', $url,
                             ['data-confirm' => 'Are you sure you want to delete this item?', 'data-method' =>'POST']
                          ); кнопки красивые ТУТЬ!

                           <span>
                        </span>----->
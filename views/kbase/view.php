 <?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;

function filesize_format($filesize)
{
    $formats = array('Б','КБ','МБ','ГБ','ТБ');// варианты размера файла
    $format = 0;// формат размера по-умолчанию
    
    // прогоняем цикл
    while ($filesize > 1024 && count($formats) != ++$format)
    {
        $filesize = round($filesize / 1024, 2);
    }
    
    // если число большое, мы выходим из цикла с
    // форматом превышающим максимальное значение
    // поэтому нужно добавить последний возможный
    // размер файла в массив еще раз
    $formats[] = 'ТБ';
    
    return $filesize.' '.$formats[$format];
}

$this->title = 'Знание ' . $kbase->id . ' ' . $kbase->name;
// $this->params['breadcrumbs'][] = $this->title;

?>
<script>
    function kbase_description_edit_open(){
        $(".kbase_description_show_mode").hide();
        $(".kbase_description_edit_mode").show();
        $(".kbase_solution_edit_mode").hide();
        $(".kbase_solution_show_mode").show();
    }

    function kbase_description_edit_cancel() {
        $(".kbase_description_edit_mode").hide();
        $(".kbase_description_show_mode").show();
    }
    function kbase_solution_edit_open(){
        $(".kbase_solution_show_mode").hide();
        $(".kbase_solution_edit_mode").show();
        $(".kbase_description_edit_mode").hide();
        $(".kbase_description_show_mode").show();
    }

    function kbase_solution_edit_cancel() {
        $(".kbase_solution_edit_mode").hide();
        $(".kbase_solution_show_mode").show();
    }

    function kbase_file_add(){
        $('.kbase_file_add_mode').show();
        for (var i = 0; i < (document.getElementById('kbase-file-add-input').files.length); i++){
            $('#here').append('<p><div"> <span>' + document.getElementById('kbase-file-add-input').files[i].name + ' </span></div></p>');
        }        
    }
    function kbase_file_added(){
        $('#kbase_file_add_mode').hide();
    }
    function kbase_solution_file_add() {
        for (var i = 0; i < (document.getElementById('kbase-solution-file-add-input').files.length); i++){
            $('#kbase-solution-file-check').append('<p><div> <span>' + document.getElementById('kbase-solution-file-add-input').files[i].name + ' </span></div></p>');
            document.getElementById('kbase-solution-textarea').value += ' ::SPIC::' + document.getElementById('kbase-solution-file-add-input').files[i].name+'::EPIC:: ';
        }
        $("#kbase-description-file-add-input").hide();
          
    }
    function kbase_description_file_add() {
        for (var i = 0; i < (document.getElementById('kbase-description-file-add-input').files.length); i++){
            $('#kbase-description-file-check').append('<p><div> <span>' + document.getElementById('kbase-description-file-add-input').files[i].name + ' </span></div></p>');
            document.getElementById('kbase-description-textarea').value += ' ::SPIC::' + document.getElementById('kbase-description-file-add-input').files[i].name+'::EPIC:: ';
        }
        $("#base-solution-file-add-input").hide();
    }
</script>

     

<div class= "col-lg-12" style="padding:15px">

        <h1><?= Html::encode($this->title) ?></h1>
    <div class="navbar_button col-lg-12">
        <?= Html::a('Назад', ['/kbase/index'], ['class'=>'btn btn-primary']) ?>

        <div class="pull-right">
            <?php if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
                <?= Html::a('Редактировать данные', ['/kbase/edit', 'id' => $kbase->id], ['class'=>'btn btn-primary']) ?>        
            <?php endif;?>
        </div>
    </div>

</div>

   
<div class="container-fluid col-lg-12">
    <?php $form = ActiveForm::begin(['id' => 'kbase-description-form']);?>
        <div class="panel panel-info mw-100" id = 'panel_kbase_description' style="width: 100%;">
                <div class="panel-heading">
                                    Примечания
                                <div class="kbase_description_edit_mode pull-right " hidden>
                                    <div class = 'col-lg-8'>

                                        <?= $form->field($model, 'sc_link[]')->fileInput([
                                                                            'multiple' => true, 
                                                                            'style' => 'display: none;', 
                                                                            'OnChange' => 'kbase_description_file_add()', 
                                                                            'id' => 'kbase-description-file-add-input',
                                                                            'accept'=>'.jpg, .jpeg, .png'
                                                                        ])->label('<span class="glyphicon glyphicon-paperclip"></span>'); ?> 
                                    </div> 
                                    <div class = 'col-lg-4'>

                                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'kbase-description-button', 'title' => 'Сохранить']) ?>
                                        <button type="button" class="btn btn-xs" OnClick="kbase_description_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                </div>
                                <div class="kbase_description_show_mode pull-right">
                                     <button type="button" class="btn btn-xs" OnClick="kbase_description_edit_open();" title = "Редактировать" id="kbase_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                </div>
                </div>
                <div class="panel-body">
                    <div class="kbase_description_show_mode" style="word-wrap:break-word;">
                        <p type="text" id="kbase_description_show">
                            <?
                            if ($kbase->description == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                $temp_description = preg_replace('/::SPIC::/', '<br><img src="files/'.$kbase->id.'/d/', $kbase->description);
                                $temp_description = preg_replace('/::EPIC::/', '" width="200" class="kbase_screenshot img-responsive" onMouseOver="this.style.width=\'auto\'" onmouseout="this.style.width=\'200px\';"></img><br>', $temp_description);
                                
                                echo ($temp_description);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group kbase_description_edit_mode" style="word-wrap:break-word;" hidden>
                        <p type="text" id="kbase_description_edit">
                            <?
                            if ($kbase->description == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                $temp_description = preg_replace('/::SPIC::/', '<br><img src="files/'.$kbase->id.'/d/', $kbase->description);
                                $temp_description = preg_replace('/::EPIC::/', '" width="200" class="kbase_screenshot img-responsive" onMouseOver="this.style.width=\'auto\'" onmouseout="this.style.width=\'200px\';"></img><br>', $temp_description);
                                
                                echo ($temp_description);

                            }
                            $text = preg_replace( "#<br />#", "\n", $kbase->description );
                            $kbase->description = $text;
                            // при вводе примечания не выводились и знак следующей строки!
                            ?>
                        </p>
                        <?= $form->field($model, 'description')->textarea(['class' => "form-control",
                        'style'=>"resize:vertical",
                        'value'=>$kbase->description,
                        'id'=>'kbase-description-textarea'
                        ])->label('');?>
                    </div>  
                </div>
        </div>
    <?php ActiveForm::end(); ?>

   
    <?php $form = ActiveForm::begin(['id' => 'kbase-solution-form']);?>
        <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">
                                    Решение
                                <div class="kbase_solution_edit_mode pull-right" hidden> 
                                    <div class = 'col-lg-8'>

                                     <?= $form->field($model, 'sc_link[]')->fileInput([
                                                                            'multiple' => true, 
                                                                            'style' => 'display: none;', 
                                                                            'OnChange' => 'kbase_solution_file_add()', 
                                                                            'id' => 'kbase-solution-file-add-input',
                                                                            'accept'=>'.jpg, .jpeg, .png'
                                                                        ])->label('<span class="glyphicon glyphicon-paperclip"></span>'); ?>  
                                    </div>
                                    <div class = 'col-lg-4'>

                                     <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'kbase-solution-button', 'title' => 'Сохранить']) ?>

                                    <button type="button" class="btn btn-xs" OnClick="kbase_solution_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                     </div>
                                </div>
                                <div class="kbase_solution_show_mode pull-right">
                                     <button type="button" class="btn btn-xs" OnClick="kbase_solution_edit_open();" title = "Редактировать" id="kbase_solution_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                </div>
                </div>
                <div class="panel-body">
                    <div class="kbase_solution_show_mode" style="word-wrap:break-word;">
                        <p type="text" id="kbase_solution_show">
                            <?
                            if ($kbase->solution == NULL){
                                echo ('Примечания отсутствуют.');
                            }
                            else {
                                $temp_solution = preg_replace('/::SPIC::/', '<br><img src="files/'.$kbase->id.'/s/', $kbase->solution);
                                $temp_solution = preg_replace('/::EPIC::/', '" width="200" class="kbase_screenshot img-responsive" onMouseOver="this.style.width=\'auto\'" onmouseout="this.style.width=\'200px\';"></img><br>', $temp_solution);
                                
                                echo ($temp_solution);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group kbase_solution_edit_mode" style="word-wrap:break-word;" hidden>
                        <p type="text" id="kbase_solution_edit">
                        <?
                        if ($kbase->solution == NULL){
                            echo ('Примечания отсутствуют.');
                        }
                        else {
                                $temp_solution = preg_replace('/::SPIC::/', '<br><img src="files/'.$kbase->id.'/s/', $kbase->solution);
                                $temp_solution = preg_replace('/::EPIC::/', '" width="200" class="kbase_screenshot img-responsive" onMouseOver="this.style.width=\'auto\'" onmouseout="this.style.width=\'200px\';"></img><br>', $temp_solution);
                                echo ($temp_solution);
                        }
                        $text = preg_replace( "#<br />#", "\n", $kbase->solution );
                        $kbase->solution = $text;
                        // при вводе примечания не выводились и знак следующей строки!
                        ?>
                    </p>
                        <?= $form->field($model, 'solution')->textarea(['class' => "form-control",
                        'style'=>"resize:vertical",
                        'value'=>$kbase->solution ,
                        'id'=>'kbase-solution-textarea'
                        ])->label('');?>

                        <div id = 'kbase-solution-file-check'></div>
                    </div>  
                </div>
        </div>
    <?php ActiveForm::end(); ?>




    <?php $form = ActiveForm::begin(['id' => 'kbase-file-form']);?>
                        <div class="panel panel-info mw-100 " style="width: 100%;">
                            <div class="panel-heading" id = 'here'>

                                Прикрепленные файлы:
                                <div class="pull-right">
                                    

                                            <?= $form->field($model, 'sc_link[]')->fileInput([
                                                        'multiple' => true, 
                                                        'style' => 'display: none; padding: 5px;', 
                                                        'OnChange' => 'kbase_file_add()', 
                                                        'id' => 'kbase-file-add-input',
                                                    ])->label('<span class="glyphicon glyphicon-paperclip" style="color:purple"></span>'); ?>  
                                        <?= $form->field($model, 'name')->textInput(['value'=>$kbase->name , 'style' => 'display: none;'])->label('') ?>
                                    
                                          
                                            
                                        <div class="kbase_file_add_mode "  hidden>

                                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'id' => 'kbase-file-add-button', 'OnClick' => 'kbase_file_added()']) ?>
                                            <p></p>
                                        </div>
                                               
                                    
                                </div>       
                            </div>                                      
                            <div class="panel-body  mh-100" style="height: 100%;">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>   
                                            <th>№</th>
                                            <th>Наименование</th>                                           
                                            <th>Размер</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>      


                        <?php $dir  = 'kbase/files/' . $kbase->id . '/f/';
                        //пропускаем точки
                        $skip = array('.', '..');
                        $files = scandir($dir);
                        $i=-2;
                        foreach($files as $file) :?>
                            
                            <?php 
                            $i++;
                            if (!in_array($file, $skip)):?>
                                
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $file;?></td>
                                    <td><?php echo filesize_format(filesize( $dir . $file));?></td>
                                    <td>

                                    <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span>', ['kbase/download', 'dir' => $dir.$file], ['class'=>'btn btn-default btn-xs','title' => "Скачать"]); ?>


                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['kbase/delete', 'dir' => $dir.$file], ['class'=>'btn btn-default btn-xs','title' => "Скачать"]); ?>

                                        <!-- <button class="btn btn-default btn-xs" OnClick="kbase_files_delete(\''.$dir.'\',\''.$file.'\');" title = "Удалить файл"><span class="glyphicon glyphicon-trash"></span></button> -->
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>           
                                    </tbody>
                                </table>                                                
                            </div>  
                        </div>
    <?php ActiveForm::end(); ?>
</div>
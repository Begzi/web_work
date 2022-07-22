   <?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = '30 дней';

function find_mails($contacts)
{
    for ($k = 0; $k < count($contacts); $k++)
    {
        for ($j = 0; $j < count($contacts); $j++)
        {
            if ($contacts[$k]->department > $contacts[$j]->department)
            {
                $tmp = $contacts[$k];
                $contacts[$k] = $contacts[$j];
                $contacts[$j] = $tmp;
            }
        }

    }
    $mail_array = Array();
    foreach ($contacts as $contact)
    {
        if ($contact->mail != NULL) //проверку на корректность почты тоже делатЬ!
        {
            $mail_array[$contact->mail] = $contact->mail;
        }
    }
    return $mail_array;
}
function find_uzs($certuzs, $fullname)
{    

    $uzs = Array();
    if ($certuzs != NULL)
    {
        for ($k = 0; $k < count($certuzs); $k++)//Можно обьеденить это всё
        {
            array_push($uzs, $certuzs[$k]->uz);
        }
        $uzs_text = '<br>';
        for ($k = 0; $k < count($uzs); $k++)
        {
            $uzs_text =  $uzs_text . $uzs[$k]->uztype->name . '<br>';
        }
    }
    $text = "Добрый день.<br>Общество с ограниченной ответственностью «ПИК Безопасности» информирует о том, что у " . $fullname . " истекает срок действия сертфиката технической поддержки ViPNet.<br>Предлагаем продлить техническую поддержку согласно следующей спецификации:". $uzs_text ."Дополнительную информацию можно получить по тел. (391) 989-78-00, e-mail:mail@pik-b.ru, официальный сайт: http://pik-b.ru.";
    $text = preg_replace( "#<br>#", "\n", $text );
    return $text;
}
function base_text($uz_name, $fullname)
{    

    $text = "Добрый день.<br>Общество с ограниченной ответственностью «ПИК Безопасности» информирует о том, что у " . $fullname . " истекает срок действия базовой гарантии на следующий узел: <br>". $uz_name ."<br>Предлагаем купить техническую поддержку.<br>Дополнительную информацию можно получить по тел. (391) 989-78-00, e-mail:mail@pik-b.ru, официальный сайт: http://pik-b.ru.";

    $text = preg_replace( "#<br>#", "\n", $text );
    return $text;
}
?>


<script type="text/javascript">
    function mail_gruop_added()
    {
        document.getElementById('next_step_id').append('asdasdasd');
    }
    function check_button(check)
    {
        var e = document.getElementById(check);
        var next_step = document.getElementById('next_step_id' + check);
        for (var i = 0; i < e.textContent; i++)
        {
            var k = check*10 + i;
            var tmp = 'mail_picked' + k;
            var asd = document.getElementById(tmp);
            next_step.value += ('***' + asd.options[asd.selectedIndex].text);

        }         
        next_step.value += ('***');  
        
    }
</script>



    <br>
<div class="container">
    <div class="pull-right">
        <?= Html::a('<span >Показать группы</span>', ['cert/groupshow'], ['class'=>'btn btn-primary', 'name' => 'group-show-btn', 'title' => 'Показать' ]) ?>
        
    </div>    
</div>



        <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="active">     
                        <th>Состояние</th> 
                        <th>ID Сертификата</th>                                                                                         
                        <th>№ сертификата</th>
                        <th>Количество узлов</th>
                        <th>Письмо отправленно сервисом</th>
                        <th>Дата окончания</th>
                        <th>Заказчик</th>
                    </tr>
                </thead>
                <tbody>             
                    <div>
                            <?php for ($i = 0; $i < count($cert_group); $i++):?>
                                <?php 
                                if ($cert_group[$i]->st_date == NULL)
                                {
                                            switch ($cert_group[$i]->state) {
                                                case 1:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "info";
                                                    break;
                                                case 2:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "info";
                                                    break;
                                                case 3:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "info";
                                                    break;
                                                case 4:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "info";
                                                    break;
                                                case 5:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "info";
                                                    break;
                                                case 6:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                case 7:
                                                    $temp_state = "Сертификат протух";
                                                    $temp_status = "danger";
                                                    break;
                                                case 8:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "danger";
                                                    break;
                                                case 9:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "danger";
                                                    break;
                                                case 10:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "danger";
                                                    break;
                                                case 11:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "danger";
                                                    break;
                                                case 12:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "danger";
                                                    break;
                                                case 13:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                default:
                                                    $temp_state = "Ничего не делали";   
                                                    $temp_status = "warning";          
                                            }

                                            $num = count($cert_group[$i]->cert) . ' Сертификата';

                                            if ($num < 10)
                                            {
                                                $cert_id = $cert_group[$i]->cert[0]->id;
                                                for ($j = 1; $j < $num; $j++)
                                                {
                                                    $cert_id = $cert_id . ', ' . $cert_group[$i]->cert[$j]->id;
                                                }
                                            }
                                            else
                                            {
                                                $cert_id = 'Много';
                                            }
                                            $uzs_count = 0;
                                            $tmp = 0;
                                            for ($j = 0; $j < $num; $j++)
                                            {
                                                $uzs_count = $uzs_count + count($cert_group[$i]->cert[$j]->certuzs);
                                                $tmp = $tmp + $cert_group[$i]->cert[$j]->mail->sended;
                                            }
                                            $ex_date = strftime( '%d.%m.%y',strtotime($cert_group[$i]->ex_date));
                                            $group_name = $cert_group[$i]->name;

                                            if ($tmp == $num)
                                            {
                                                $temp_sended = "Отправленно всем ";
                                            }
                                            elseif ($tmp == 0)
                                            {
                                                $temp_sended = "Никому не отправленно";                                                
                                            }
                                            else
                                            {
                                                $temp_sended = "Отправленно некоторым";                                                  
                                            }

                                            $id = $cert_group[$i]->id . ' - group' ;

                                }
                                else
                                {
                                            switch ($cert_group[$i]->mail->sended) {
                                                case 1:
                                                    $temp_sended = "Отправленно";
                                                    break;
                                                default:
                                                    $temp_sended = "Не Отправленно";           
                                            }
                                            switch ($cert_group[$i]->mail->state) {
                                                case 1:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "info";
                                                    break;
                                                case 2:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "info";
                                                    break;
                                                case 3:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "info";
                                                    break;
                                                case 4:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "info";
                                                    break;
                                                case 5:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "info";
                                                    break;
                                                case 6:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                case 7:
                                                    $temp_state = "Сертификат протух";
                                                    $temp_status = "danger";
                                                    break;
                                                case 8:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "danger";
                                                    break;
                                                case 9:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "danger";
                                                    break;
                                                case 10:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "danger";
                                                    break;
                                                case 11:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "danger";
                                                    break;
                                                case 12:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "danger";
                                                    break;
                                                case 13:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                default:
                                                    $temp_state = "Ничего не делали";   
                                                    $temp_status = "warning";         
                                            }

                                            $cert_id = $cert_group[$i]->id;
                                            $num = $cert_group[$i]->num;
                                            $uzs_count = count($cert_group[$i]->certuzs);
                                            $ex_date = strftime( '%d.%m.%y',strtotime($cert_group[$i]->ex_date));
                                            $customer_shortname = $cert_group[$i]->customer->shortname;
                                            $id = $cert_group[$i]->mail->id . ' - mail';
                                }           
                                ?>
                                            <tr class="<?php echo $temp_status; ?>">
                                                    <td style="width: 26%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                        <?php echo $temp_state;?>

 <?php   Modal::begin([
        'header' => '<h3>Этапы работы с серитфикатом</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);
?>
<?php
    $steps = ["Ничего не делали", "Письмо отправлено", "Вышли на человека, ответственного за продление ТП", "Сформировано КП или договор/счёт","Получена оплата", "Поставка прошла", "Отгружены закрывающие документы"];
 ?>
                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?php for($j = 0; $j < count($steps); $j++):?>
                    <?php if ($j <= array_search($temp_state, $steps)):?>
                        <p><strike><?php echo $steps[$j];?></strike></p>
                    <?php else:?>
                        <p><?php echo $steps[$j];?></p>
                    <?php endif;?>
                <?php endfor;?>
                <?php if ($temp_state != "Отгружены закрывающие документы"):?>
                    <div class="form-group">
                        <?= Html::submitButton('Следующий шаг', ['class' => 'btn btn-success', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>
                <?php 
                $modelcertgroupname->text = '';
                $modelcertgroupname->mail = 'e@mail.ru';?>
                <?= $form->field($modelcertgroupname, 'next_step')
                    ->textInput(['id' => 'next_step_id' , 'value' => $id , 'style' => 'visibility: hidden'])->label('');
                ?>



                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
                                                            </td>
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $cert_id;?></td>
                                                    <td style="width: 14%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $num;?></td>
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $uzs_count;?></td>                                                
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $temp_sended;?>
                                                        
                                                    <?php if ($cert_group[$i]->st_date == NULL):?>    
 <?php   Modal::begin([
        'header' => '<h3>Отправка письма</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-envelope"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);?>

                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

        <?php 
        $mail_check = true;
        $text = "Добрый день.\nОбщество с ограниченной ответственностью «ПИК Безопасности» информирует о том, что у НАЗВАНИЕУЧРЕЖДЕНИЯ истекает срок действия сертфиката технической поддержки ViPNet.\nПредлагаем продлить техническую поддержку согласно следующей спецификации:\nПОСТРОЧНОЕПЕРЕЧИСЛЕНИЕУЗЛОВУЧРЕЖДЕНИЯ\nДополнительную информацию можно получить по тел. (391) 989-78-00, e-mail:mail@pik-b.ru, официальный сайт: http://pik-b.ru.";
        // $text = preg_replace( "#<br>#", "\n", $text );
        for ($k = 0; $k < count($cert_group[$i]->cert); $k++):?>
             <?php 

                $mail_array = find_mails($cert_group[$i]->cert[$k]->customer->contacts);
                if ($mail_array != NULL)
                {
                    $mail_check = $mail_check * true;
                }
                else
                {
                    $mail_check = $mail_check * false;                    
                }
                $k_js = $k + $i*10;       

            ?>

                <?= $form->field($modelcertgroupname, 'mail')
                    ->dropDownList($mail_array, ['id' => 'mail_picked' . $k_js])->label('Почта ' . $cert_group[$i]->cert[$k]->customer->shortname . '<font color="f33810">*</font>');?>

        
        <?php endfor;?>

                <?= $form->field($modelcertgroupname, 'text')->textArea(['value' => $text, 'rows' => '10'])->label('Текст письма<font color="f33810">*</font>') ?>

                <?php if ($mail_check):?>
                    <div class="mail_send" id = 'mail_send'>
                        <?= Html::submitButton('Отправить пиьсмо', ['class' => 'btn btn-success', 'OnClick' => 'check_button('.$i.')', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>

                <?= $form->field($modelcertgroupname, 'next_step')
                    ->textInput(['id' => 'next_step_id' . $i, 'value' => $id . ' - mail::', 'style' => 'visibility: hidden'])->label('');
                ?>

                <div id="<?php echo $i;?>" style="visibility: hidden;"><?php echo count($cert_group[$i]->cert);?></div>

                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>    


                                                    <?php else:?>



 <?php   Modal::begin([
        'header' => '<h3>Отправка письма</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-envelope"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);?>
 <?php 

    $mail_array = find_mails($cert_group[$i]->customer->contacts);
    $text = find_uzs($cert_group[$i]->certuzs, $cert_group[$i]->customer->fullname);
                    

?>
                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?= $form->field($modelcertgroupname, 'mail')
                    ->dropDownList($mail_array, ['id' => 'mail_picked'])->label('Почта<font color="f33810">*</font>');?>

                <?= $form->field($modelcertgroupname, 'text')->textArea(['value' => $text, 'rows' => '10'])->label('Текст письма<font color="f33810">*</font>') ?>
                <?php if ($mail_array != NULL):?>
                    <div class="mail_send" id = 'mail_send'>
                        <?= Html::submitButton('Отправить пиьсмо', ['class' => 'btn btn-success', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>
                <?= $form->field($modelcertgroupname, 'next_step')
                    ->textInput(['id' => 'next_step_id' , 'value' => $id . ' - mail' , 'style' => 'visibility: hidden'])->label('');
                ?>



                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
                                                    <?php endif;?>  


                                                            </td>
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $ex_date ?>
                                                    <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">

                                                    <?php if ($cert_group[$i]->st_date == NULL):?>
                                                            <?= Html::a($group_name . '<br> Количество заказчиков: ' . count($cert_group[$i]->cert), ['/cert/grouponeshow', 'id' => $cert_group[$i]->id] ) ?></td> 
                                                    <?php else:?>
                                                            <?= Html::a($customer_shortname, ['/cert/searchfull', 'search' => $cert_group[$i]->id] ) ?></td> 
                                                    <?php endif;?>  
                                                    </td>                                                   
                                                </tr>


                            <?php endfor;?>
                    </div>
                </tbody>
            </table>


<!-- ТУТ БАЗОВАЯ ГАРАНТИЯ  ТУТ БАЗОВАЯ ГАРАНТИЯ  ТУТ БАЗОВАЯ ГАРАНТИЯ  ТУТ БАЗОВАЯ ГАРАНТИЯ  ТУТ БАЗОВАЯ ГАРАНТИЯ  ТУТ БАЗОВАЯ ГАРАНТИЯ -->
        <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="active">     
                        <th>Состояние</th> 
                        <th>ID узла</th>             
                        <th>Письмо отправленно сервисом</th>
                        <th>Дата окончания</th>
                        <th>Заказчик</th>
                    </tr>
                </thead>
                <tbody>             
                    <div>
                            <?php for ($i = 0; $i < count($uz); $i++):?>
                                <?php 
                                            switch ($uz[$i]->mailbase->sended) 
                                            {
                                                case 1:
                                                    $temp_sended = "Отправленно";
                                                    break;
                                                default:
                                                    $temp_sended = "Не Отправленно";           
                                            }
                                            switch ($uz[$i]->mailbase->state) 
                                            {
                                                case 1:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "info";
                                                    break;
                                                case 2:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "info";
                                                    break;
                                                case 3:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "info";
                                                    break;
                                                case 4:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "info";
                                                    break;
                                                case 5:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "info";
                                                    break;
                                                case 6:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                case 7:
                                                    $temp_state = "Гарантия кончилось";
                                                    $temp_status = "danger";
                                                    break;
                                                case 8:
                                                    $temp_state = "Письмо отправлено";
                                                    $temp_status = "danger";
                                                    break;
                                                case 9:
                                                    $temp_state = "Вышли на человека, ответственного за продление ТП";
                                                    $temp_status = "danger";
                                                    break;
                                                case 10:
                                                    $temp_state = "Сформировано КП или договор/счёт";
                                                    $temp_status = "danger";
                                                    break;
                                                case 11:
                                                    $temp_state = "Получена оплата";
                                                    $temp_status = "danger";
                                                    break;
                                                case 12:
                                                    $temp_state = "Поставка прошла";
                                                    $temp_status = "danger";
                                                    break;
                                                case 13:
                                                    $temp_state = "Отгружены закрывающие документы";
                                                    $temp_status = "success";
                                                    break;
                                                default:
                                                    $temp_state = "Ничего не делали";   
                                                    $temp_status = "warning";         
                                            }
                                            $id = $uz[$i]->mailbase->id . ' - mailbase';
                                          
                                ?>
                                            <tr class="<?php echo $temp_status; ?>">
                                                    <td style="width: 26%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                        <?php echo $temp_state;?>

 <?php   Modal::begin([
        'header' => '<h3>Этапы работы с серитфикатом</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-pencil"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);
?>
<?php
    $steps = ["Ничего не делали", "Письмо отправлено", "Вышли на человека, ответственного за продление ТП", "Сформировано КП или договор/счёт","Получена оплата", "Поставка прошла", "Отгружены закрывающие документы"];
 ?>
                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?php for($j = 0; $j < count($steps); $j++):?>
                    <?php if ($j <= array_search($temp_state, $steps)):?>
                        <p><strike><?php echo $steps[$j];?></strike></p>
                    <?php else:?>
                        <p><?php echo $steps[$j];?></p>
                    <?php endif;?>
                <?php endfor;?>
                <?php if ($temp_state != "Отгружены закрывающие документы"):?>
                    <div class="form-group">
                        <?= Html::submitButton('Следующий шаг', ['class' => 'btn btn-success', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>
                <?php 
                $modelcertgroupname->text = '';
                $modelcertgroupname->mail = 'e@mail.ru';?>
                <?= $form->field($modelcertgroupname, 'next_step')
                    ->textInput(['id' => 'next_step_id' , 'value' => $id , 'style' => 'visibility: hidden'])->label('');
                ?>



                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
                                                            </td>
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $uz[$i]->id;?></td>                                            
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $temp_sended;?>
                                                        



 <?php   Modal::begin([
        'header' => '<h3>Отправка письма</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-envelope"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить событие'
        ],
    ]);?>
 <?php 

    $mail_array = find_mails($uz[$i]->customer->contacts);
    $text = base_text($uz[$i]->uztype->name, $uz[$i]->customer->fullname);
                    

?>
                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?= $form->field($modelcertgroupname, 'mail')
                    ->dropDownList($mail_array, ['id' => 'mail_picked'])->label('Почта<font color="f33810">*</font>');?>

                <?= $form->field($modelcertgroupname, 'text')->textArea(['value' => $text, 'rows' => '10'])->label('Текст письма<font color="f33810">*</font>') ?>
                <?php if ($mail_array != NULL):?>
                    <div class="mail_send" id = 'mail_send'>
                        <?= Html::submitButton('Отправить пиьсмо', ['class' => 'btn btn-success', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>
                <?= $form->field($modelcertgroupname, 'next_step')
                    ->textInput(['id' => 'next_step_id' , 'value' => $id . ' - mailbase' , 'style' => 'visibility: hidden'])->label('');
                ?>



                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>


                                                            </td>
                                                    <td style="width: 9%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?php echo $uz[$i]->supply_ex_time ?>
                                                    <td style="width: 15%;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;">
                                                            <?= Html::a($uz[$i]->customer->shortname, ['/customers/view', 'search' => $uz[$i]->customer->id] ) ?></td> 
                                                     
                                                    </td>                                                   
                                                </tr>


                            <?php endfor;?>
                    </div>
                </tbody>
            </table>




<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;

$this->title = 'Сертификаты';

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
?>

 
<script>
    function search_option()
    {
        var text = document.getElementById('search_text');
        document.getElementById('search_text').value += '***' + document.getElementById('search_option').value;
        if (document.getElementById('search_option').value == 'По дате'){
            document.getElementById('search_text').value += '***' + document.getElementById('date_from').value + '***' + document.getElementById('date_end').value ;
        }
    }
    function log_choose_date(e) {
        
        if (document.getElementById('search_option').value == 'По дате'){
            $(".date").show();
        }
        else{
            $(".date").hide();

        }
    }

</script>

<section class="cert-area">
    <div class="container">
            <div class="col-md-12 col-md-4">

                <?php if (Yii::$app->session->hasFlash('groupOne')): ?>
                    <h4>
                        <?php echo 'Имя группы: ' . $certGroupName->name;?>    
                        <?= Html::a('<span class="glyphicon glyphicon-pencil" ></span>', ['cert/groupedit', 'group_id' => $certGroupName->id ], ['class'=>'btn btn-primary', 'name' => 'cert-groyp-edit-button', 'title' => 'Редактировать' ]) ?>
                        
                    </h4>      
                <?php else:?>
                <section class="box search">
                    <form method="get" onsubmit="search_option()"  action="<?= Url::to(['cert/searchfull']) ?>">
                        <input  id="search_text" type="text" class="text" name="search"  placeholder="Поиск" />
                        <?php  if ($searchfull != NULL):?>
                            <label type="text" class="text"><?php echo $searchfull;?></label>
                            <?= Html::a('<span class="glyphicon glyphicon-remove" style="color:black"></span>', ['cert/show','search'=> ''], ['class'=>'btn btn-xs', 'name' => 'cert-search-button', 'title' => 'Отмена']) ?>

                        <?php endif;?>
                    </form>
                </section>
                <input class="date" id="date_from" type="date" value="<?php echo  date('Y-m-d h:i', time()); ?>" hidden>
                <input class="date" id="date_end" type="date" value="<?php echo  date('Y-m-d h:i', time()); ?>" hidden>
                <?php endif;?>
            </div>

            <div class="col-md-12 col-md-4">
                <section class="box 30">

                    <?php if (Yii::$app->session->hasFlash('groupOne')): ?>   

                        <?= Html::a('<span >Показать группы</span>', ['cert/groupshow'], ['class'=>'btn btn-primary', 'name' => 'group-show-btn', 'title' => 'Показать' ]) ?>

                    <?php else:?>

                        <div class="col-xs-12 col-md-4">
                            <select class="search_option" id="search_option" onchange="log_choose_date()">
                              <option title="По умлочанию: Поиск по теме, и только одного первого найденного заказчика">По умлочанию</option>
                              <option title="Поиск по заказчикам">Заказчик</option>
                              <option title="Поиск по дате и заказчику">По дате</option>
                            </select>
                        </div>
                    <?php endif;?>
                </section>
            </div>

            <div class="col-md-12 col-md-4">
                <section class="box name">

                    <?php if (Yii::$app->session->hasFlash('groupOne')): ?>
                        <?php if (Yii::$app->session->hasFlash('search_all')): ?>
                        <?= Html::a('<span class="glyphicon glyphicon-search" > 30 дней</span>', ['cert/search30'], ['class'=>'btn btn-primary', 'name' => 'cert-search-30-button', 'title' => 'Показать' ]) ?>
                         <?php endif;?>
                        <?php if (Yii::$app->session->hasFlash('30clicked')): ?>
                            <?= Html::a('Все Сертификаты', ['cert/show','search'=> ''], ['class'=>'btn btn-primary', 'name' => 'cert-search-button', 'title' => 'Отмена']) ?>

                         <?php endif;?>

                   
                    <?php else:?>

                        <?php if (Yii::$app->session->hasFlash('search_all')): ?>
                        <?= Html::a('<span class="glyphicon glyphicon-search" > 30 дней</span>', ['cert/search30'], ['class'=>'btn btn-primary', 'name' => 'cert-search-30-button', 'title' => 'Показать' ]) ?>
                         <?php endif;?>

                        <?php if (Yii::$app->session->hasFlash('30clicked')): ?>
                            <?= Html::a('Все Сертификаты', ['cert/show','search'=> ''], ['class'=>'btn btn-primary', 'name' => 'cert-search-button', 'title' => 'Отмена']) ?>

                         <?php endif;?>

                        <?= Html::a('<span >Показать группы</span>', ['cert/groupshow'], ['class'=>'btn btn-primary', 'name' => 'group-show-btn', 'title' => 'Показать' ]) ?>
            


                    <?php endif;?>

        


                </section>
            </div>

    </div>
                  
<br>      
<br>      
<div class="container-fluid col-lg-12">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>                               
                                                <th>ID</th>
                                                <th>Краткое наименование учреждения</th>
                                                <th>Номер сертификата</th>
                                                <th>Дата окончания</th>
    <?php if ((Yii::$app->user->can('admin', Yii::$app->user->id)) or (Yii::$app->user->can('office', Yii::$app->user->id))):?>
                                                <td><span class="pull-right">Редактировать сертификат</span></td>
    <?php endif?>
                                                <th><span class="pull-right">Показать сертификат</span></th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                        <?php for ($j = 0; $j < count($cert); $j++):?>
                                            <tr>
                                                <td>
                                                    <?php echo $cert[$j]->id;?>
                                                </td>
                                                <td>

                                                  <a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $cert[$j]->customer->id])?>">
                                                      <span >
                                                          <?php echo $cert[$j]->customer->shortname;?>
                                                      </span>
                                                  </a>
                                                </td>
                                                <td>
                                                    <?php echo  $cert[$j]->num;?>
                                                </td>
                                                <td>
                                                    <?php echo $cert[$j]->ex_date;?>
                                                </td>
                                                    
                                            <?php if ((Yii::$app->user->can('admin', Yii::$app->user->id)) or (Yii::$app->user->can('office', Yii::$app->user->id))):?>
                                                <td>
                                                    <span class="pull-right"> 
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['/cert/edit', 'id' => $cert[$j]->id], ['class'=>'btn btn-default btn-xs','title' => "Редактировать"]); ?>     
                                                    </span>
                                                </td>     
                                             <?php endif?>
                                                <td>
                                            <?php if (Yii::$app->session->hasFlash('groupOneEnding')):// Если сертификат кончается ?>
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

    $mail_array = find_mails($cert[$j]->customer->contacts);
    $text = find_uzs($cert[$j]->certuzs, $cert[$j]->customer->fullname);
                    

?>
                <?php $form = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?= $form->field($modelcert, 'mail')
                    ->dropDownList($mail_array, ['id' => 'mail_picked'])->label('Почта<font color="f33810">*</font>');?>

                <?= $form->field($modelcert, 'text')->textArea(['value' => $text, 'rows' => '10'])->label('Текст письма<font color="f33810">*</font>') ?>
                <?php if ($mail_array != NULL):?>
                    <div class="mail_send" id = 'mail_send'>
                        <?= Html::submitButton('Отправить пиьсмо', ['class' => 'btn btn-success', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                    </div>
                <?php endif;?>
                <?= $form->field($modelcert, 'next_step')
                    ->textInput(['id' => 'next_step_id' , 'value' => $cert[$j]->mail->id . ' - mail', 'style' => 'visibility: hidden'])->label('');
                ?>



                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

                                            <?php endif;?>

                                                    <span class="pull-right">
                                                    <?= Html::a('<span class="glyphicon glyphicon-picture"></span>', ['scans/' . $cert[$j]->customer_id . '/' . $cert[$j]->sc_link, 'dir' => $dir.$file], ['class'=>'btn btn-default btn-xs','title' => "Показать"]); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <p></p>

              <p></p>

</div>
    <div class="container">
        <div class="pegination">
            <div class="nav-links">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'lastPageLabel' => true,
                    'firstPageLabel' => true,
                ])?>
            </div>
        </div>
    </div>
</section>

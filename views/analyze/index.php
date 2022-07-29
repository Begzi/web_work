<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
$this->title = 'Заказчики';
 ?>
 <script type="text/javascript">

    function search_option() {
        console.log(document.getElementById('search_option').value);
        if (document.getElementById('search_option').value == 'Заказчики'){
            document.getElementById('customer_option').hidden = false;
            document.getElementById('uz_option').hidden = true;
            document.getElementById('search_uz_4').hidden = true;
            document.getElementById('search_uz_5').hidden = true;
            document.getElementById('search_uz_6').hidden = true;
            document.getElementById('date_from').hidden = true;
            document.getElementById('date_end').hidden = true;
        }
        else if (document.getElementById('search_option').value == 'Узлы'){
            document.getElementById('customer_option').hidden = true;
            document.getElementById('uz_option').hidden = false;
            document.getElementById('search_uz_4').hidden = true;
            document.getElementById('search_uz_5').hidden = true;
            document.getElementById('search_uz_6').hidden = true;
            document.getElementById('date_from').hidden = true;
            document.getElementById('date_end').hidden = true;
        }
        else{
            document.getElementById('customer_option').hidden = true;
            document.getElementById('uz_option').hidden = true;
            document.getElementById('search_uz_4').hidden = true;
            document.getElementById('search_uz_5').hidden = true;
            document.getElementById('search_uz_6').hidden = true;
            document.getElementById('date_from').hidden = true;
            document.getElementById('date_end').hidden = true;
        }
    }
    function search_option_uz(name){
        console.log(name)
        if (name == 'search_uz_1' || name == 'search_customer_2'){
            if (document.getElementById(name).value == 'Номер сети'){
                document.getElementById('search_uz_4').hidden = false;
            }
            else{
                document.getElementById('search_uz_4').hidden = true;

            }
        }
        else if (name == 'search_uz_2' || name == 'search_customer_3'){
            if (document.getElementById(name).value == 'Тип узла'){
                document.getElementById('search_uz_5').hidden = false;
                document.getElementById('search_uz_6').hidden = true;
            }
            else if (document.getElementById(name).value == 'Категория типа узла'){
                document.getElementById('search_uz_5').hidden = true;
                document.getElementById('search_uz_6').hidden = false;
            }
            else{
                document.getElementById('search_uz_5').hidden = true;
                document.getElementById('search_uz_6').hidden = true;
                $("#search_uz_6").hide();
            }
        }
        else if (name == 'search_uz_3'  || name == 'search_customer_4'){
            if (document.getElementById(name).value == 'По дате'){
                document.getElementById('date_from').hidden = false;
                document.getElementById('date_end').hidden = false;
            }
            else{
                document.getElementById('date_from').hidden = true;
                document.getElementById('date_end').hidden = true;

            }
        }
    }


    function search_button(){
        var form = document.getElementById('search_form');
        var text = document.getElementById('search_text');
        document.getElementById('search_text').value += document.getElementById('search_option').value;      
        console.log( document.getElementById('search_text').value ) ;
        var ar = $('.search_option_1'); 
        for (var i = 0; i < (ar.length); i++){
            if (ar[i].parentElement.parentElement.hidden == false){
                document.getElementById('search_text').value += '***' + ar[i].value; 
            }
        }

        ar = $('.search_option_2'); 
        for (var i = 0; i < (ar.length); i++){
            if (ar[i].hidden == false){
                document.getElementById('search_text').value += '***' + ar[i].value; 
            }
        }
        ar = $('.date');
        for (var i = 0; i < (ar.length); i++){
            if (ar[i].hidden == false){
                document.getElementById('search_text').value += '***' + ar[i].value; 
            }
        }
        console.log( document.getElementById('search_text').value)


        form.submit();
    }
</script>

<section class="customers-area">
    <div class="container">
            <div class="col-md-12 col-md-4">
               
                <section class="box search">
                    <form method="get" id="search_form"  class="search_form" action="<?= Url::to(['analyze/index']) ?>" hidden>
                        <input  id="search_text" type="text" class="search_text" name="search"  placeholder="Поиск" hidden />
                                           
                    </form>
                    <button id="search_button"  onclick="search_button()" class="search_button" name="search" value="Поиск"  >Поиск</button>
                    <?php if ($search!=NULL):?>
                        <label type="text" class="text" ><?php echo $search;?></label>
                        <?= Html::a('<span class="glyphicon glyphicon-remove" style="color:black" ></span>', ['analyze/index','search'=> ''], ['class'=>'btn btn-xs', 'name' => 'cert-search-button', 'title' => 'Отмена']) ?>
                    <?php endif?>
                </section>
                   
                <input class="date" id="date_from" type="date" value="<?php echo  date('Y-m-d', time()); ?>" hidden>
                <input class="date" id="date_end" type="date" value="<?php echo  date('Y-m-d', time()); ?>" hidden>
            </div>

        <div class="col-xs-12 col-md-4">

            <div class="col-xs-12 col-md-4">
                <select class="search_option" id="search_option" onchange="search_option()">
                  <option title="Заказчики">Пустота</option>
                  <option title="Заказчики">Заказчики</option>
                  <option title="Узлы">Узлы</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-4 search_option_customer" id="customer_option" style="padding-left: 50px" hidden>
                <div class="row">
                    <select class="search_option_customer_1 search_option_1" id="search_customer_1">
                      <option title="Заказчики">Пустота</option>
                       <?php foreach ($group_customer as $gr):?>
                            <option value="<?php echo $gr->id; ?>"><?php echo $gr->name; ?></option>
                        <?php endforeach;?>
                    </select>  
                    <select class="search_option_customer_1 search_option_1" id="search_customer_2"
                     onchange ="search_option_uz('search_customer_2')">
                      <option>Пустота</option>
                      <option title="Номер сети узла">Номер сети</option>
                    </select>
                    <select class="search_option_customer_1 search_option_1" id="search_customer_3" 
                    onchange="search_option_uz('search_customer_3')">
                      <option>Пустота</option>
                      <option title="Какой VipNet">Тип узла</option>
                      <option title="Аппаратное или ПО">Категория типа узла</option>
                    </select>
                    <select class="search_option_customer_1 search_option_1" id="search_customer_4" 
                    onchange="search_option_uz('search_customer_4')">
                      <option title="Заказчики">Все узлы</option>
                      <option title="Узлы с актуальным сертификатом">Узлы с тех поддержкой</option>
                      <option title="Узлы у который актуальный сертификат истёк">Узлы без тех поддержки</option>
                     
                    </select>   
                        
                </div>
            </div>
            <div class="col-xs-12 col-md-4 search_option_uz" id="uz_option"  style="padding-left: 50px" hidden>
                <div class="row">
                     <select class="search_option_uz_1 search_option_1" id="search_uz_1" onchange="search_option_uz('search_uz_1')">
                      <option>Пустота</option>
                      <option title="Номер сети узла">Номер сети</option>
                    </select>
                    <select class="search_option_uz_1 search_option_1" id="search_uz_2" onchange="search_option_uz('search_uz_2')">
                      <option>Пустота</option>
                      <option title="Какой VipNet">Тип узла</option>
                      <option title="Аппаратное или ПО">Категория типа узла</option>
                    </select>
                    <select class="search_option_uz_1 search_option_1" id="search_uz_3" onchange="search_option_uz('search_uz_3')">
                      <option title="Заказчики">Все узлы</option>
                      <option title="Узлы с актуальным сертификатом">Узлы с тех поддержкой</option>
                      <option title="Узлы у который актуальный сертификат истёк">Узлы без тех поддержки</option>
                    </select>                     
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-4">

            <div class="col-xs-12 col-md-4">
                <div class="row">
                    <select class="search_option_uz_2 search_option_2" id="search_uz_4" onchange="search_option_uz('search_uz_4')" hidden>
                        <?php foreach ($net as $n):?>
                            <option value="<?php echo $n->id; ?>"><?php echo $n->name . "(" . $n->num . ")"; ?></option>
                        <?php endforeach;?>
                    </select>                        
                    <select class="search_option_uz_2 search_option_2" id="search_uz_5" onchange="search_option_uz('search_uz_5')" hidden>
                        <?php foreach ($type as $t):?>
                            <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                        <?php endforeach;?>
                    </select>                        

                    <select class="search_option_uz_2 search_option_2" id="search_uz_6" onchange="search_option_uz('search_uz_6')" hidden>
                        <?php foreach ($typecategoria as $t):?>
                            <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                        <?php endforeach;?>
                    </select>                        
                    
                </div>

            </div>
        </div>
        <br>
        <hr>

        <br>
        <br>
        <br>
        <br>

        <?php if (Yii::$app->session->hasFlash('Customer')): ?>
            

                <div class="col-xs-12 col-md-8">
                        <span class="inline-1">Полное наименование учреждения</span>
                </div>

                <div class="col-xs-6 col-md-4">
                        <span class="inline-2">Краткое наименование учреждения</span>
                </div>
            <?php for ($i = 0; $i < count($customers); $i++):?>
                <div class="col-xs-12 col-md-8">
                     <div class="single-customer-fullname">

                          <h4>
                                  <span >
                                       <?php 
                                       echo ($i + 1 ) + 15 * ($pages->page  );
                                        ?>
                                  </span>
                              <a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $customers[$i]->id])?>">
                                  <span >
                                      <?php echo $customers[$i]->fullname ?>
                                  </span>
                              </a>
                          </h4>

                     </div>
                </div>
                <div class="col-xs-12 col-md-4">
                     <div class="single-customer-shortname">
                         <h4>
                             <p>
                                 <span>
                                     <?php echo $customers[$i]->shortname ?>
                                 </span>
                             </p>
                         </h4>
                     </div>
                </div>
            <?php endfor; ?>            
        <?endif?>

        <?php if (Yii::$app->session->hasFlash('Uz')): ?>                
                <div class="col-xs-12 col-md-8">
                        <span class="inline-1">Полное наименование учреждения</span>
                </div>

                <div class="col-xs-6 col-md-4">
                        <span class="inline-2">Краткое наименование учреждения</span>
                </div>
            <?php for ($i = 0; $i < count($customers); $i++):?>
                <div class="col-xs-12 col-md-8">
                     <div class="single-customer-fullname">

                          <h4>
                                  <span >
                                       <?php 
                                       echo ($i + 1 ) + 15 * ($pages->page  );
                                        ?>
                                  </span>
                              <a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $customers[$i]->customer->id])?>">
                                  <span >
                                      <?php echo $customers[$i]->customer->fullname . ' - id узла ' . $customers[$i]->id?>
                                  </span>
                              </a>
                          </h4>

                     </div>
                </div>
                <div class="col-xs-12 col-md-4">
                     <div class="single-customer-shortname">
                         <h4>
                             <p>
                                 <span>
                                     <?php echo $customers[$i]->customer->shortname ?>
                                 </span>
                             </p>
                         </h4>
                     </div>
                </div>
            <?php endfor; ?> 
        <?php endif ?>


    <?php if (Yii::$app->session->hasFlash('TechWithoutPoint')):?>
    <?php else: ?>
        <div class="pegination">
            <div class="nav-links">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'lastPageLabel' => true,
                    'firstPageLabel' => true,
                ])?>
            </div>
        </div>
    <?php endif?>
    </div>
</section>
<br>
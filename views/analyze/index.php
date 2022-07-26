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
            $(".search_option_customer").show();
            $(".search_option_uz").hide();
            $(".search_option_cert").hide();
        }
        else if (document.getElementById('search_option').value == 'Узлы'){
            $(".search_option_customer").hide();
            $(".search_option_uz").show();
            $(".search_option_cert").hide();
        }
        else if (document.getElementById('search_option').value == 'Сертификаты'){
            $(".search_option_uz").hide();
            $(".search_option_customer").hide();
            $(".search_option_cert").show();
        }
        else{
            $(".search_option_customer").hide();
            $(".search_option_uz").hide();
            $(".search_option_cert").hide();  
        }
    }
    function search_option_uz(name){
        if (name == 'search_uz_1'){
            if (document.getElementById(name).value == 'Номер сети'){
                $(".div_search_option_uz_2").show();
                $("#search_uz_4").show();
            }
            else{
                $("#search_uz_4").hide();

            }
        }
        else if (name == 'search_uz_2'){
            if (document.getElementById(name).value == 'Тип узла'){
                $(".div_search_option_uz_2").show();
                $("#search_uz_5").show();
                $("#search_uz_6").hide();
            }
            else if (document.getElementById(name).value == 'Категория типа узла'){
                $(".div_search_option_uz_2").show();
                $("#search_uz_5").hide();
                $("#search_uz_6").show();
            }
            else{
                $("#search_uz_5").hide();
                $("#search_uz_6").hide();
                $("#search_uz_56").hide();
            }
        }
        else if (name = 'search_uz_3'){
            if (document.getElementById(name).value == 'По дате'){
                $(".date").show();
            }
            else{
                $(".date").hide();

            }
        }
    }
    function search_submit()
    {
        var text = document.getElementById('search_text');
        document.getElementById('search_text').value += '***' + document.getElementById('search_option').value;
        if (document.getElementById('search_option').value == 'По дате'){
            document.getElementById('search_text').value += '***' + document.getElementById('date_from').value + '***' + document.getElementById('date_end').value ;
        }
    }

</script>

<section class="customers-area">
    <div class="container">
            <div class="col-md-12 col-md-4">
                <section class="box search">
                    <form method="get" onsubmit="search_submit()" action="<?= Url::to(['customers/searchfull']) ?>">
                        <input type="text" class="text" name="search" placeholder="Поиск" />
                        <?php  if ($searchfull != NULL):?>
                            <label type="text" class="text"><?php echo $searchfull;?></label>
                            <?= Html::a('<span class="glyphicon glyphicon-remove" style="color:black"></span>', ['customers/searchfull','search'=> ''], ['class'=>'btn btn-xs', 'name' => 'customers-search-button', 'title' => 'Cancel']) ?>

                        <?php endif;?>
                    </form>
                </section>
                <input class="date" id="date_from" type="date" value="<?php echo  date('Y-m-d h:i', time()); ?>" hidden>
                <input class="date" id="date_end" type="date" value="<?php echo  date('Y-m-d h:i', time()); ?>" hidden>
            </div>

        <div class="col-xs-12 col-md-4">

            <div class="col-xs-12 col-md-4">
                <select class="search_option" id="search_option" onchange="search_option()">
                  <option title="Заказчики">Пустота</option>
                  <option title="Заказчики">Заказчики</option>
                  <option title="Узлы">Узлы</option>
                  <option title="Сертификаты">Сертификаты</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-4 search_option_customer" id="customer_option" style="padding-left: 50px" hidden>
                <div class="row">
                    <select class="search_option_customer_1" id="search_customer_1" onchange="search_option_customer('search_option_customer_1')">
                      <option title="Заказчики">Пустота</option>
                      <option title="Заказчики">Заказчики</option>
                      <option title="Узлы">Узлы</option>
                      <option title="Сертификаты">Сертификаты</option>
                    </select>
                    <select class="search_option_customer_1" id="search_customer_2" onchange="search_option_customer('search_option_customer_2')">
                      <option title="Заказчики">Пустота</option>
                      <option title="Заказчики">Заказчики</option>
                      <option title="Узлы">Узлы</option>
                      <option title="Сертификаты">Сертификаты</option>
                    </select>
                    <select class="search_option_customer_1" id="search_customer_3" onchange="search_option_customer('search_option_customer_3')">
                      <option title="Заказчики">Пустота</option>
                      <option title="Заказчики">Заказчики</option>
                      <option title="Узлы">Узлы</option>
                      <option title="Сертификаты">Сертификаты</option>
                    </select>
                        
                </div>
            </div>
            <div class="col-xs-12 col-md-4 search_option_uz" id="uz_option"  style="padding-left: 50px" hidden>
                <div class="row">
                    <select class="search_option_uz_1" id="search_uz_1" onchange="search_option_uz('search_uz_1')">
                      <option>Пустота</option>
                      <option title="Номер сети узла">Номер сети</option>
                    </select>
                    <select class="search_option_uz_1" id="search_uz_2" onchange="search_option_uz('search_uz_2')">
                      <option>Пустота</option>
                      <option title="Какой VipNet">Тип узла</option>
                      <option title="Аппаратное или ПО">Категория типа узла</option>
                    </select>
                    <select class="search_option_uz_1" id="search_uz_3" onchange="search_option_uz('search_uz_3')">
                      <option title="Заказчики">Все узлы</option>
                      <option title="Узлы с актуальным сертификатом">Узлы с тех поддержкой</option>
                      <option title="Узлы у который актуальный сертификат истёк">Узлы без тех поддержки</option>
                      <option title="По дате окончания тех поддержки">По дате</option>
                    </select>                    
                </div>
            </div>
            <div class="col-xs-12 col-md-4 search_option_cert" id="cert_option"  style="padding-left: 50px" hidden>
                <select class="search_option_cert_1" id="search_cert_1" onchange="search_option3()">
                  <option title="Заказчики">Сертификаты</option>
                  <option title="Узлы">Узлы</option>
                  <option title="Сертификаты">Сертификаты</option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-md-4">

            <div class="col-xs-12 col-md-4">
                <div class="row">
                    <div class="div_search_option_uz_2" id="div_search_uz_4" hidden>
                        <select class="search_option_uz_2" id="search_uz_4" onchange="search_option_uz('search_uz_4')" hidden>
                            <?php foreach ($net as $n):?>
                                <option value="<?php echo $n->id; ?>"><?php echo $n->name . "(" . $n->num . ")"; ?></option>
                            <?php endforeach;?>
                        </select>                        
                    </div>
                    <div class="div_search_option_uz_2" id="div_search_uz_56" hidden>
                        <select class="search_option_uz_2" id="search_uz_5" onchange="search_option_uz('search_uz_5')" hidden>
                            <?php foreach ($type as $t):?>
                                <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                            <?php endforeach;?>
                        </select>                        

                        <select class="search_option_uz_2" id="search_uz_6" onchange="search_option_uz('search_uz_6')" hidden>
                            <?php foreach ($typecategoria as $t):?>
                                <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                            <?php endforeach;?>
                        </select>                        
                    </div>

                    
                </div>

            </div>
        </div>
        <br>
        <hr>

        <div class="col-xs-12 col-md-8">
                <span class="inline-1">Полное наименование учреждения</span>
        </div>

        <div class="col-xs-6 col-md-4">
                <span class="inline-2">Краткое наименование учреждения</span>

    <!--        </div>-->
        </div>
    <!--        <div class="col-md-12">-->
    <?php for ($i = 0; $i < count($customers); $i++):?>
        <div class="col-xs-12 col-md-8">
             <div class="single-customer-fullname">

                  <h4>
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
<!--        </div>-->
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
<br>
<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
$this->title = 'Тикет';
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
        	$(".search_text").hide();
        	$(".search_button").show();
    	}
    	else{
        	$(".date").hide();
        	$(".search_text").show();
        	$(".search_button").hide();

    	}
    }
    function search_button(){
    	var form = document.getElementById('search_form');
    	console.log(document.getElementById('search_form'));
    	search_option();
    	form.submit();
    }
</script>
<section class="ticket-area">
    <div class="container">
            <div class="col-md-12 col-md-4">
                <section class="box search" >
                    <form method="get" onsubmit="search_option()" id="search_form" action="<?= Url::to(['logticket/searchfull']) ?>">
                        <input id="search_text" type="text" class="search_text" name="search" placeholder="Поиск" />
                        
                        <?php  if ($searchfull != NULL):?>
                            <label type="text" class="text"><?php echo $searchfull;?></label>
                            <?= Html::a('<span class="glyphicon glyphicon-remove" style="color:black"></span>', ['logticket/index','search'=> ''], ['class'=>'btn btn-xs', 'name' => 'customers-search-button', 'title' => 'Cancel']) ?>

                        <?php endif;?>
                    </form>
                    <button id="search_button"  onclick="search_button()" class="search_button" name="search" value="Поиск"  hidden>Поиск</button>
                </section>
                <input class="date" id="date_from" type="date" value="<?php echo  date('Y-m-d', time()); ?>" hidden>
                <input class="date" id="date_end" type="date" value="<?php echo  date('Y-m-d', time()); ?>" hidden>
            </div>

        <div class="col-xs-12 col-md-4">
            <select class="search_option" id="search_option" onchange="log_choose_date()">
			  <option title="По умлочанию: Поиск по теме, только одного заказчика, Владельца">По умлочанию</option>
			  <option title="Поиск по заказчикам">Заказчик</option>
			  <option title="Поиск по категории">Категория</option>
			  <option title="Поиск по приоиртету">Приоритет</option>
			  <option title="Поиск по событию">Последний ответ</option>
			  <option title="Поиск по дате">По дате</option>
			</select>
        </div>

        <div class="col-xs-12 col-md-4">

            <?= Html::a('Добавить', ['/logticket/add', 'customer_id' => 0], ['class'=>'btn btn-primary']) ?>

        </div>
    </div>
        <br>
        <hr>
			<table class="table table-bordered">
				<thead>
					<tr class="active">																								
						<th>Тема</th>
						<th>ID</th>
						<th>Заявка от</th>
						<th>Владелец</th>
						<th>Дата</th>
						<th>Категория</th>
						<th>Приоритет</th> 
						<th>Последний ответ</th>
						<th>Состояние</th>	
					</tr>
				</thead>
				<tbody>				
					<div>
									<? for ( $i = 0; $i < count($logticket); $i++ ):?>	
										<?php 
											
											//Условие для окраса строки таблицы в зависимости от статуса обращения
											switch ($logticket[$i]->status) {
												case 1:
													$temp_status = "info";
													break;
												case 2:
													$temp_status = "success";
													break;
												default:
													$temp_status = "warning";			
											}
											//Условие для 0 значения описания последней записи состояния
											if (($logticket[$i]->logTicketEvent) == NULL) { 
												$temp_description = 'Отсутствует'; 
											}
											else { 
												$temp_description = $logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->text_description; 
											}
											
											//Условие для 0 значения даты последней записи состояния
											if ($logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->reg_date > 0) { 
												$temp_description_date = '['.date( 'd.m.y H:i',strtotime($logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->reg_date)).'] '; 
											}
											else { 
												$temp_description_date = ''; 
											}											
											
											//Условие для 0 значения описания следующего действия состояния
											if (($logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->next_date_description) == NULL) { 
												$temp_description_next_date_description = 'В работе'; 
											}
											else { 
												$temp_description_next_date_description = $logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->next_date_description;
											}	
											if ($logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->next_date > 0) { 
												$temp_description_next_date = '['.date( 'd.m.y H:i',strtotime($logticket[$i]->logTicketEvent[count($logticket[$i]->logTicketEvent) - 1]->next_date)).'] '; 
											}
											else { 
												$temp_description_next_date = ''; 
											}
											
											
											//Условие для 0 значения категории
											if ($logticket[$i]->type == 0) { 
												$temp_type = 'Не указана'; 
											}
											else { 
												$temp_type = $logticket[$i]->logTicketType->name; 
											}
											
											//Условие для 0 значения времени, затраченного на решение
											if ($logticket[$i]->solution_time == 0) { 
												$temp_solution_time = 'Не указано'; 
											}
											else { 
												$temp_solution_time = ''.floor($logticket[$i]->solution_time/60).' ч. '.($logticket[$i]->solution_time%60).' мин.'; 
											}?>	
											<tr class="<?php echo $temp_status; ?>">
													<td style="max-width: 100px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?= Html::a($logticket[$i]->topic, ['/logticket/view', 'logticket_id' => $logticket[$i]->id] ) ?></td>
													<td style="width: 20px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php echo $logticket[$i]->id?></td>
													<td style="max-width: 100px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php if ($logticket[$i]->child_customer == NULL):?>
																<a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $logticket[$i]->customer->id])?>" >
																	<?php echo $logticket[$i]->customer->shortname; ?>
																</a>
															<?php else:?>
																<a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $logticket[$i]->customerChild->id])?>" >
																		<?php echo $logticket[$i]->customerChild->shortname; ?>
																	</a>
															<?php endif?>

													</td>
													<td style="width: 140px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php echo $logticket[$i]->user->name; ?></td>													
													<td style="width: 50px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php echo strftime( '%d.%m.%y',strtotime($logticket[$i]->reg_date)); ?>
														</td>
													<td style="width: 100px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php echo $temp_type ?></td>
													<td style="width: 100px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
															<?php echo  $logticket[$i]->logTicketPriority->name; ?></td>				
													<td style="max-width: 100px;
														overflow: hidden;
														text-overflow: ellipsis;
														white-space: nowrap;">
														<?php echo $temp_description_date . $temp_description ?></td>
													<td style="width: 20%;
														overflow: hidden;
														text-overflow: ellipsis;
														">
														<?php 
														if ($logticket[$i]->status == 1) { 
															echo $temp_description_next_date.''.$temp_description_next_date_description; 
														}
														else { 
															echo $temp_solution_time; 
														}		
											?>
													</td>													
												</tr>
									<?php endfor;?>
					</div>
				</tbody>
			</table>
<!--        </div>-->
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
<br>
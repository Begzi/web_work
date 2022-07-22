
<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
$this->title = 'Группы сертификатов';
 ?>


<section class="cert-area">
    <div class="container">
            <div class="col-md-12 col-md-4">
            </div>

            <div class="col-md-12 col-md-4">
            </div>
            <div class="col-md-12 col-md-4">
                <section class="box 30">

                    <?= Html::a('<span class="glyphicon glyphicon-search" > 30 дней</span>', ['cert/search30'], ['class'=>'btn btn-primary', 'name' => 'cert-search-30-button', 'title' => 'Показать' ]) ?>

                    <?= Html::a('Все Сертификаты', ['cert/show','search'=> ''], ['class'=>'btn btn-primary', 'name' => 'cert-search-button', 'title' => 'Отмена']) ?>

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
                                                <th>Имя группы</th>
                                                <th>Количество сертификатов</th>
                                                <th>Дата окончания</th>
                                                <th><span class="pull-right">Редактировать группу</span></th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php for ($j = 0; $j < count($cert_group); $j++):?>
                                            <tr>
                                                <td>
                                                    <?php echo $cert_group[$j]->id;?>
                                                </td>
                                                <td>

                      <a href="<?= \yii\helpers\Url::to(['/cert/grouponeshow','id' => $cert_group[$j]->id])?>">
                          <span >
                              <?php echo $cert_group[$j]->name;?>
                          </span>
                      </a>
                                                </td>
                                                <td>
                                                    <?php echo  count($cert_group[$j]->cert);?>
                                                </td>
                                                <td>
                                                    <?php echo $cert_group[$j]->ex_date;?>
                                                </td>
                                                <td>
                                                    <span class="pull-right">
                                                       
                    <?= Html::a('<span class="glyphicon glyphicon-pencil" ></span>', ['cert/groupedit', 'group_id' => $cert_group[$j]->id ], ['class'=>'btn btn-primary', 'name' => 'cert-groyp-edit-button', 'title' => 'Редактировать' ]) ?>

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

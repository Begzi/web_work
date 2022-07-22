
<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
$this->title = 'Группа сертификата';
 ?>


<section class="cert-area">
    <div class="container">

        <div class="col-lg-4">
            <?= Html::a('<span >Показать группы</span>', ['cert/groupshow'], ['class'=>'btn btn-primary', 'name' => 'group-show-btn', 'title' => 'Показать' ]) ?>
        </div>
                 
        <div class="col-lg-4">
<?php
    Modal::begin([
        'header' => '<h2>Изменить имя группы</h2>',
        'toggleButton' => [
            'label' => 'Изменить имя группы',
            'tag' => 'button',
            'class' => 'btn btn-primary pull-right',
            'title' => 'Удалить контакт'
        ],
    ]);
?>   

        <?php $form = ActiveForm::begin(['id' => 'uz-list-form']); ?>


        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'value' => $group_name])->label('Номер сертификата<font color="f33810">*</font>')  ?>

        

        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'uzs-add-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

<?php Modal::end(); ?>           
        </div>

        <div class="col-lg-4">
<?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить группу?</h2>',
        'toggleButton' => [
            'label' => 'Удалить группу',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить контакт'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/cert/certgroupdelete', 'group_id' => $group_id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?> 
        </div>
             
    </div> 
    <div class="container-fluid col-lg-12">

        <div class="col-lg-6">
            <h3>Актуальные сертификаты:</h3>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>                               
                                                    <th>ID</th>
                                                    <th>Наименование учреждения</th>
                                                    <th>Дата окончания</th>
                                                    <th><span class="pull-right">Редактировать группу</span></th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php for ($j = 0; $j < count($cert); $j++):?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cert[$j]->id;?>
                                                    </td>
                                                    <td>

                          <a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $cert[$j]->customer_id])?>">
                              <span >
                                  <?php echo $cert[$j]->customer->shortname;?>
                              </span>
                          </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $cert[$j]->ex_date;?>
                                                    </td>
                                                    <td>
                                                        <span class="pull-right">
                                                           
                        <?= Html::a('<span class="glyphicon glyphicon-plus" ></span>', ['cert/groupeditplus', 'cert_id' => $cert[$j]->id , 'group_id' => $group_id], ['class'=>'btn btn-success', 'name' => 'cert-groyp-edit-button', 'title' => 'Редактировать' ]) ?>

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

            <div class="pegination">
                <div class="nav-links">
                    <?php echo \yii\widgets\LinkPager::widget([
                        'id' => 'first',
                        'pagination' => $pages,
                        'lastPageLabel' => true,
                        'firstPageLabel' => true,
                    ])?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h3>Сертификаты в группе:</h3>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>                               
                                                    <th>ID</th>
                                                    <th>Наименование учреждения</th>
                                                    <th>Дата окончания</th>
                                                    <th><span class="pull-right">Редактировать группу</span></th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php for ($j = 0; $j < count($cert1); $j++):?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cert1[$j]->id;?>
                                                    </td>
                                                    <td>

                          <a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $cert1[$j]->customer_id])?>">
                              <span >
                                  <?php echo $cert1[$j]->customer->shortname;?>
                              </span>
                          </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $cert1[$j]->ex_date;?>
                                                    </td>
                                                    <td>
                                                        <span class="pull-right">
                                                           
                        <?= Html::a('<span class="glyphicon glyphicon-minus" ></span>', ['cert/groupeditminus', 'cert_id' => $cert1[$j]->id, 'group_id' => $group_id], ['class'=>'btn btn-danger', 'name' => 'cert-groyp-edit-button', 'title' => 'Редактировать' ]) ?>

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

            <div class="pegination">
                <div class="nav-links">
                    <?php echo \yii\widgets\LinkPager::widget([
                        'id' => 'second',
                        'pagination' => $pages1,
                        'lastPageLabel' => true,
                        'firstPageLabel' => true,
                    ])?>
                </div>
            </div>
        </div>
    </div>


</section>

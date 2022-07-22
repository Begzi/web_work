<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Пользователь';


?>
 

                  
<div class="container-fluid col-lg-12">
    <div class="container">
        <h3><?php echo strval(Yii::$app->user->identity->name);?></h3>

        <?php if (Yii::$app->session->hasFlash('netAdded')): ?>

            <div class="alert alert-success">
                Новая сеть добавлена!
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('typeAdded')): ?>

            <div class="alert alert-success">
                Новый тип узла добавлен!
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('netHaveNum')): ?>

            <div class="alert alert-danger">
                Новая сеть с таким номером существует!
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('netHaveName')): ?>

            <div class="alert alert-danger">
                Новая сеть с таким наименованием существует!
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('typeHaveName')): ?>

            <div class="alert alert-danger">
                Тип узла с таким наименованием существует!
            </div>
        <?php endif; ?>
        
    </div>


    <p></p>
    <div class="col-md-3">
      
                <h3>Добавить новую сеть</h3>
<?php
    Modal::begin([
        'header' => '<h3>Добавить новую сеть</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-plus"></span>',
            'tag' => 'button',
            'id' => 'checked',
            'class' => 'btn btn-default',
            'title' => 'Добавить новую сеть'
        ],
    ]);
?>
    <?php $form = ActiveForm::begin(['id' => 'logticketevent-form']); ?>
 
     
                <?= $form->field($modelnet, 'num')
                    ->textInput()->label('Номер сети<font color="f33810">*</font>');
                ?>

                <?= $form->field($modelnet, 'name')
                    ->textInput()->label('Наименование<font color="f33810">*</font>');
                ?>


                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'net-add-button', 'id' => 'net-add-button']) ?>
                </div>

 
    <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
    </div>
    <div class="col-md-3">
      
                <h3>Добавить новый тип узла</h3>
<?php
    Modal::begin([
        'header' => '<h3>Добавить новый тип узла</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-plus"></span>',
            'tag' => 'button',
            'class' => 'btn btn-default',
            'title' => 'Добавить новый тип узла'
        ],
    ]);
?>
                <?php $form1 = ActiveForm::begin(['id' => 'type-list-form']); ?>

                <?= $form->field($modeltype, 'type')
                    ->dropDownList($type)->label('Тип узла<font color="f33810">*</font>');
                ?>

                <?= $form1->field($modeltype, 'name')
                    ->textInput()->label('Наименование<font color="f33810">*</font>');
                ?>


                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'type-add-button', 'id' => 'type-add-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
      
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">

        <?php if (Yii::$app->user->can('admin', Yii::$app->user->id)):?>
            <div class="col-md-12" style="padding: 5px">

                <?= Html::a('Создать учётную запись', ['/lwsuser/add'], ['class'=>'btn btn-primary pull-right']) ?>
                
            </div>
        <?php endif;?>
        <div class="col-md-12" style="padding: 5px">
            
            <?= Html::a('Редактировать учётную запись', ['/lwsuser/edit'], ['class'=>'btn btn-primary pull-right']) ?>

        </div>


    </div>
 
</div>

              <p></p>



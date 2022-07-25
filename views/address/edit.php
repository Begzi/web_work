<?php

use app\models\ContactForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'Изменение контакта';
// $this->params['breadcrumbs'][] = $this->title;
$department = ['Остальные', "Юридический отдел", "Администрация", 'Бухгалтерия', "IT отдел", "Отдел безопастности"];

?>
<div class="container">
    <div class="customers_add">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'region')
                    ->dropDownList($region,  ['options'=>[$address->region_id - 1  =>['Selected'=>true]]])->label('Регион<font color="f33810">*</font>');?>

                <?= $form->field($model, 'district')->textInput(['autofocus' => true, 'value'=>$address->district])->label('Район') ?>

                <?= $form->field($model, 'city')->textInput(['autofocus' => true, 'value'=>$address->city])->label('Населённый пункт<font color="f33810">*</font>') ?>

                <?= $form->field($model, 'street')->textInput(['autofocus' => true, 'value'=>$address->street])->label('Улица')  ?>

                <?= $form->field($model, 'num')->textInput(['autofocus' => true, 'value'=>$address->num])->label('Номер') ?>

                <?= $form->field($model, 'branch')->textInput(['autofocus' => true, 'value'=>$address->branch])->label('Филиал<font color="f33810">*</font>') ?>


                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'address-add-button']) ?>
                    <?= Html::a('Отмена изменений', ['/customers/view', 'id' => $address->customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-lg-5">

<?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить адресс?</h2>',
        'toggleButton' => [
            'label' => 'Удалить адресс',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить адресс'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/address/delete', 'id' => $address->id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?>
                
            </div>
        </div>
    </div>
</div>
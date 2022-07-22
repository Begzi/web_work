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

                <?= $form->field($model, 'position')->textInput(['autofocus' => true, 'value'=>$contact->position])->label('Должность') ?>

                <?= $form->field($model, 'department')
                    ->dropDownList($department,  ['options'=>[$contact->department - 1 =>['Selected'=>true]]])->label('Отдел<font color="f33810">*</font>');?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'value'=>$contact->name])->label('ФИО')?>

                <?= $form->field($model, 'mail')->textInput(['autofocus' => true, 'value'=>$contact->mail])->label('Почта')  ?>

                <?= $form->field($model, 'w_tel')->textInput([ 'value'=>$contact->w_tel])->label('Рабочий телефон') ?>

                <?= $form->field($model, 'm_tel')->textInput(['autofocus' => true, 'value'=>$contact->m_tel])->label('Мобильный телефон')?>

                <?= $form->field($model, 'description')->textInput(['autofocus' => true, 'value'=>$contact->description])->label('Примечание') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'contact-add-button']) ?>
                    <?= Html::a('Отмена изменений', ['/customers/view', 'id' => $contact->customer_id], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-lg-5">

<?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить контакт?</h2>',
        'toggleButton' => [
            'label' => 'Удалить контакт',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить контакт'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/contact/delete', 'id' => $contact->id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?>
                
            </div>
        </div>
    </div>
</div>
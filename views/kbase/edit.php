<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\KbaseForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменение имени знания';
// $this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container">
    <div class="kbase_add">
        <h1><?= Html::encode($this->title) ?></h1>

    <div class="navbar_button">

            <?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить знание?</h2>',
        'toggleButton' => [
            'label' => 'Удалить знание',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить знание'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/kbase/deletekbase', 'id' => $kbase->id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?>
                

    </div>


        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'kbase-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'value' => $kbase->name] )->label('Заголовок нового знания<font color="f33810">*</font>') ?>
                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'customers-add-button']) ?>
                    <?= Html::a('Отмена', ['/kbase/index'], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
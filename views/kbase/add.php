<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\KbaseForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новое знание';
// $this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container">
    <div class="kbase_add">
        <h1><?= Html::encode($this->title) ?></h1>


        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'kbase-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Заголовок нового знания<font color="f33810">*</font>') ?>
                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'customers-add-button']) ?>
                    <?= Html::a('Отмена', ['/kbase/index'], ['class'=>'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
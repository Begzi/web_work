<?php

/* @var $this yii\web\View */


$this->title = 'Customers';


use yii\helpers\Html;
use yii\web\View; ?>


<section class="auto-post-area">
    <div class="conteiner"">
    <div class="col-md-12">

        <a href="<?= \yii\helpers\Url::to(['/customers/add'])?>" >
            Add
        </a>
        <div class="form-group">
            <?= Html::submitButton('Add btn', ['class' => 'btn btn-primary', 'name' => 'customers-add-button']) ?>
            <!--ХЗ КАК РАБОТАЕТ ЭТА ЧЁРТОВА КНОПК!-->
        </div>
    </div>
    <div class="col-md-12">
        <!--        <div class="" float="left">-->
        <span class="inline-1">Полное наименование учреждения</span>
        <!--        </div>-->
        <!--        <div class="" float="right" >-->
        <span class="inline-2">Краткое наименование учреждения</span>

        <!--        </div>-->
    </div>
    <!--        <div class="col-md-12">-->
    <?php for ($i = 0; $i < count($uzs); $i++):?>
        <div class="col-md-12">
            <div class="single-customer">

                <h3><a href="<?= \yii\helpers\Url::to(['/customers/view','id' => $uzs[$i]->customers['id']])?>"><?php echo $uzs[$i]->customers['fullname'] ?></a></h3>

                <h3><p> <?php echo $uzs[$i]->customers['shortname'] ?></p></h3>
            </div>
        </div>
    <?php endfor; ?>
    <!--        </div>-->
    </div>
</section>
<section class="customers-area">


</section>

<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Задание от начальства';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>
    <code><?= __FILE__ ?></code>

    <span><?php echo $check_date_1?></span>
    <span><?php echo $check_date_2?></span>
    <span><?php echo $check_date_3?></span>
    <span><?php echo $check_date_4?></span>
    <br>
    <div class="form-group " style="background:  #ff8c69;">
        <?= Html::a('Изменить', ['/uz/add'],  ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/index'])?>" >
            SQL Изменения данных старых cert в newcert
        </a>
        </p>



        <p class = changed-area2>
            <?= Html::a('Измененить данные', ['/newcert/check'],  ['class'=>'btn btn-primary']) ?>

            <a href="<?= \yii\helpers\Url::to(['/newcert/check'])?>" >
                SQL Изменения данных старых cert uzs в cert_uz
            </a>
        </p>
        

    </div>
    <br>
    <p class = changed-area3>
        <?= Html::a('Вывести', ['/newcert/katya'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/katya'])?>" >
            Для нужд Кати, вывод заказчиком имеющих узел в 592 сети
        </a>
    </p>
    <p class = changed-area3>
        <?= Html::a('Показать', ['/newcert/konstantin'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/konstantin'])?>" >
            Для нужд Константина, вывод узлов находящийхся в Красноярске
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>
        <?= Html::a('Показать', ['/newcert/newcertuz'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/newcertuz'])?>" >
            Для того чтобы узлы знали свой последний актуальный сертификат
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>
        <?= Html::a('Показать', ['/newcert/doc'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/doc'])?>" >
            Увеличения значения doc_id у всех заказчиков
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>
        <?= Html::a('Показать', ['/newcert/cert_group'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/cert_group'])?>" >
            Добавить в БД группы сертификатов
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>  
        <?= Html::a('Показать', ['/newcert/createmail'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/createmail'])?>" >
            Mail создать, отправиться письма тем, кому можно
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>  
        <?= Html::a('Показать', ['/newcert/uzsupplychange'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/newcert/uzsupplychange'])?>" >
            supply time = 2015-05-01, и supply_ex_time change
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>  
        <?= Html::a('certpdf', ['/cert/certpdf'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/cert/certpdf'])?>" >
            supply time = 2015-05-01, и supply_ex_time change
        </a>
    </p>
<!-- Проверил, работает хорошо -->
    <p class = changed-area3>  
        <?= Html::a('logticket', ['/logticket/tmp'], ['class'=>'btn btn-primary']) ?>

        <a href="<?= \yii\helpers\Url::to(['/logticket/tmp'])?>" >
            supply time = 2015-05-01, и supply_ex_time change
        </a>
    </p>
</div>

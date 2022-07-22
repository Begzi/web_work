<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (!(Yii::$app->user->isGuest)):?>
<navbar class="navbar">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            // 'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],

        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => [
                ['label' => 'Заказчики', 'url' => ['/customers/index']],
                ['label' => 'База знаний', 'url' => ['/kbase/index']],
                (Yii::$app->user->can('admin', Yii::$app->user->id) or Yii::$app->user->can('TZI', Yii::$app->user->id)) ? (
                    ['label' => 'Обращения', 'url' => ['/logticket/index']]
                ) : (['label' => '']),
                (Yii::$app->user->can('admin', Yii::$app->user->id) or Yii::$app->user->can('manager', Yii::$app->user->id)) ? (
                    ['label' => '30 дней', 'url' => ['/expire/view']]
                ) : (['label' => '']),
                (Yii::$app->user->can('admin', Yii::$app->user->id)) ? (
                    ['label' => 'Аналитика', 'url' => ['/analyze/index']]
                ) : (['label' => '']),
                Yii::$app->user->id == 8 ? (
                    ['label' => 'Задания От начальства', 'url' => ['/site/about']]
                ) : (['label' => '']),
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выход',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>',  
                    ['label' => strval(Yii::$app->user->identity->username), 'url' => ['/site/account']],      
            ],
        ]);
        NavBar::end();
        ?>
</navbar>
<?php endif;?>
<div class="container-fluid" id="parent_conteiner" style="padding: 25px;">
    <div class="container">
       <!--  <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?> -->
        <?= Alert::widget() ?>
    </div>
    <?= $content ?>
</div>

<?php if (!(Yii::$app->user->isGuest)):?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::a('ПИК Безопасности ' .date('Y'), [ \yii\helpers\Url::to('http://www.anothersite.com/action'), 'style' => "background: red"]) ?></p>

        <?php $certs = $this->context->Main(); 
        if ($cert == NULL):?>
            <p class="pull-right"><?= Html::a('Количество истекающих сертификатов в течении 30 дней: ' . count($certs), ['/cert/search30', 'style' => "background: red"]) ?></p>
        <?php else:?>
            <p class="pull-right"><?= Html::a('Сертификаты', ['/cert/show', 'style' => "background: red"]) ?></p>
        <?php endif;?>
    </div>
</footer>
<? endif;?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


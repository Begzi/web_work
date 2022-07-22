<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
$this->title = 'Заказчики';
 ?>
    <?php for ($i = 0; $i < count($tmp1); $i++):?>
                              <?php echo $i . ')' . $tmp1[$i]->name . ' ' .  $tmp1[$i]->Department?>
                              <br>
    <?php endfor; ?>

    02322221022004310152022011201123100120111221212333333333322122322133333423342320202023023440332333331223430000
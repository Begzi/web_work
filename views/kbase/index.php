<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
$this->title = 'База знаний';
 ?>

<section class="kbase-area">
    <div class="container">
            <div class="col-md-12 col-md-4">
                <section class="box search">
                    <form method="get" action="<?= Url::to(['kbase/searchfull']) ?>">
                        <input type="text" class="text" name="search" placeholder="Поиск" />
                        <?php  if ($searchfull != NULL):?>
                            <label type="text" class="text"><?php echo $searchfull;?></label>
                            <?= Html::a('<span class="glyphicon glyphicon-remove" style="color:black"></span>', ['kbase/searchfull','search'=> ''], ['class'=>'btn btn-xs', 'name' => 'kbase-search-button', 'title' => 'Cancel']) ?>

                        <?php endif;?>
                    </form>
                </section>
            </div>

        <div class="col-xs-12 col-md-4">
        </div>

        <div class="col-xs-12 col-md-4">

            <?= Html::a('Добавить знание', ['/kbase/add'], ['class'=>'btn btn-primary']) ?>

        </div>
        <br>
        <hr>

    <?php for ($i = 0; $i < count($kbase); $i++):?>
        <div class="col-xs-12 col-md-12">
             <div class="single-kbase-name">

                  <h4>
                      <a href="<?= \yii\helpers\Url::to(['/kbase/view','id' => $kbase[$i]->id])?>">
                          <span >
                              Знание № <?php echo $kbase[$i]->id ?>
                          </span>
                      </a>
                      <span>
                          <?php echo $kbase[$i]->name ?>
                      </span>
                  </h4>

             </div>
        </div>
    <?php endfor; ?>
<!--        </div>-->
        <div class="pegination">
            <div class="nav-links">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'lastPageLabel' => true,
                    'firstPageLabel' => true,
                ])?>
            </div>
        </div>
    </div>
</section>
<br>
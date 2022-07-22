<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = $customer->id . ') ' .$customer->fullname;

?>
<script>
    function scheme_description_edit_open(){
        $(".scheme_description_show_mode").hide();
        $(".scheme_description_edit_mode").show();
    }

    function scheme_description_edit_cancel() {
        $(".scheme_description_edit_mode").hide();
        $(".scheme_description_show_mode").show();
    }
</script>
<br>
        <h3><?= Html::encode($this->title) ?></h3>
<br>
<div class='col-xs-4'>
    <?= Html::a('Добавить схему', ['/scheme/add', 'customer_id' => $customer_id], ['class'=>'btn btn-primary pull-right']) ?>
</div>
<div class='col-xs-4'>
    <?= Html::a('Назад', ['/customers/view', 'id' => $customer_id], ['class'=>'btn btn-primary pull-right']) ?>
</div>
<div class='row'>
<?php if ($scheme != NULL):?>
	<?php for ($i = 0; $i < count($scheme); $i++):?>
	<div class='col-xs-8'>
	    <?= Html::img('@web/scheme/' . $customer_id . '/' . $scheme[$i]->sc_link, ['alt'=>'some', 'class'=>'thing',  'width' => "1000px", 'height' => "500px"]) ?>
	</div>
	<div class='col-xs-4'>
    <?php $form = ActiveForm::begin(['id' => 'description-form']);?>
        <div class="panel panel-info mw-100" style="width: 100%;">
                <div class="panel-heading">Примечания
                                <div class="scheme_description_edit_mode pull-right" hidden>
                                     <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-xs', 'name' => 'scheme-description-button', 'title' => 'Сохранить']) ?>
                                    <button type="button" class="btn btn-xs" OnClick="scheme_description_edit_cancel();" title = "Отменить"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                                <div class="scheme_description_show_mode pull-right">
                                     <button type="button" class="btn btn-xs" OnClick="scheme_description_edit_open();" title = "Редактировать" id="scheme_description_edit_open_button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                </div>
                </div>
                <div class="panel-body">
                    <div class="scheme_description_show_mode" style="word-wrap:break-word;">
                        <p type="text" id="scheme_description">
                            <?
                            if ($scheme[$i]->description == NULL)
                            {
                                echo ('Примечания отсутствуют.');
                            }
                            else 
                            {
                                echo ($scheme[$i]->description);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group scheme_description_edit_mode" style="word-wrap:break-word;" hidden>
                        <p type="text" id="scheme_description">
                        <?
                        if ($scheme[$i]->description == NULL){
                            echo ('Примечания отсутствуют.');
                        }
                        else {
                            echo ($scheme[$i]->description);
                        }
                        $text = preg_replace( "#<br />#", "\n", $scheme[$i]->description );
                        $scheme[$i]->description = $text;
                        // при вводе примечания не выводились и знак следующей строки!
                        ?>
                    </p>
                   		<?= $form->field($model, 'description')->textarea(['class' => "form-control",
                        'style'=>"resize:vertical",
                        'value'=>$scheme[$i]->description 
                        ])->label('');?>
                    </div>  
                </div>
                <?= $form->field($model, 'scheme_i')->textInput([ 'value'=>$scheme[$i]->id, 'style' => 'visibility: hidden'])->label('');?>
		</div>
        <?php ActiveForm::end(); ?>


<?php
    Modal::begin([
        'header' => '<h2>Вы уверены что хотите удалить контакт?</h2>',
        'toggleButton' => [
            'label' => 'Удалить схему',
            'tag' => 'button',
            'class' => 'btn btn-danger pull-right',
            'title' => 'Удалить схему'
        ],
    ]);
?>
    
    <?= Html::a('Да', ['/scheme/delete', 'id' => $scheme[$i]->id], ['class'=>'btn btn-danger']) ?>
<?php Modal::end(); ?>
		
	</div>
	<?php endfor; ?>
</div>
<br>
<br>
<br>
<br>
<?php endif ;?>

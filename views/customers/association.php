<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\LogTicketForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Выберите учреждение, которое должно быть объединенно';
?>
<script type="text/javascript">
	
   

    function choose_button(){
        document.getElementById('choose_customer').value += document.getElementById('customer_select_list').value;        
        var form = document.getElementById('choose_form');
        form.submit();
    }
</script>

    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>


        <div class="row">
            <div class="col-lg-5">
                
	            <label for="customer_id" class="form-control-label">Учреждение: <font color="f33810">*</font></label><br>
	            <select data-placeholder="Выберите заказчика"  class="chosen-select" id="customer_select_list" name="customer_select_list" required style="width:100%" >
	                <option value=""></option>
	                <?       
	                $k = count($customers);   
	                for ($i=0;$i<$k;$i++){
	                    $customer_id_selected = strstr($customers[$i], ' - ', true);
                        echo ('<option value="'.$customer_id_selected.'">'.$customers[$i].'</option>');
	                }                                   
	                ?>
	            </select>    
	              	<form method="get"  id="choose_form" action="<?= Url::to(['customers/association']) ?>">
                        <input  id="choose_customer_id" type="text" class="choose_customer_id" name="id"  placeholder="Поиск" value="<?php echo $id;?>" hidden/>
                        <input  id="choose_customer" type="text" class="choose_customer" name="pickup"  placeholder="Поиск" hidden/>
                    </form>
                    <hr>
                    <button id="search_button"  onclick="choose_button()" class="search_button" >Поиск</button>  
            </div>
        </div>

	</div>
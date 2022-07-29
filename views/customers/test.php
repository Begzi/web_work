<?php foreach ($customers as $cas):?>
	<h1><?php echo $cas?></h1>
	<?php   
	echo strpos ($cas, 'ЧУ'); 
		echo strpos ($cas, 'ООО');
        echo strpos ($cas, 'ЧУЗ'); 
        echo  strpos ($cas, 'НУЗ'); 
        echo strpos ($cas, 'АО'); 
        echo strpos ($cas, 'Нефросовет-Ярославль'); 
		echo  strpos ($cas, 'КГАУЗ');
		 echo  strpos ($cas, 'АНО'); 
		 echo strpos ($cas, 'КГАОУ');
            ?>
<?php endforeach?>	
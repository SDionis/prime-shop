<h1 style="text-align:center;">Вернуть цмс к состоянию установки</h1>
<h3 style="color:red;text-align:center;">Все данные будут уничтожены !</h3>
<form method="POST">
<input style="display: block;margin:0 auto;" type="submit" name="execute" value="Продолжить" />
</form>
<?
foreach($error as $err){
	echo $err.'<br />';
}
?>
<?php 
//print_r($_POST);
?>

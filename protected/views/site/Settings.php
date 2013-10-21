<form method="POST">

<table class="top_table">
<?
if (!empty($_GET['mess']) && $_GET['mess'] == 1) {
?>
<tr class="tr_data">
    <td colspan="2" class="td_name" style="color:red;">Введите ID партнера из hasoffers</td>
    
</tr>
<?
}
foreach ($setting_info as $row) {
?>

<tr class="tr_data">
    <td class="td_name"><?=$row['setting_cyr_name']?></td>
    <td><input type="text" name="<?=$row['setting_name']?>" value="<?=$row['setting_value']?>" /></td>
</tr>
<?
}
?>

</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />

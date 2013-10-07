<form method="POST">

<table class="top_table">

<tr class="tr_data">
    <td class="td_name">Магазин</td>
    <td><?=$shop_info['name']?>, <?=$shop_info['company']?></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Название категории</td>
    <td><input type="text" name="cat_name" value="<?=$cat_info['cat_name']?>" /></td>
</tr>

</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />


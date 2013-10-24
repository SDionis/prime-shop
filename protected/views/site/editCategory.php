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

<tr class="tr_data">
    <td class="td_name">Титул</td>
    <td><input type="text" name="cat_title" value="<?=$cat_info['cat_title']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Описание</td>
    <td><input type="text" name="cat_description" value="<?=$cat_info['cat_description']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Ключевые слова</td>
    <td><input type="text" name="cat_keywords" value="<?=$cat_info['cat_keywords']?>" /></td>
</tr>

</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />


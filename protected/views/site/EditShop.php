<form method="POST">

<table class="top_table">

<tr class="tr_data">
    <td class="td_name">Название магазина</td>
    <td><input type="text" name="name" value="<?=$shop_info['name']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Название компании</td>
    <td><input type="text" name="company" value="<?=$shop_info['company']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Дата YML файла</td>
    <td><input type="text" name="date" value="<?=$shop_info['date']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">URL</td>
    <td><input type="text" name="url" value="<?=$shop_info['url']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">CMS</td>
    <td><input type="text" name="platform" value="<?=$shop_info['platform']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Версия CMS</td>
    <td><input type="text" name="version" value="<?=$shop_info['version']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Наименование агентства, которое оказывает техническую поддержку магазину</td>
    <td><input type="text" name="agency" value="<?=$shop_info['agency']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Контактный адрес разработчиков CMS</td>
    <td><input type="text" name="email" value="<?=$shop_info['email']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Общая стоимость доставки</td>
    <td><input type="text" name="local_delivery_cost" value="<?=$shop_info['local_delivery_cost']?>" /></td>
</tr>

<tr class="tr_data">
    <td class="td_name">ID оффера</td>
    <td><input type="text" name="offer_id" value="<?=$shop_info['offer_id']?>" /></td>
</tr>

</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />


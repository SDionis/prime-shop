<form method="POST">

<table class="top_table">

<tr class="tr_data">
    <td class="td_name">Google Analitics</td>
    <td><textarea style="height:250px; width:840px;" type="text" name="google_analitics" ><?=htmlspecialchars($counts['google_analitics'], ENT_QUOTES)?></textarea></td>
</tr>

<tr class="tr_data">
    <td class="td_name">Яндекс метрика</td>
    <td><textarea style="height:250px; width:840px;" type="text" name="yandex_metrika" ><?=htmlspecialchars($counts['yandex_metrika'], ENT_QUOTES)?></textarea></td>
</tr>


</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />

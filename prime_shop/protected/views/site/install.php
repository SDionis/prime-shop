<?php


?>
<table class="top_table">
	<tr class="tr_data">
	    <td class="td_name">Введите хост базы данных</td>
	    <td class="td_name"><input type="text" name="db_host" value="" /></td>
	</tr>
	<tr class="tr_data">
	    <td class="td_name">Введите логин базы данных</td>
	    <td class="td_name"><input type="text" name="db_login" value="" /></td>
	</tr>
	<tr class="tr_data">
	    <td class="td_name">Введите пароль базы данных</td>
	    <td class="td_name"><input type="password" name="db_pass" value="" /></td>
	</tr>
	<tr class="tr_data">
	    <td class="td_name">Введите пароль базы данных повторно</td>
	    <td class="td_name"><input type="password" name="db_pass_repeat" value="" /></td>
	</tr>
	<tr class="tr_data">
	    <td class="td_name">Введите название базы данных</td>
	    <td class="td_name"><input type="text" name="db_name" value="" /></td>
	</tr>
</table>
<div class="save_button_container"><input id="save_button" type="button" value="Сохранить" /></div>

<table class="top_table table_info">
	<?
	foreach ($error as $val) {
		echo '<tr class="tr_data">';
	    echo '<td style="color:red;" class="td_name">'.$val.'</td>';
		echo '</tr>';
	}
	?>
	<!--  <tr class="tr_data">
	    <td style="color:red;" class="td_name">Введите хост базы данных</td>
	</tr>
	<tr class="tr_data">
	    <td style="color:red;" class="td_name">Введите хост базы данных</td>
	</tr>-->
</table>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />
<style type="text/css">
	.table_info {
		width:80% !important;
		margin: 20px auto 0 !important;
		
	}
	.table_info tr {
		border:0 !important;
	}
</style>

<script type="text/javascript">
$(document).ready(function(){ 
    $('#save_button').click(function(){
        //var data_send = new Array();
    	$.ajax({
            url: '', 
            dataType: 'json', 
            type: 'POST',
            data: {db_host:$('input[name="db_host"]').val(), db_login:$('input[name="db_login"]').val(), db_pass:$('input[name="db_pass"]').val(), db_name:$('input[name="db_name"]').val(), db_pass_repeat:$('input[name="db_pass_repeat"]').val()},                              
            success: function (data_return) {
            	$('table.table_info').empty();
            	
            	//console.info(data_return);
            	if (data_return.length == 0 || !data_return) {
            		var tr_add = '<tr class="tr_data">';
                    tr_add += '<td style="color:green;" class="td_name">Успешно установлено</td>';
                    tr_add += '</tr>';
                    tr_add += '<tr class="tr_data">';
                    tr_add += '<td style="color:green;" class="td_name"><a href="<?php echo Yii::app()->request->baseUrl; ?>/control">В админку</a></td>';
                    tr_add += '</tr>';
                    tr_add += '<tr class="tr_data">';
                    tr_add += '<td style="color:green;" class="td_name"><a href="<?php echo Yii::app()->request->baseUrl; ?>">На сайт</a></td>';
                    tr_add += '</tr>';
                    $('table.table_info').append(tr_add);
                    $('#save_button').attr('disabled','disabled');
                } else {
	                for(var i=0; i<data_return.length; i++) {
	                    var tr_add = '<tr class="tr_data">';
	                    tr_add += '<td style="color:red;" class="td_name">'+data_return[i]+'</td>';
	                    tr_add += '</tr>';
	                    $('table.table_info').append(tr_add);
	                }
                }
                //console.info(data_return);
                
                
            },              
        });
    });
});
</script>

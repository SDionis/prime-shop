<table class="top_table" style="margin: 0 auto;" cellpadding='10px'>
<?php 
if(!empty($error)){
	foreach ($error as $val){
?>
	<tr class="tr_data">
	<td style="text-align:center;"><?=$val?></td>
	</tr>
<?	
	}
} else {
	if ($is_updatable == 1) {
?>
		<tr class="tr_data">
		<td style="text-align:center;"><a id="update_button" class="btn btn-primary" href="">Обновить</a></td>
		</tr>
<?
	} else {
?>
		<tr class="tr_data">
		<td style="text-align:center;"><span class="label label-info" style="font-size: 17px;padding: 6px 8px;">Обновление не требуется</span></td>
		</tr>
<?
	}
}
?>	

</table>
<script type="text/javascript">
function begin_ajax() {
	var layer = '';
	layer += '<div id="layer_ajax" style="background:grey;opacity:0.4;position:fixed;top:0;left:0;width:100%;height:100%;text-align:center;vertical-align:middle;"><img src="http://<?=$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl?>/images/ajax-loader.gif" /></div>';
	$('body').append(layer);
	$('#layer_ajax img').css('margin-top', $(document).height()/2);
}
function finish_ajax() {
	$('#layer_ajax').remove();
}
$(document).ready(function(){ 
	//begin_ajax();
	//finish_ajax();
	$('#update_button_after').live('click', function(){
		
		return false;
	});
    $('#update_button').click(function(){
    	
    	$.ajax({
            url: 'http://<?=$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl?>/update.php', 
            //dataType: 'json', 
            type: 'GET',
            data: {},  
            beforeSend: function (xml_http_obj) {begin_ajax();},
            complete: function (xml_http_obj) {finish_ajax();},                   
            success: function (data_return) {
                
    			$('#update_button').replaceWith('<a id="update_button_after" class="label" style="font-size: 17px;padding: 6px 8px;" href="">Обновить</a>');
    			
    			var tr_add = '';
                tr_add += '<tr class="tr_data">';
                tr_add += '<td style="text-align:center;">';
                if (data_return.length == 0) {
                	tr_add += '<span style="font-size: 17px;padding: 6px 8px;" class="label label-success">Успешно обновлено</span>';
                } else {
                    tr_add += '<span style="font-size: 17px;padding: 6px 8px;" class="label label-success">'+data_return+'</span>';
				}
                tr_add += '</td>';
                tr_add += '</tr>';
                $('table.top_table').append(tr_add);
            	
            },              
        });
        return false;
    });
});
</script>

<div class="" style="width: 400px; background-color: white; border: 1px solid #E3E3E3; border-radius: 4px 4px 4px 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);margin: 0 auto;padding:10px;">
    <form id="form_upload" class="form-horizontal" method="post" enctype="multipart/form-data">
    
    <!--<input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
    <div class="control-group upload_div">
    	<div style="width:82%;margin:0 auto;">Максимальный объем загружаемого файла <?=ini_get('upload_max_filesize')?></div>
	    <div class="controls">
	    	<input type="file" name="uploadFile" id="inputFile" placeholder="файл YML" />
	    </div>
    </div>
    <div class="control-group">
    <div class="controls">
    	<div class="offer_id_input">Offer ID <input type="hidden" name="ymlftp" value="1" />
    		<input type="text" name="offer_id" value="" />  
    	</div> 
    <button type="submit" class="btn btn-primary">Загрузить XML</button>
    </div>
    </div>
    </form>		
    <form id="form_load" class="form-horizontal" method="post">    
    	<div class="control-group">    
	    	<div class="controls">    
		    	<span>Загрузить Yml из локальной папки ymlftp</span>	
		    	<div>
		    		<select name="xml_file">
		    		<?foreach($xmls as $xml){?>
		    			<option value="<?=$xml?>"><?=$xml?></option>
		    		<?
					}
					?>
					</select>
		    	</div>
		    	<div class="offer_id_input">Offer ID <input type="hidden" name="ymlftp" value="1" />
		    	
		    	<input type="text" name="offer_id" value="" />  
		    	</div>  
		    	<button type="submit" class="btn btn-primary">Загрузить XML</button>    
	    	</div>    
    	</div>    
    </form>
    <?if ($success_mess == 1) {?>
    <span style="color:green;">XML Файл успешно загружен</span>
    <?}?>
</div>
<style type="text/css">
.form-horizontal {border:1px dashed black;}
.form-horizontal .controls {margin-left: 80px;}
.offer_id_input{margin:5px 0;}
.form-horizontal .control-group {
    margin-bottom: 10px;
}
.upload_div {
	margin-bottom:0px !important;
	margin-top:10px;
}
</style>

<script type="text/javascript">

    $(document).ready(function(){
		$('form#form_upload').bind('submit', function(){
			if ($('form#form_upload input[name="offer_id"]').val().length == 0) {
				alert('Поле "Offer ID" не может быть пустым');
				return false;
			}
		});
		$('form#form_load').bind('submit', function(){
			if ($('form#form_load input[name="offer_id"]').val().length == 0) {
				alert('Поле "Offer ID" не может быть пустым');
				return false;
			}
		});
    });

</script>
<?//print_r($_FILES);//print_r($_POST);?>
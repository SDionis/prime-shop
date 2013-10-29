<script type="text/javascript" src="<?=Yii::app()->request->baseUrl?>/ckeditor_4.2.2_full/ckeditor/ckeditor.js"></script>

<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
<table class="top_table">

<tr class="tr_data">
    <td colspan="2" class="td_name" style="color:red;">Статическая страница</td>
</tr>

<tr class="tr_data">
	<td class="td_name">ID</td>
    <td style="text-align: center;">
    	<input type="text" readonly="readonly" name="id" id="id" value="<?=@$staticPage['id']?>" />
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Титул</td>
    <td style="text-align: center;">
    	<input type="text" name="title" id="title" value="<?=@$staticPage['title']?>" />
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Транслит</td>
    <td style="text-align: center;">
    	<input type="text" name="translit" id="translit" value="<?=@$staticPage['translit']?>" />
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Мета Титул</td>
    <td style="text-align: center;">
    	<input type="text" name="meta_title" id="meta_title" value="<?=@$staticPage['meta_title']?>" />
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Мета описание</td>
    <td style="text-align: center;">
    	<textarea name="meta_descr" id="meta_descr" cols="45" rows="5" ><?=@$staticPage['meta_descr']?></textarea>
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Мета ключевые слова</td>
    <td style="text-align: center;">
    	<textarea name="meta_keywords" id="meta_keywords" cols="45" rows="5" ><?=@$staticPage['meta_keywords']?></textarea>
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Дата</td>
    <td style="text-align: center;">
    	<input readonly="readonly" type="text" name="date" id="date" value="<?=@$staticPage['date']?>" />
    </td>
</tr>

<tr class="tr_data">
	<td class="td_name">Картинка</td>
    <td style="text-align: center;">
    	<input type="file" name="picture" id="picture" />
    	<?
    	if (!empty($staticPage['picture'])) {
    	?>
    	<img src="<?='http://'.$_SERVER['HTTP_HOST'].$staticPage['picture']?>" />
    	<?	
    	}
    	?>
    </td>
</tr>

<tr class="tr_data">
    <td colspan="2" style="text-align: center;">
    	<span>Содержание</span>
    	<textarea name="content" id="content" cols="45" rows="5" ><?=@$staticPage['content']?></textarea>
    </td>
    <script type="text/javascript">
	CKEDITOR.replace('content');
	</script>
</tr>

</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>
</form>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />


<script type="text/javascript">
	function translit(str){
		// Символ, на который будут заменяться все спецсимволы
		var space = '-';
		// Берем значение из нужного поля и переводим в нижний регистр
		var text = str.toLowerCase();
		    
		// Массив для транслитерации
		var transl = {
		'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
		'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
		'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
		'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
		' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
		'#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
		'(': space, ')': space,'-': space, '\=': space, '+': space, '[': space,
		']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
		'{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
		'?': space, '<': space, '>': space, '№':space
		}
		               
		var result = '';
		var curent_sim = '';
		               
		for(i=0; i < text.length; i++) {
		    // Если символ найден в массиве то меняем его
		    if(transl[text[i]] != undefined) {
		         if(curent_sim != transl[text[i]] || curent_sim != space){
		             result += transl[text[i]];
		             curent_sim = transl[text[i]];
		                                                        }                                                                            
		    }
		    // Если нет, то оставляем так как есть
		    else {
		        result += text[i];
		        curent_sim = text[i];
		    }                             
		}         
		               
		result = TrimStr(result);              
		               
		// Выводим результат
		return result;   
	}
	
	function TrimStr(s) {
	    s = s.replace(/^-/, '');
	    return s.replace(/-$/, '');
	}
	
    $(document).ready(function(){
		$('input#title').keyup(function(e){
			//translit($(this).val());
			//alert($(this).val());
			$('input#translit').val(translit($(this).val()));
		});
    });

</script>

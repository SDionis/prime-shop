<form method="POST">

<table class="top_table">
<tr class="tr_data">
    <td class="td_name">Название альтернативной категории</td>
    <td class="td_name">Привязка к категориям</td>
</tr>
<?

$i=0;
//echo '<pre>';print_r($categoriesAlternative);echo '</pre>';
//echo '<pre>';print_r($_POST);echo '</pre>';
foreach ($categoriesAlternative as $key => $val) {
    $arr_links = array_keys($val['links']); 
?>
<tr class="tr_data">
    <td class="td_name"><input type="text" name="cat_name[<?=$i?>]" value="<?=$val['cat_alt_name']?>" /></td>
    <td class="td_name">
        <select multiple="multiple" size="4" name="cat_link[<?=$i?>][]">
            <?
            
            foreach($get_array_from_tree_for_option as $key2 => $val2) {
            ?>
                <option style="color:red;" value="<?=$key2?>"><?=$key2?></option>
            <?
                foreach($val2 as $key3 => $val3) {
                    if (in_array($key3, $arr_links)) {
            ?>
                        <option selected = "selected" value="<?=$key3?>"><?=$val3?></option>
            <?
                    } else if (in_array($key3, $restricted_cats)) {
                        echo '<option style="background: yellow;" disabled="disabled" value="0">'.$val3.'</option>';
                    } else {            
            ?>
                        <option value="<?=$key3?>"><?=$val3?></option>
            <?
                    }
            ?>
                    
            <?
                }
            }
            ?>
        </select>
        <a class="del_icon_pictures" href="?del_id=<?=$key?>">
            <img width="20px" height="20px" title="удалить" src="../images/delete.png" />
        </a>
    </td>
</tr>
<?
    $i++;
}
?>
</table>
<div style="margin: 0 auto;width: 80%;">
<div style="text-align: left;display: inline-block;width: 49.5%;"><a style="display: inline-block;" id="add" href="">Добавить</a></div>
<div style="text-align: right;display: inline-block;width: 50%;"><input type="submit" value="Сохранить" /></div>
</div>
</form>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />
<script type="text/javascript">
    var i = <?=$i?>;
    $(document).ready(function(){
        $('#add').click(function(){
            $.ajax({
                url: '',  
                type: 'POST',
                data: {option_type:'getCategoriesAlternative'},                              
                success: function (data_return) {
                    var tr_add = '<tr class="tr_data" style="background:#DCDCDC;">';
                    tr_add += '<td class="td_name"><input type="text" name="cat_name['+i+']" value="" /></td>';
                    tr_add += '<td class="td_name">';
                    tr_add += '<select multiple="multiple" size="4" name="cat_link['+i+'][]">';
                    tr_add += data_return;
                    tr_add += '</select>';
                    tr_add += '</td>';
                    tr_add += '</tr>';
                    $('table.top_table').append(tr_add);
                    i++;
                },              
            });
            return false;
        });
    });
    
</script>

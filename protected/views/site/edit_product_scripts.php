<style type="text/css">

</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="type"]').live('change', function(){
            $.ajax({
                url: '',  
                type: 'POST',
                data: {option_type:'change_type', option_val: $(this).val()},                              
                success: function (data_return) { 
                    $('#form_edit_prod').html(data_return);
                    //console.info($(data_return).get(0));
                	//console.info($(data_return));
                },              
            });
        });
        
        $('.add_val_picture').live('click', function(){
            //var input_name = $(this).prev().attr('name');
            //var input_type = $(this).prev().attr('type');
            //console.info($(this).prev('input').attr('name'));
            $(this).before('<input type="text" name="picture[]" /><a class="del_icon_pictures" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.add_val_param').live('click', function(){
            $('.table_params tr:last').after('<tr><td><input type="text" name="param_name[]" /></td><td><input type="text" name="param_unit[]" /></td><td><input type="text" name="param_value[]" /></td><td><a class="del_icon_params" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a></td></tr>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_pictures').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
        
        $('.del_icon_params').live('click', function(){
            $(this).parent().parent().remove();
            return false;
        });
        
        $('.add_val_barcode').live('click', function(){
            $(this).before('<input type="text" name="barcode[]" /><a class="del_icon_barcode" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_barcode').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
        
        $('.add_val_dataTour').live('click', function(){
            $(this).before('<input type="text" name="dataTour[]" /><a class="del_icon_dataTour" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_dataTour').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
    });
    

</script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />
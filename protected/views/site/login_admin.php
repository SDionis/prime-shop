<?
//echo '<pre>';
//print_r($_SERVER);
//echo '</pre>';
?>

<div class="login" style="width: 400px; background-color: white; border: 1px solid #E3E3E3; border-radius: 4px 4px 4px 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);margin: 0 auto;padding:10px;">
    <form id="form_login" class="form-horizontal" method="post" action="checkLogin">
    <div class="control-group">
    <label class="control-label" for="inputEmail">Логин</label>
    <div class="controls">
    <input type="text" name="login" id="inputlogin" placeholder="login" />
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputPassword">Пароль</label>
    <div class="controls">
    <input type="password" name="<?=!empty($this->with_hashing)?'pass':'password'?>" id="inputPassword" placeholder="Пароль" />
    </div>
    </div>
    <div class="control-group">
    <div class="controls">
    
    <button type="submit" class="btn btn-primary">Войти</button>
    </div>
    </div>
<?
if (!empty($this->with_hashing)) {
?>
    <input type="hidden" value="<?php echo $nonce?>" name="nonce" id="hidden_nonce" />
    <input type="hidden" value="" name="password" id="hidden_password" />
<?
}
?>
    </form>
</div>
<style type="text/css">
div.login {
	margin-top:100px !important;
}
</style>

<?
if (!empty($this->with_hashing)) {
?>
<script type="text/javascript">
$(document).ready(function(){ 
    $('#form_login').submit(function(){
    //$('.btn').click(function(){
        //$('#hidden_password').val(md5($('#inputPassword').val()));
        //$('#hidden_password').val(md5($('#hidden_password').val() + $('#hidden_nonce').val()));
        //$('#inputPassword').val('');
        //$('#hidden_nonce').val('');
        var pass_md5 = $('#inputPassword').val();
        pass_md5 = md5(pass_md5);
        var pass_md5_2 = $('#hidden_nonce').val();
        var pass_md5_3 = pass_md5+pass_md5_2;
        $('#hidden_password').val(md5(pass_md5_3));
        $('#inputPassword').val('');
        $('#hidden_nonce').val('');
        //alert(md5($('#hidden_password').val()));
        //return false;
    });
});
</script>
<?
}
?>


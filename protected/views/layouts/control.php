<?php
header('Content-Type: text/html;charset=UTF-8');
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом
Header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
Header("Pragma: no-cache"); // HTTP/1.1
Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta http-equiv="Cache-Control" content="no-cache">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/bootstrap.css" media="screen, projection" />

<!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery.js"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/bootstrap.js"></script>
<?
if (!empty($this->with_hashing)) {
?>
<script type="text/javascript" src="<?=$this->index_point?>js/admin/md5.js" ></script>
<?
}
?>
<style type="text/css">

body {
    background-color: #F5F5F5;
    padding-bottom: 40px;
    padding-top: 5px;
}
.menu{
    clear:both;
    margin: 0 auto;
    min-width: 100px;
    max-width: 50%;
    text-align:center;
    padding-bottom: 5px;
}
.menu a {
    display: inline-block;
    padding:4px;
    border:1px solid red;

}
.menu2{
    margin: 0 auto;
    min-width: 100px;
    max-width: 60%;
    text-align:center;
    margin-bottom: 10px;
	margin-top: 10px;
}

</style>
</head>
<body>
<? if (!empty($_SESSION['login'])) {?>
    <ul class="nav nav-pills menu2">		
	    <!--<li class="active">-->		<li>
	    	<a href="<?=$this->index_point?>control">Главная</a>
	    </li>
    	<li><a href="<?=$this->index_point?>control/UploadXML">Загрузить XML</a></li>
    	<li><a href="<?=$this->index_point?>control/AlternativeCategories">Альтернативные категории</a></li>
        <!--<li><a href="<?=$this->index_point?>control/DownloadAllImages">Скачать все картинки</a></li>-->
        <li><a href="<?=$this->index_point?>control/Settings">Настройки</a></li>
        <li><a href="<?=$this->index_point?>control/Counts">Счетчики</a></li>
    </ul>
	<a style="position:absolute; right:1%; top:1%;" href="<?=$this->index_point?>control/AdminLogout">Выход</a>
<?}?>
<!-- <div class="menu">
    <a href="../control">Главная</a>
    <a href="UploadXML">Загрузить XML</a>
    <a href="AlternativeCategories">Альтернативные категории</a>
</div>-->
<?php echo $content; ?>
</body>
</html>
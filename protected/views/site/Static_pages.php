 <div class="container-fluid">
    <div class="row-fluid">
    	<div class="span10">
    		<div class="title">Статические страницы</div>
    		<div><a href="<?=Yii::app()->request->baseUrl?>/control/EditStaticPages">Добавить</a></div>
<?
$pager = $StaticPagesPerPage;

if (empty($StaticPagesPerPage['data'])) {
	echo '<div style="border-top: 1px solid #DDDDDD;padding: 8px;text-align: center;">Статических страниц не обнаружено</div>';
} else {
	if (count($pager['data']) > 0 && $pager['total_pages'] > 1) {?>
		<div class="pagination">
			<ul>
	            <?
	            if ($pager['total_pages'] <= 10) {
	                
	            if ($pager['current_page'] <= 1) {
	                $prev = 1;
	            } else {
	                $prev = $pager['current_page'] - 1;
	            }
	            ?>
	            <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $prev)?>">Prev</a></li>
	            <?
	            for ($i=1; $i<=$pager['total_pages']; $i++) {
	                if ($i == $pager['current_page']) {
	                    echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
	                } else {
	                    echo '<li><a href="'.$product->parse_request_url($_SERVER['REQUEST_URI'], $i).'">'.$i.'</a></li>';
	                }
	            }
	            ?>
	            <?
	            if ($pager['current_page'] >= $pager['total_pages']) {
	                $next = $pager['total_pages'];
	            } else {
	                $next = $pager['current_page'] + 1;
	            }
	            ?>
	            <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $next)?>">Next</a></li>
				<?
	            } else {
	                if ($pager['current_page'] <= 1) {
	                    $prev = 1;
	                } else {
	                    $prev = $pager['current_page'] - 1;
	                }
	                ?>
	                <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $prev)?>">Prev</a></li>
	                <?
	                for ($i=1; $i<=$pager['total_pages']; $i++) {
	                    if ($i == $pager['current_page']) {
	                        echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
	                    } else if (($i > $pager['current_page'] - 2 && $i < $pager['current_page'] + 2) || $i <= 2 || $i >= $pager['total_pages'] - 1) {
	                        echo '<li><a href="'.$product->parse_request_url($_SERVER['REQUEST_URI'], $i).'">'.$i.'</a></li>';
	                    } else {
	                        //echo '<li><a class="invarseColor" href="'.$this->index_point.$_GET['id'].'/?page='.$i.'">'.$i.'</a></li>';
	                    }
	                    if($i == 3 && $pager['current_page'] > 4){
	                        echo '<li><a>...</a></li>';
	                    }
	                    if($i == $pager['total_pages'] - 2 && $pager['current_page'] < $pager['total_pages'] - 3){
	                        echo '<li><a>...</a></li>';
	                    }
	                }
	                if ($pager['current_page'] >= $pager['total_pages']) {
	                    $next = $pager['total_pages'];
	                } else {
	                    $next = $pager['current_page'] + 1;
	                }
	                ?>
	                <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $next)?>">Next</a></li>
	    			<?
	                }
	            ?>
			</ul>
		</div><!--end pagination-->
	<?
	}
	echo '<table class="table">';
	echo '<tr>'; 
	echo '<td class="head_cell" width="110px"></td>';
	echo '<td class="head_cell" width="30px">ID</td>';
	echo '<td class="head_cell">Титул</td>';
	echo '<td class="head_cell" width="150px">Дата</td>';
	echo '<td class="head_cell" width="70px">Настройки</td>';
	echo '</tr>';
	foreach ($StaticPagesPerPage['data'] as $row) {
		echo '<tr>'; 
		if (empty($row['picture'])) {
			$resized_pic = Yii::app()->request->baseUrl.'/img/100x100.png';
		} else {
			//echo 'http://'.$_SERVER['HTTP_HOST'].$row['picture'];
			$resized_pic = $AcImageCall->resize_simple($_SERVER['DOCUMENT_ROOT'].$row['picture'], 100, 100);
			if (empty($resized_pic)) {
				$resized_pic = Yii::app()->request->baseUrl.'/img/100x100.png';
			}
		}
		echo '<td><img src="'.$resized_pic.'" /></td>';
		echo '<td>'.$row['id'].'</td>';
		echo '<td>'.$row['title'].'</td>';
		echo '<td>'.$row['date'].'</td>';
		echo '<td>
		<a href="'.$this->index_point.'control/EditStaticPages?id='.$row['id'].'"><img width="20px" height="20px" src="../images/edit.png" title="редактировать"/></a>
		<a class="delete_static_page" href="'.$this->index_point.'control/DeleteStaticPage?id='.$row['id'].'&url_redirect='.rawurlencode($_SERVER['REQUEST_URI']).'"><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>
		</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	//echo '<pre>';
	//print_r($StaticPagesPerPage);
	//echo '</pre>';
?>
<?
if (count($pager['data']) > 0 && $pager['total_pages'] > 1) {?>
	<div class="pagination">
		<ul>
            <?
            if ($pager['total_pages'] <= 10) {
                
            if ($pager['current_page'] <= 1) {
                $prev = 1;
            } else {
                $prev = $pager['current_page'] - 1;
            }
            ?>
            <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $prev)?>">Prev</a></li>
            <?
            for ($i=1; $i<=$pager['total_pages']; $i++) {
                if ($i == $pager['current_page']) {
                    echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
                } else {
                    echo '<li><a href="'.$product->parse_request_url($_SERVER['REQUEST_URI'], $i).'">'.$i.'</a></li>';
                }
            }
            ?>
            <?
            if ($pager['current_page'] >= $pager['total_pages']) {
                $next = $pager['total_pages'];
            } else {
                $next = $pager['current_page'] + 1;
            }
            ?>
            <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $next)?>">Next</a></li>
			<?
            } else {
                if ($pager['current_page'] <= 1) {
                    $prev = 1;
                } else {
                    $prev = $pager['current_page'] - 1;
                }
                ?>
                <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $prev)?>">Prev</a></li>
                <?
                for ($i=1; $i<=$pager['total_pages']; $i++) {
                    if ($i == $pager['current_page']) {
                        echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
                    } else if (($i > $pager['current_page'] - 2 && $i < $pager['current_page'] + 2) || $i <= 2 || $i >= $pager['total_pages'] - 1) {
                        echo '<li><a href="'.$product->parse_request_url($_SERVER['REQUEST_URI'], $i).'">'.$i.'</a></li>';
                    } else {
                        //echo '<li><a class="invarseColor" href="'.$this->index_point.$_GET['id'].'/?page='.$i.'">'.$i.'</a></li>';
                    }
                    if($i == 3 && $pager['current_page'] > 4){
                        echo '<li><a>...</a></li>';
                    }
                    if($i == $pager['total_pages'] - 2 && $pager['current_page'] < $pager['total_pages'] - 3){
                        echo '<li><a>...</a></li>';
                    }
                }
                if ($pager['current_page'] >= $pager['total_pages']) {
                    $next = $pager['total_pages'];
                } else {
                    $next = $pager['current_page'] + 1;
                }
                ?>
                <li><a href="<?=$product->parse_request_url($_SERVER['REQUEST_URI'], $next)?>">Next</a></li>
    			<?
                }
            ?>
		</ul>
	</div><!--end pagination-->
<?
}
}
?>
		</div>
	</div>
</div>

<style type="text/css">
ul li {
    list-style-type: none;
} 
table td {
    vertical-align: middle !important;
}
.span10 {
	margin: 0 auto !important;
	float:none !important;
	clear:both;
}
.title {
	text-align: center;
	font-size:20px;
	font-weight: bold;
	margin-bottom: 10px;
}
td {
	text-align: center !important;
}
</style>

<script type="text/javascript">

$(document).ready(function(){
	$('a.delete_static_page').click(function(){
		if (confirm("Вы подтверждаете удаление статической страницы?")) {
			return true;
		} else {
			return false;
		}
	});
});

</script>

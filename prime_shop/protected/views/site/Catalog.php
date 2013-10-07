<?
//print_r($out);
$catalog = new catalog();
?>

<div class="container-fluid">
    <div class="row-fluid">
    <div class="span2">

<?
foreach ($out as $key => $val) {
    echo '<div class="shop_with_cats_tree"><div class="shops">';
    echo '<span class="shop_name">'.$shops_id_to_info[$key]['name'].', '.$shops_id_to_info[$key]['company'].'</span>';
    echo '&nbsp;<span class="shop_controls"><a href="EditShop?id='.$key.'"><img width="14px" height="14px" src="'.$this->index_point.'images/edit.png" title="редактировать магазин"/></a>
    <a class="delete_shop" href="'.$this->index_point.'control/DeleteShop?id_shop='.$key.'&url_redirect='.rawurlencode($_SERVER['REQUEST_URI']).'"><img width="14px" height="14px" src="'.$this->index_point.'images/delete.png" title="удалить магазин"/></a>
    ';
    echo '</span></div>';
    $catalog->show_tree_from_array($val);
    echo '</div>';
}
if (!empty($current_category_info)) {
?>
     
    <!--Sidebar content-->
    </div>
    <div class="span10">
    <div>
    Текущая категория: 
    <?=$current_category_info['cat_name'];?>
    <span style="margin-left: 20px;">
    <a href="EditCategory?id=<?=$current_category_info['id']?>"><img width="20px" height="20px" src="<?=$this->index_point?>images/edit.png" title="редактировать категорию"/></a>
    <a class="delete_cat" href="<?=$this->index_point.'control/DeleteCategory?id_cat='.$_GET['id_cat'].'&id_shop='.$_GET['id_shop'].'&url_redirect='.rawurlencode($_SERVER['REQUEST_URI'])?>"><img width="20px" height="20px" src="<?=$this->index_point?>images/delete.png" title="удалить категорию"/></a>
    </span>
    </div>
    
    <?if (count($pager['data']) > 0 && $pager['total_pages'] > 1) {?>
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
    <?}?>
    <?
    
    if (empty($products_show)) {
        echo '<div style="border-top: 1px solid #DDDDDD;padding: 8px;">В данной категории продуктов не обнаружено</div>';
    } else {
        echo '<table class="table">';
        echo '<tr>'; 
        echo '<td width="110px"></td>';
        echo '<td width="30px">ID</td>';
        echo '<td>Info</td>';
        echo '<td width="100px">Price</td>';
        echo '<td>Settings</td>';
        echo '</tr>';
        foreach ($products_show as $row) {
            switch ($row['type']) {
                case '':
                    $prod_info = $row['name'];
                    break;
                case 'vendor.model':
                    $prod_info = $row['vendor'].' '.$row['model'];
                    break;
                case 'book':
                    $prod_info = $row['name'].' '.$row['author'];
                    break;
                case 'audiobook':
                    $prod_info = $row['name'].' '.$row['author'];
                    break;
                case 'artist.title':
                    $prod_info = $row['title'];
                    break;
                case 'tour':
                    $prod_info = $row['name'].' '.$row['included'].' '.$row['transport'].' '.$row['days'];
                    break;
                case 'event-ticket':
                    $prod_info = $row['name'].' '.$row['place'].' '.$row['date'];
                    break;
            }
            echo '<tr>'; 
            //echo '<td><img width="100" height="100" src="../images/Brabantia.jpg" /></td>';
            if (empty($row['picture'])) {
            	$resized_pic = $this->index_point.'img/212x192.jpg';
            } else {
            	$resized_pic = $AcImageCall->resize($row['picture'], 100, 100, $row['id_shop'], $row['id_product']);
            }
            //$resized_pic = $row['picture'];
            echo '<td><img src="'.$resized_pic.'" /></td>';
            echo '<td>'.$row['id'].'</td>';
            echo '<td>'.$prod_info.'</td>';
            echo '<td>'.$row['price'].' '.$row['id_currency'].'</td>';
            echo '<td>
            <a href="'.$this->index_point.'control/EditProduct?id='.$row['id'].'"><img width="20px" height="20px" src="../images/edit.png" title="редактировать"/></a>
            <a class="delete_prod" href="'.$this->index_point.'control/DeleteProduct?id='.$row['id'].'&url_redirect='.rawurlencode($_SERVER['REQUEST_URI']).'"><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>
            </td>';
            echo '</tr>';
        }
        
        echo '</table>';
        
        //echo '<pre>';
        //print_r($_SERVER);
        //echo '</pre>';
        //echo '<pre>';
        //print_r($products_show);
        //echo '</pre>';
    }
    ?>
    
    <?if (count($pager['data']) > 0 && $pager['total_pages'] > 1) {?>
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
    
    <!--Body content-->
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
.shop_with_cats_tree {
    border:1px dashed black;
    padding-left: 5px;
    margin-bottom: 5px;
}
.span2 .shop_with_cats_tree {
	overflow:auto;
	max-height:400px;
}
.shop_name{
	display:inline-block;
}
.shop_controls{
	display:inline-block;
	position: absolute;
    right: 0;
    top: 0;
}
.shops{
	position:relative;
	margin: 2px;
}
</style>
<script type="text/javascript">

$(document).ready(function(){
	$('a.delete_prod').click(function(){
		if (confirm("Вы подтверждаете удаление товара? Будут удалены связанные с ним изображения, параметры.")) {
			return true;
		} else {
			return false;
		}
	});
});

$(document).ready(function(){
	$('a.delete_cat').click(function(){
		if (confirm("Вы подтверждаете удаление категории? Будут удалены связанные с ней товары а также вложенные категории.")) {
			return true;
		} else {
			return false;
		}
	});
});

$(document).ready(function(){
	$('a.delete_shop').click(function(){
		if (confirm("Вы подтверждаете удаление магазина? Будут удалены связанные с ним категории, товары.")) {
			return true;
		} else {
			return false;
		}
	});
});


</script>
<div class="row">
<aside class="span3">
	<div class="categories">
		<div class="titleHeader clearfix">
			<h3>Категории</h3>
		</div><!--end titleHeader-->
        <ul class="unstyled">
        <?=$merged_cats?>
        </ul>
	</div><!--end categories-->
</aside> 
<div class="span9">
	<div class="row">
		<ul class="hProductItems clearfix">
                <? foreach ($pager['data'] as $row) { 
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
                            //$prod_info = $row['name'].' '.$row['included'].' '.$row['transport'].' '.$row['days'];
                            $prod_info = $row['name'];
                            break;
                        case 'event-ticket':
                            //$prod_info = $row['name'].' '.$row['place'].' '.$row['date'];
                            $prod_info = $row['name'];
                            break;
                    }
                ?>
                <?
                if (empty($row['main_picture'])) {
                    $resized_pic = $this->index_point.'img/212x192.jpg';
                } else {
                	$resized_pic = $AcImageCall->resize($row['main_picture'], 212, 192, $row['id_shop']);
                	if (empty($resized_pic)) {
                		$resized_pic = $this->index_point.'img/212x192.jpg';
                	}
                }
                
                //$row['main_picture'] = $this->index_point.'img/212x192.jpg';
                ?>
    			<li class="span3 clearfix">
    				<div class="thumbnail">
    					<a href="<?=$this->index_point.$row['translit']?>"><img src="<?=$resized_pic?>" alt="" /></a>
    				</div>
    				<div class="thumbSetting">
    					<div class="thumbTitle">
    						<h3>
    						<a href="<?=$this->index_point.$row['translit']?>" class="invarseColor"><?=$product_obj->cutString($prod_info, 50)?></a>
    						</h3>
    					</div>
    					
    					<div class="product-desc">
    						<p>
    							<?=$product_obj->cutString($row['description'], 90)?>
    						</p>
    					</div>
    					<div class="thumbPrice">
    						<span><!--<span class="strike-through">$177.00</span>--><?=$row['price']?> <?=$rus_names_currencies[$row['id_currency']]?></span>
    					</div>
    					<div class="thumbButtons">
							<a target="_blank" class="btn btn-primary btn-small btn-block" href="http://primeadv.go2cloud.org/aff_c?offer_id=<?=$row['offer_id']?>&aff_id=<?=$aff_id['setting_value']?>&url=<?=$row['url']?>">Купить</a>
							
						</div>
    					
    				</div>
    			</li>
                <?}?>			
		</ul>
	</div><!--end row-->
    <?if (count($pager['data']) > 0 && $pager['total_pages'] > 1) {?>
	<div class="pagination pagination-right">
		<span class="pull-left">Показано <?=$pager['current_page']?> из <?=$pager['total_pages']?> страниц:</span>
		<ul>
            <?
            if ($pager['total_pages'] <= 10) {
                
            if ($pager['current_page'] <= 1) {
                $prev = 1;
            } else {
                $prev = $pager['current_page'] - 1;
            }
            ?>
            <li><a class="invarseColor" href="<?=$this->index_point.$_GET['id'].'/?page='.$prev?>">Пред.</a></li>
            <?
            for ($i=1; $i<=$pager['total_pages']; $i++) {
                if ($i == $pager['current_page']) {
                    echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
                } else {
                    echo '<li><a class="invarseColor" href="'.$this->index_point.$_GET['id'].'/?page='.$i.'">'.$i.'</a></li>';
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
            <li><a class="invarseColor" href="<?=$this->index_point.$_GET['id'].'/?page='.$next?>">След.</a></li>
			<?
            } else {
                if ($pager['current_page'] <= 1) {
                    $prev = 1;
                } else {
                    $prev = $pager['current_page'] - 1;
                }
                ?>
                <li><a class="invarseColor" href="<?=$this->index_point.$_GET['id'].'/?page='.$prev?>">Пред.</a></li>
                <?
                for ($i=1; $i<=$pager['total_pages']; $i++) {
                    if ($i == $pager['current_page']) {
                        echo '<li class="active"><a class="invarseColor">'.$i.'</a></li>';
                    } else if (($i > $pager['current_page'] - 2 && $i < $pager['current_page'] + 2) || $i <= 2 || $i >= $pager['total_pages'] - 1) {
                        echo '<li><a class="invarseColor" href="'.$this->index_point.$_GET['id'].'/?page='.$i.'">'.$i.'</a></li>';
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
                <li><a class="invarseColor" href="<?=$this->index_point.$_GET['id'].'/?page='.$next?>">След.</a></li>
    			<?
                }
            ?>
		</ul>
	</div><!--end pagination-->
    <?}?>
</div><!--end span9-->
</div><!--end row-->
<?
//echo '<pre>';
//print_r($_SERVER);
//echo '</pre>';
?>
<style type="text/css">
.hProductItems .thumbSetting .thumbPrice {
    margin-top: 20px;
}
.hProductItems .thumbnail {
	width: 212px;
	height:192px;
}
.hProductItems .thumbSetting div.thumbPrice {
	height:24px;
}
.categories ul.unstyled {
    max-height: 400px;
    overflow: auto;
}
</style>

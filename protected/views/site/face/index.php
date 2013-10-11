<div class="row">
<div class="span12">

	<div id="featuredItems">
		
		<div class="titleHeader clearfix">
			<h3>Новые товары</h3>
			
		</div><!--end titleHeader-->

		<div class="row">
			<ul class="hProductItems clearfix">
				<? foreach ($products_by_new_sign as $row) { 
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
					
					if (empty($row['main_picture'])) {
						$resized_pic = $this->index_point.'img/212x192.jpg';
					} else {
						$resized_pic = $AcImageCall->resize($row['main_picture'], 212, 192, $row['id_shop'], $row['id_product']);
					}
					//$resized_pic = $row['main_picture'];
					
					//$row['main_picture'] = 'img/212x192.jpg';
					//echo $AcImageCall->resize($row['main_picture'], 212, 192);
                ?>
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href="<?=$row['translit']?>"><img src="<?=$resized_pic?>" alt="" /></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="<?=$row['translit']?>" class="invarseColor"><?=$prod_info?></a>
							</h3>
						</div>
						
						<div class="product-desc">
							<p>
								<?=$product_obj->cutString($row['description'], 90)?>
							</p>
						</div>
						<div class="thumbPrice">
							<span><?=$row['price']?> <?=$rus_names_currencies[$row['id_currency']]?></span>
						</div>
						<div class="thumbButtons">
							<a class="btn btn-primary btn-small btn-block" href="<?=$this->index_point.$row['translit']?>">Купить</a>
						</div>
						
					</div>
				</li>
				<?}?>
				
			</ul>
		</div><!--end row-->
	</div><!--end featuredItems-->
</div><!--end span12-->
</div><!--end row-->
<div class="row">
<div class="span12">
	<div id="latestItems">
		
		<div class="titleHeader clearfix">
			<h3>Популярные товары</h3>
			
		</div><!--end titleHeader-->
		

		<div class="row">
			<ul class="hProductItems clearfix" id="cycleFeatured">
				<? foreach ($products_by_spesial_sign as $row) { 
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
					
					if (empty($row['main_picture'])) {
						$resized_pic = $this->index_point.'img/212x192.jpg';
					} else {
						$resized_pic = $AcImageCall->resize($row['main_picture'], 212, 192, $row['id_shop'], $row['id_product']);
					}
					//$resized_pic = $row['main_picture'];
					
					//$row['main_picture'] = 'img/212x192.jpg';
                ?>
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href="<?=$row['translit']?>"><img src="<?=$resized_pic?>" alt="" /></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="<?=$row['translit']?>" class="invarseColor"><?=$prod_info?></a>
							</h3>
						</div>
						
						<div class="product-desc">
							<p>
								<?=$product_obj->cutString($row['description'], 90)?>
							</p>
						</div>
						<div class="thumbPrice">
							<span><?=$row['price']?> <?=$rus_names_currencies[$row['id_currency']]?></span>
						</div>
						<div class="thumbButtons">
							<a class="btn btn-primary btn-small btn-block" href="<?=$this->index_point.$row['translit']?>">Купить</a>
						</div>
					</div>
				</li>
				<?}?>
			</ul>
		</div><!--end row-->
	</div><!--end featuredItems-->
</div><!--end span12-->
</div><!--end row-->
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
</style>

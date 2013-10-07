<?php 
switch ($prod_info['type']) {
	case '':
		$prod_name = $prod_info['name'];
		break;
	case 'vendor.model':
		$prod_name = $prod_info['vendor'].' '.$prod_info['model'];
		break;
	case 'book':
		$prod_name = $prod_info['name'].' '.$prod_info['author'];
		break;
	case 'audiobook':
		$prod_name = $prod_info['name'].' '.$prod_info['author'];
		break;
	case 'artist.title':
		$prod_name = $prod_info['title'];
		break;
	case 'tour':
		//$prod_name = $prod_info['name'].' '.$prod_info['included'].' '.$prod_info['transport'].' '.$prod_info['days'];
		$prod_name = $prod_info['name'];
		break;
	case 'event-ticket':
		//$prod_name = $prod_info['name'].' '.$prod_info['place'].' '.$prod_info['date'];
		$prod_name = $prod_info['name'];
		break;
}
?>
<div class="row">
<div class="span12">
	<div class="row">
		<div class="product-details clearfix">
			<div class="span6">
				<div class="product-title">
					<h1><?=$prod_name?></h1>
				</div>
<?
	if (empty($pictures)){	
    	$pictures = array();	
    	//$pictures[0] = $this->index_point.'img/372x370.jpg';
    	$resized_pic = $this->index_point.'img/372x370.jpg';
	}
?>				
<?	if (count($pictures) > 1) {					
	    if (count($pictures) > 6) {						
	        //array_rand();					
	    	$pictures_side = '';
	    } else {
	    	
	    }				
	    foreach ($pictures as $picture) {
			$resized_pic = $AcImageCall->resize($picture, 68, 60, $prod_info['id_shop']);
	    ?>
					<div class="product-img-thumb-floated">
						<!--<a class="fancybox" href="img/650x700.jpg"><img src="img/68x60.jpg" alt=""></a>-->
						<a class="fancybox" href="<?=$picture?>"><img width="68" height="60" src="<?=$resized_pic?>" alt=""></a>
					</div><!--product-img-thumb-->				
	    <?	
	    }				
    }
    if (!empty($pictures)){
    	$resized_pic = $AcImageCall->resize($pictures[0], 372, 370, $prod_info['id_shop']);
    }
    
    ?>

				<div class="product-img-floated">
					<!--<a class="fancybox" href="img/650x700.jpg"><img src="img/372x370.jpg" alt=""></a>-->					
					<a class="fancybox" href="<?=$pictures[0]?>"><img src="<?=$resized_pic?>" alt=""></a>
				</div><!--end product-img-->
				
			</div><!--end span6-->

			<div class="span6">
				<div class="product-set">
					<div class="product-price">
						<span><?=$prod_info['price']?> <?=$rus_names_currencies[$prod_info['id_currency']]?></span>
						<a target="_blank" class="btn btn-primary" href="http://primeadv.go2cloud.org/aff_c?offer_id=<?=$shop_info['offer_id']?>&aff_id=<?=$aff_id['setting_value']?>&url=<?=$prod_info['url']?>">Купить</a><!--  $aff_id, $shop_info['offer_id']-->
					</div><!--end product-price-->
					
					<div class="product-info">
						<dl class="dl-horizontal">
						
						<?
							echo '<dt>Доступность:</dt>';
							echo '<dd>';
							echo !empty($prod_info['available'])?($prod_info['available'] == 'true'?'Доступно':'Под заказ'):'Доступно';
							echo '</dd>';
							!empty($prod_info['vendor'])?'<dt>Производитель:</dt><dd>'.$prod_info['vendor'].'</dd>':'';
							switch ($prod_info['type']) {
								case 'tour':
									//$prod_name = $prod_info['name'].' '.$prod_info['included'].' '.$prod_info['transport'].' '.$prod_info['days'];
									echo '<dt>Включено:</dt><dd>'.$prod_info['included'].'n</dd>';
									echo '<dt>Транспорт:</dt><dd>'.$prod_info['transport'].'n</dd>';
									echo '<dt>Количество дней:</dt><dd>'.$prod_info['days'].'n</dd>';
									break;
								case 'event-ticket':
									//$prod_name = $prod_info['name'].' '.$prod_info['place'].' '.$prod_info['date'];
									echo '<dt>Место проведения:</dt><dd>'.$prod_info['place'].'n</dd>';
									echo '<dt>Дата и время сеанса:</dt><dd>'.$prod_info['date'].'n</dd>';
									break;
							}
						?>
						  
						  <!--<dt>Manfactuer:</dt>
						  <dd>Nicka Corparation</dd>-->

						   
						</dl>
					</div><!--end product-info-->
					<div class="product-inputs">
						<?=$prod_info['description']?>
					</div><!--end product-inputs-->
				</div><!--end product-set-->
			</div><!--end span6-->

		</div><!--end product-details-->
	</div><!--end row-->


	<!--<div class="product-tab">
		
			<div class="tab-pane" id="specfications">
				<table class="table table-compare">
					
					<!--<tr>
						<td class="aligned-color"><h5>Momery</h5></td>
						<td>16GB</td>
					</tr>-->
				<!--</table>
			</div>
			
	</div>--><!--end product-tab-->


	<!-- <div class="related-product">
		<div class="titleHeader clearfix">
			<h3>Related Product</h3>
		</div>

		<div class="row">
			<ul class="hProductItems clearfix">
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href=""><img src="img/212x192.jpg" alt=""></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="#" class="invarseColor">Prodcut Title Here</a>
							</h3>
						</div>
						<ul class="rating clearfix">
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-off"></i></li>
						</ul>
						<div class="product-desc">
							<p>
								Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
							</p>
						</div>
						<div class="thumbPrice">
							<span><span class="strike-through">$175.00</span>$150.00</span>
						</div>

						<div class="thumbButtons">
							<button class="btn btn-primary btn-small btn-block">
								SELECT OPTION
							</button>
						</div>
					</div>
				</li>
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href=""><img src="img/212x192.jpg" alt=""></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="#" class="invarseColor">Prodcut Title Here</a>
							</h3>
						</div>
						<ul class="rating clearfix">
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-off"></i></li>
						</ul>
						<div class="product-desc">
							<p>
								Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor...
							</p>
						</div>
						<div class="thumbPrice">
							<span><span class="strike-through">$175.00</span>$150.00</span>
						</div>

						<div class="thumbButtons">
							<button class="btn btn-primary btn-small btn-block">
								SELECT OPTION
							</button>
						</div>
					</div>
				</li>
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href=""><img src="img/212x192.jpg" alt=""></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="#" class="invarseColor">Prodcut Title Here</a>
							</h3>
						</div>
						<ul class="rating clearfix">
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-off"></i></li>
						</ul>
						<div class="product-desc">
							<p>
								Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
							</p>
						</div>
						<div class="thumbPrice">
							<span><span class="strike-through">$175.00</span>$150.00</span>
						</div>

						<div class="thumbButtons">
							<button class="btn btn-primary btn-small btn-block">
								SELECT OPTION
							</button>
						</div>
					</div>
				</li>
				<li class="span3 clearfix">
					<div class="thumbnail">
						<a href=""><img src="img/212x192.jpg" alt=""></a>
					</div>
					<div class="thumbSetting">
						<div class="thumbTitle">
							<h3>
							<a href="#" class="invarseColor">Prodcut Title Here</a>
							</h3>
						</div>
						<ul class="rating clearfix">
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-on"></i></li>
							<li><i class="star-off"></i></li>
						</ul>
						<div class="product-desc">
							<p>
								Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
							</p>
						</div>
						<div class="thumbPrice">
							<span><span class="strike-through">$175.00</span>$150.00</span>
						</div>

						<div class="thumbButtons">
							<button class="btn btn-primary btn-small btn-block">
								SELECT OPTION
							</button>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>--><!--end related-product-->

</div><!--end span12-->
</div><!--end row-->
<style type="text/css">
.table-compare td.aligned-color {
    text-align: center;
}
</style>

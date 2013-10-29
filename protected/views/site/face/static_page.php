<div class="row">
	<div class="span9">
		<article class="blog-article">
			<div class="blog-img">
				<?
				if (empty($staticPageInfo['picture'])) {
					$resized_pic = $this->index_point.'img/694x246.jpg';
				} else {
					$resized_pic = $AcImageCall->resize_simple($_SERVER['DOCUMENT_ROOT'].$staticPageInfo['picture'], 694, 246);
					if (empty($resized_pic)) {
						$resized_pic = $this->index_point.'img/694x246.jpg';
					}
				}
				?>
				<img src="<?=$resized_pic?>" alt="">
			</div><!--end blog-img-->
		
			<div class="blog-content">
				<div class="blog-content-title">
					<h1><?=$staticPageInfo['title']?></h1>
				</div>
				
				<div class="blog-content-entry">
					<?=$staticPageInfo['content']?>
				</div>
			</div><!--end blog-content-->
		</article><!--end article-->
	</div>
</div>
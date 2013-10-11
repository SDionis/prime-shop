<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?=$this->title?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?=$this->index_point?>css/bootstrap.min.css" media="screen" />
	<!-- jquery ui css -->
	<link rel="stylesheet" href="<?=$this->index_point?>css/jquery-ui-1.10.1.min.css" />
	<link rel="stylesheet" href="<?=$this->index_point?>css/customize.css" />
	<link rel="stylesheet" href="<?=$this->index_point?>css/font-awesome.css" />
	<link rel="stylesheet" href="<?=$this->index_point?>css/style.css" />
	<!-- fancybox -->
	<link rel="stylesheet" href="<?=$this->index_point?>js/fancybox/jquery.fancybox.css" />
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
		<link rel="stylesheet" href="css/font-awesome-ie7.css">
	<![endif]-->
	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?=$this->index_point?>images/favicon.ico" />
	<link rel="apple-touch-icon" href="<?=$this->index_point?>images/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?=$this->index_point?>images/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?=$this->index_point?>images/apple-touch-icon-114x114.png" />
    <style type="text/css">
        body {
            background: url("<?=$this->index_point?>img/backgrounds/foggy_birds.png") repeat scroll left top #FFFFFF !important;
        }
		h3 {
            background: 0 !important;
        }
        .titleHeader {
			background: 0 !important;

			}
		.navbar .nav li:hover ul {
        	max-height:300px;
        	overflow:auto;
        }
    </style>
    
    <script type="text/javascript">
    
	<?=!empty($this->counts['google_analitics'])?$this->counts['google_analitics']:''?>
	
    </script>
</head>

<body>
    <div id="wrapper">
    <!--begain header-->
    <header>
    
    <div class="subHeader">
		<div class="container">
			<div class="navbar">

				<div class="siteLogo pull-left">
					<h1><a href="<?=$this->index_point_without_slash?>"><img src="<?=$this->index_point?>img/logo.png" alt="Shoppest" /></a></h1>
				</div>
			    
		      	<ul class="nav">
		      		<li class="active"><a href="<?=$this->index_point_without_slash?>"><i class="icon-home"></i></a></li>
		      		<?
                    if (!empty($this->out_menu)) {
			      		$i=0;
			      		if (count($this->out_menu) > 6) {
			      			$j=0;
	                    	foreach ($this->out_menu as $key => $row) {
								if ($j == 5) {
									echo '<li><a href="#">Другое<i class="icon-caret-down"></i></a><ul>';
								}
								if ($j >= 5 || ($j + 1) < count($this->out_menu)) {
									echo '<li><a href="'.$row['link'].'">'.$row['name'].'</a></li>';
								}
								if (($j + 1) == count($this->out_menu)) {
									echo '</ul></li>';
								}
								$j++;
								
	                    	}
	                    } else {
	                    	foreach ($this->out_menu as $key => $row) {
								echo '<li><a href="'.$row['link'].'">'.$row['name'].'</a></li>';
							}
	                    }
                    }
		      		?>
		      		<!--<li>
		      			<a href="#">Pages &nbsp;<i class="icon-caret-down"></i></a>
		      			<div>
			      			<ul>
			      				<li><a href="index.html"> <span>-</span> index1</a></li>
			      				<li><a href="index2.html"> <span>-</span> index2</a></li>
			      				<li><a href="account.html"> <span>-</span> account</a></li>
			      				<li><a href="login.html"> <span>-</span> login</a></li>
			      				<li><a href="register.html"> <span>-</span> register</a></li>
			      				<li><a href="cart.html"> <span>-</span> Cart</a></li>
			      				<li><a href="wishlist.html"> <span>-</span> wishlist</a></li>
			      				<li><a href="checkout.html"> <span>-</span> Checkout</a></li>
			      				<li><a href="compare.html"> <span>-</span> Compare</a></li>
			      				<li><a href="contact.html"> <span>-</span> Contact</a></li>
			      				<li><a href="search.html"> <span>-</span> Search</a></li>
			      				<li><a href="blog.html"> <span>-</span> blog</a></li>
			      				<li><a href="blog2.html"> <span>-</span> blog 2</a></li>
			      				<li><a href="post.html"> <span>-</span> post</a></li>
			      				<li><a href="category_grid.html"> <span>-</span> category grid</a></li>
			      				<li><a href="category_list.html"> <span>-</span> category list</a></li>
			      				<li><a href="product_details.html"> <span>-</span> product details 1</a></li>
			      				<li><a href="product_details2.html"> <span>-</span> product details 2</a></li>
			      				<li><a href="product_details3.html"> <span>-</span> product details 3</a></li>
			      			</ul>
			      		</div>
		      		</li>-->
                    <!--<li><a href="/">Категории</a></li>-->
		      	</ul><!--end nav-->

				</div>
			</div><!--end container-->
		</div><!--end subHeader-->
	</header>
    </div>
    <div class="container">
	   
<?php echo $content; ?>
        
    </div><!--end conatiner-->
    <footer>
        <div class="container">
			<div class="row">
				<div class="span12">
					<!--<ul class="payments inline pull-right">
						<li class="visia"></li>
						<li class="paypal"></li>
						<li class="electron"></li>
						<li class="discover"></li>
					</ul>-->
					<!--<p>© Copyrights 2012 for <a href="<?=$this->index_point?>">shoppest.com</a></p>-->
				</div>
			</div>
		</div>
    </footer>
	<!-- JS
	================================================== -->
	<script src="<?=$this->index_point?>js/jquery-1.9.1.min.js"></script>
	<script src="<?=$this->index_point?>js/jquery-ui-1.10.2.min.js"></script>
	<!-- bootstrap -->
    <script src="<?=$this->index_point?>js/bootstrap.min.js"></script>
	<!-- jQuery.Cookie -->
	<script src="<?=$this->index_point?>js/jquery.cookie.js"></script>
    <!-- fancybox -->
    <script src="<?=$this->index_point?>js/fancybox/jquery.fancybox.js"></script>
    <!-- jquery.tweet -->
    <script src="<?=$this->index_point?>js/jquery.tweet.js"></script>
    <!-- custom function-->	<script>		var base_url = '<?=$this->index_point?>';	</script>
    <script src="<?=$this->index_point?>js/custom.js"></script>
    
    <script type="text/javascript">
    
	<?=!empty($this->counts['yandex_metrika'])?$this->counts['yandex_metrika']:''?>
	
    </script>
</body>

</html>
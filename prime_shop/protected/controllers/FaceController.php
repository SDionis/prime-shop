<?

class FaceController extends Controller {
    public $menu;	
    public $out_menu;
    public $index_point;
    public $title;
    public $index_point_without_slash;
    public function __construct(){
        $index_point = explode('index.php', $_SERVER['SCRIPT_NAME'], 2);
        $this->index_point = $index_point[0];
        $index_point_without_slash = explode('/index.php', $_SERVER['SCRIPT_NAME'], 2);
        $this->index_point_without_slash = $index_point_without_slash[0];
        Yii::app()->layout = 'face';
        $this->layout = 'face';
        //require_once($_SERVER['DOCUMENT_ROOT'].$index_point[0].'libs/AcImage/AcImage.php');
        session_start();
        
        chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
        if ($conf_file = file('conf.conf')) {
        	foreach ($conf_file as $conf_file_option) {
        		$conf_db_file_option_parts = explode(':', $conf_file_option);
        		$conf_file_option = rtrim($conf_file_option);
        		if ($conf_db_file_option_parts[0] == 'is_install' && $conf_db_file_option_parts[1] == 1) {
        			//$_SESSION['install_key'] = md5(time());
        			header('Location: '.Yii::app()->request->baseUrl.'/install');
        			exit;
        		}
        	}
        }
        
        $shop = new Shop();
        $catalog = new Catalog();
        
        $settings = new Settings();
        $my_shop_name = $settings->get_setting_by_setting_name('aff_id');
        if (empty($my_shop_name['setting_value'])) {
        	echo 'Отсутствует affilate ID';
        	exit;
        }
        $shops_all_info = $shop->get_shops_all_info();
        foreach($shops_all_info as $shop_all_info){
        	if (empty($shop_all_info['offer_id'])) {
        		echo 'Отсутствует offer ID у одного или нескольких магазинов';
        		exit;
        		break;
        		exit;
        	}
        }
        
        $shops_ids = $shop->get_shops_ids();
        $menu2 = array();
        foreach ($shops_ids as $id) {
        	$min_parent_by_shop = $catalog->get_min_parent_by_shop($id);
        	$min_parent_by_shop = (int) $min_parent_by_shop;
        	$menu2[] = $catalog->menu2($min_parent_by_shop, $id, 0);
        	
        }
        
        $arr_merge = array();
        foreach ($menu2 as $val) {
        	if (empty($arr_merge)) {
        		$arr_merge = $val;
        	} else {
        		$arr_merge = array_merge_recursive($arr_merge, $val);
        	}
        }
        $out_menu = array();
        if (count($arr_merge) <= 2) {
        	foreach ($arr_merge as $key => $row) {
        		
        		foreach ($row['childs'] as $key2 => $row2) {
        			$out_menu[$key2]['name'] = $row2['name'];
        			$out_menu[$key2]['link'] = $this->index_point.$key.'/'.$key2;;
        		}
        	}
        } else {
        	foreach ($arr_merge as $key => $row) {
        		$out_menu[$key]['name'] = $row['name'];
        			$out_menu[$key]['link'] = $this->index_point.$key;
        	}
        }
        
        $this->out_menu = $out_menu;
        
    }
    public function actionIndex() {
    	    	
    	$AcImageCall = new AcImageCall();

        $settings = new Settings();
        $my_shop_name = $settings->get_setting_by_setting_name('shop_name');
        $this->title = 'Интернет-магазин '.$my_shop_name['setting_value'];
    	$product = new Product();
    	$product_ids = $product->get_product_ids();
    	if (!empty($product_ids)) {
	    	$products_by_new_sign = $product->get_products_by_new_sign();
	    	if (empty($products_by_new_sign)) {
	    		$products_by_new_sign = array();
	    	}
	    	$products_by_new_sign_amount = count($products_by_new_sign);
	    	if ($products_by_new_sign_amount < 4) {
	    		$leak_amount = 4 - $products_by_new_sign_amount;
	    		$rand_keys = array_rand($product_ids, $leak_amount);
	    		if ($leak_amount == 1) {
	    			$rand_keys = array(0 => $rand_keys);
	    		}
	    		$ids = array();
	    		foreach ($rand_keys as $rand_key) {
	    			$ids[] = $product_ids[$rand_key];
	    			unset($product_ids[$rand_key]);
	    		}
	    		$products_by_new_sign_rand = $product->get_products_by_ids($ids);
	    		foreach ($products_by_new_sign_rand as $key => $row){
	    			$products_by_new_sign[] = $row;
	    		}
	    		
	    	}
	    	
	    	$products_by_spesial_sign = $product->get_products_by_spesial_sign();
	    	if (empty($products_by_spesial_sign)) {
	    		$products_by_spesial_sign = array();
	    	}
	    	$products_by_spesial_sign_amount = count($products_by_spesial_sign);
	    	if ($products_by_spesial_sign_amount < 4) {
	    		$leak_amount = 4 - $products_by_spesial_sign_amount;
	    		$rand_keys = array_rand($product_ids, $leak_amount);
	    		if ($leak_amount == 1) {
	    			$rand_keys = array(0 => $rand_keys);
	    		}
	    		$ids = array();
	    		foreach ($rand_keys as $rand_key) {
	    			$ids[] = $product_ids[$rand_key];
	    			unset($product_ids[$rand_key]);
	    		}
	    		$products_by_spesial_sign_rand = $product->get_products_by_ids($ids);
	    		foreach ($products_by_spesial_sign_rand as $key => $row){
	    			$products_by_spesial_sign[] = $row;
	    		}
	    	
	    	}
	    	
	        $product = new Product();
	        $rus_names_currencies =  $product->get_rus_names_currencies();
	        $this->render('site/face/index', 
		        array(
		            'product_obj' => $product,
		        	'AcImageCall' => $AcImageCall,
		            'products_by_new_sign' => $products_by_new_sign, 
		            'products_by_spesial_sign' => $products_by_spesial_sign,
		        	'rus_names_currencies' => $rus_names_currencies,	        		
		        )
	        );
    	}
    }  
    
    public function actionShowCatsOrProd(){
    	$AcImageCall = new AcImageCall();
        header('Content-type: text/html; charset=utf-8');
        $translit = $_GET['id'];
        $shop = new Shop();
        $catalog = new Catalog();
        $product = new Product();
        $settings = new Settings();
        $my_shop_name = $settings->get_setting_by_setting_name('shop_name');
        //$this->redirect(Yii::app()->createUrl("catalog/index"));
        
        $url_parts = explode('/', $_GET['id']);
        
        $info_by_first_translit = $catalog->select_info_by_first_translit($url_parts[0]);
        $is_category = 0;
        $is_product = 0;
        $all_parents = array($url_parts[0]);
        if (count($url_parts) == 1) {
            if ($catalog->catalog_exists_by_translit($translit) > 0) {
                $is_category = 1;
            } else if ($product->product_exists_by_translit($translit) > 0) {
                $is_product = 1;
            }
        } else if (count($url_parts) > 1) {
            $cat_info_by_translit = $catalog->select_cat_info_by_translit($url_parts,array('id_category' => $info_by_first_translit['id_category'], 'id_shop' => $info_by_first_translit['id_shop']));
            if (!empty($cat_info_by_translit[count($cat_info_by_translit)-1])) {
                $translit = $cat_info_by_translit[count($cat_info_by_translit)-1]['translit'];
                $is_category = 1;
                foreach ($cat_info_by_translit as $cat_info_by_translit_val) {
                    $all_parents[] = $cat_info_by_translit_val['translit'];
                }
                $all_parents = array_merge($all_parents);
            }
        }
        
        
        //echo gettype($url_parts[count($url_parts)-1]);
        //echo $url_parts[count($url_parts)-1];
        //echo preg_match('/^[0-9]$/',$url_parts[count($url_parts)-1]);
        
        //echo '<pre>';
        //print_r($all_parents);
        //echo '</pre>';
        
        
        //if ($catalog->catalog_exists_by_translit($translit) > 0) {
        $rus_names_currencies =  $product->get_rus_names_currencies();
        
        if ($is_category == 1) {
            
	        $shops_ids = $shop->get_shops_ids();
	        $shops_all_info = $shop->get_shops_all_info();
            
	        $shops_id_to_info = array();
	        foreach ($shops_all_info as $res) {
	            $shops_id_to_info[$res['id']]['name'] = $res['name'];				
	            $shops_id_to_info[$res['id']]['company'] = $res['company'];
	        }
	        
	        $out = array();
	        
	        foreach ($shops_ids as $id) {
	            $catalog_for_tree = $catalog->get_catalog_for_tree_with_cat_alt($id);				
                $min_parent = $catalog->select_min_parent($id);
	            $tree = $catalog->tree($catalog_for_tree, $min_parent, $id);
	            $out[] = $catalog->get_tree_from_array($tree);
	        }
            
	        $arr_merge = array();
	        foreach ($out as $val) {
	            if (empty($arr_merge)) {
	                $arr_merge = $val;
	            } else {
	                $arr_merge = array_merge_recursive($arr_merge, $val);
	            }
	        }
	        
	        //$cats_by_translit = $catalog->get_categories_by_translit($translit);
	        //$all_parents = $catalog->get_all_parents($cats_by_translit[0]['id_category_parent'], $cats_by_translit[0]['id_shop']);
            //echo '<pre>';
            //print_r($arr_merge);
            //echo '</pre>';
	        //$all_parents = array_merge($all_parents, array($translit));
            //print_r($all_parents);
	        $merged_cats = $catalog->display_merged_cats($arr_merge, $all_parents, $this->index_point, array(), $translit);
	        
	        //$cats_by_translit_arr = $catalog->get_categories_by_translit_array($all_parents);
	        $cats_by_translit = $catalog->get_cat_info_by_ids($_SESSION['category_ids']);
            unset($_SESSION['category_ids']);
            $cat_name = $_SESSION['cat_name'];
            $this->title = $cat_name.' - купить по лучшей цене в магазине '.$my_shop_name['setting_value'];
            unset($_SESSION['cat_name']);
	        $all_childs = array();
	        $category_ids = array();
	        foreach ($cats_by_translit as $cat_by_translit) {
	        	$all_childs = $catalog->get_all_childs($cat_by_translit['id_category'], $cat_by_translit['id_shop']);
	        	$category_ids[] = $cat_by_translit['id'];
	        }
	        foreach ($all_childs as $row) {
	        	$category_ids[] = $row['id'];
	        }
        
            !empty($_GET['page']) ? $page = (int) $_GET['page'] : $page = 1;
            //print_r($_SESSION['category_ids']);
            //print_r($category_ids);
            $pager = $product->pager($page, 9, $category_ids);
            
            
            $this->render('site/face/products', array(
            'merged_cats' => $merged_cats, 
            'product_obj' => $product,
            //'all_parents' => $all_parents,
            'category_ids' => $category_ids,
            'pager' => $pager,
            'AcImageCall' => $AcImageCall,
            'rus_names_currencies' => $rus_names_currencies,
            ));
        //} else if ($product->product_exists_by_translit($translit) > 0){
        } else if ($is_product == 1){
            
            $prod_info = $product->get_product_by_translit($translit);
            $pictures = $product->get_pictures_by_product($prod_info['id']);
            $cat_info = $product->get_cat_info_by_prod_info($prod_info['id_category'], $prod_info['id_shop']);
            $prod_name = $product->get_prod_name($prod_info);
            
            $this->title = $cat_info['cat_name'].' '.$prod_name.' купить по лучшей цене в магазине '.$my_shop_name['setting_value'];
            $settings =new Settings();
            $aff_id = $settings->get_setting_by_setting_name('aff_id');
            $shop_info = $shop->get_shop_by_id($prod_info['id_shop']);
            $this->render('site/face/product', array(
                'prod_info' => $prod_info,
            	'pictures' => $pictures,
                'product_obj' => $product,
            	'AcImageCall' => $AcImageCall,
            	'rus_names_currencies' => $rus_names_currencies,
            	'aff_id' => $aff_id,
            	'shop_info' => $shop_info,
            ));
        } else {
        	echo 'not found';
        }
        
    }
    
    public function actionShowProduct(){
        //echo 'Product';
    }
}

?>
<?php

class ControlController extends Controller
{
	public $index_point;
	public $with_hashing;
    public function __construct(){
		$index_point = explode('index.php', $_SERVER['SCRIPT_NAME'], 2);
		$this->index_point = $index_point[0];
        Yii::app()->layout = 'control';
        $this->layout = 'control';
        //$this->with_hashing = 1;
        session_start();
        
        chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
        if ($conf_file = file('conf.conf')) {
        	foreach ($conf_file as $conf_file_option) {
        		$conf_file_option = rtrim($conf_file_option);
        		$conf_db_file_option_parts = explode(':', $conf_file_option);
        		if ($conf_db_file_option_parts[0] == 'is_install' && $conf_db_file_option_parts[1] == 1) {
        			//$_SESSION['install_key'] = md5(time());
        			header('Location: '.Yii::app()->request->baseUrl.'/install');
        			exit;
        		}
        	}
        }
        
        //echo '<pre>';
        //print_r(file('conf.conf'));
        //echo '</pre>';
        
        
		//$url1 = explode('/control/', $_SERVER['REDIRECT_URL']);
		//$url2 = explode('/', $url1[1]);
		
		//if (empty($_SESSION['login']) && $url2[0] != 'login') {
	       //$this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
		//} else {
	       //$this->redirect($this->createUrl(Yii::app()->controller->id.'/control/ShowCatalog'));
	    //}
	   
        //unset($_SESSION['login']);
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
        //header('Content-type: text/html; charset=utf-8');
        //echo '<pre>';
        //print_r($_SERVER);
        //echo '</pre>';
    }
    
	public function actionIndex()
	{
	   if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	   } else {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/ShowCatalog'));
	   }
	   	   
	   //$this->redirect($this->createUrl(Yii::app()->controller->id.'/control/ShowCatalog'));
       //echo '<pre>';
       //print_r(Yii::app()->controller->id);
       //echo '</pre>';
	   //echo 'index';
		//$this->render('index');
	}
    
    public function actionLogin(){
    	$nonce = '';
    	if (!empty($this->with_hashing)) {
	        $nonce=mt_rand(1, 10000000); 
	        $nonce=md5($nonce); 
	        $_SESSION['nonce']=$nonce; 
    	}
        //echo 'Login';
        //echo Yii::app()->layout;
        //$parser = new YMLParser();
        //$parser->parse('YML.xml');
        //$this->render('site/login_my');
        //echo date('Y-m-d H:m:s', strtotime('2005-08-09T18:31:42'));
        $this->render('site/login_admin', array('nonce' => $nonce));
    }
    
    public function actioncheckLogin(){
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        //echo '<pre>';
        //print_r($_SESSION);
        //echo '</pre>';
        if(!empty($_POST)) {
            $test_login = 'admin';
            $test_pass = 'kulik12345';
            $test_pass = '12345678';
            //echo md5(md5($test_pass).$_SESSION['nonce']);
            //echo '<br />'.$_POST['password'];
            $check_pass = $test_pass;
            if (!empty($this->with_hashing)) {
            	$check_pass = md5(md5($test_pass).$_SESSION['nonce']);
            }
            //echo $_POST['password'];
            //echo '<br />__<br />';
            //echo $check_pass;
            if ($_POST['login'] == $test_login && $_POST['password'] == $check_pass) {
                $_SESSION['login'] = $_POST['login'];
                //unset($_SESSION['login']);
                $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/ShowCatalog'));
                exit;
            } else {
                $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
                exit;
            }
        }
    }
    
    public function actionUploadXML(){
		if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
        //header('Content-type: text/html; charset=utf-8');
		$parser = new YMLParser();
        if (!empty($_FILES) && $_FILES['uploadFile']['error'] == 0 && !empty($_FILES['uploadFile']['tmp_name'])) {
        	$offer_id = $_POST['offer_id'];
            $parser->parse($_FILES['uploadFile']['tmp_name'], $offer_id);
            $_SESSION['success_mess'] = 1;
        }
		if (empty($_FILES) && !empty($_POST) && $_POST['ymlftp'] == 1){
			$filename = $_SERVER['DOCUMENT_ROOT'].$this->index_point.'ymlftp/'.$_POST['xml_file'];
			if (file_exists($filename)) {
				$offer_id = $_POST['offer_id'];
				$parser->parse($filename, $offer_id);
				$_SESSION['success_mess'] = 1;
			}
		}
        $files = scandir($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/ymlftp');
        $xmls = array();
        foreach ($files as $row) {
        	$file = explode('.', $row);
        	if (count($file) == 2 && $file[1] == 'xml') {
        		$xmls[] = $file[0].'.'.$file[1];
        	}
        }
        //print_r($files);
        
        $this->render('site/uploadXML', array('xmls' => $xmls, 'success_mess' => !empty($_SESSION['success_mess'])?$_SESSION['success_mess']:''));
        unset($_SESSION['success_mess']);
    }
    
    public function actionShowCatalog(){
    	$AcImageCall = new AcImageCall();
        if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        $shop = new Shop();
        $shops_ids = $shop->get_shops_ids();
        if (empty($shops_ids)) {
        	$this->redirect($this->createUrl(Yii::app()->controller->id.'/control/UploadXML'));
        }
        header('Content-type: text/html; charset=utf-8');
        $shops_all_info = $shop->get_shops_all_info();
        
        $shops_id_to_info = array();
        foreach ($shops_all_info as $res) {
            $shops_id_to_info[$res['id']]['name'] = $res['name'];
            $shops_id_to_info[$res['id']]['company'] = $res['company'];
        }
        
        $catalog = new Catalog();
        
        $out = array();
        //$out = $catalog->tree_multiple_queries(0, 0, 7);
        foreach ($shops_ids as $id) {
            $catalog_for_tree = $catalog->get_catalog_for_tree($id);
			$min_parent = $catalog->select_min_parent($id);
			//echo '<pre>';
			//print_r($catalog_for_tree);
			//echo '</pre>';
            $out[$id] = $catalog->tree($catalog_for_tree, $min_parent, $id);
			//echo '<pre>';
			//print_r($out[$id]);
			//echo '</pre>';
        }
        
        //$catalog_for_tree2 = $catalog->get_catalog_for_tree(7);
        //$out2 = $catalog->tree($catalog_for_tree2, 0, 7);
        
        //$catalog_for_tree3 = $catalog->get_catalog_for_tree(8);
        //$out3 = $catalog->tree($catalog_for_tree3, 0, 8);
        
        //$out22 = $catalog->get_tree_from_array($out2);
        //$out33 = $catalog->get_tree_from_array($out3);
        
        //echo '<pre>';
        //print_r($out);
        //echo '</pre>';
        
        //echo '<pre>';
        //print_r(array_merge_recursive($out2, $out3));
        //print_r($out2);
        //echo '</pre>';
        !empty($_GET['page']) ? $page = (int) $_GET['page'] : $page = 1;
        $product = new Product();
        $products_show = array();
        if (empty($_GET['id_cat']) || empty($_GET['id_shop'])) {
            $first_shop_id = $shop->get_first_shop_id();
            $first_category_id = $catalog->get_first_category_id_by_shop($first_shop_id);
            $_GET['id_shop'] = $first_shop_id;
            $_GET['id_cat'] = $first_category_id;
            //$products_show = $product->get_products_by_category($_GET['id_cat'], $_GET['id_shop']);
            $pager = $product->get_products_by_category_with_pager($page, 10, $_GET['id_cat'], $_GET['id_shop']);
            $products_show = $pager['data'];
        } else {
            //$products_show = $product->get_products_by_category($_GET['id_cat'], $_GET['id_shop']);
        	$pager = $product->get_products_by_category_with_pager($page, 10, $_GET['id_cat'], $_GET['id_shop']);
        	$products_show = $pager['data'];
        }
        //print_r($products_show);
        //exit;
        foreach ($products_show as $key => $row) {
            $picture = $product->get_main_picture($row['id']);
            $products_show[$key]['picture'] = $picture;
        }
        //count($products_show);exit;
        $current_category_info = $catalog->get_cat_info_by_id_shop_and_id_cat((int) $_GET['id_cat'], (int) $_GET['id_shop']);
        //echo '<pre>';
        //print_r($out);
        //echo '</pre>';
        $this->render('site/Catalog', array(
            'current_category_info' => $current_category_info,
            'out' => $out, 
            'shops_id_to_info' => $shops_id_to_info, 
            'products_show' => $products_show,
        	'pager' => $pager,
        	'product' => $product,
        	'AcImageCall' => $AcImageCall,
        ));
    }
    
    public function actionEditProduct(){
		if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        header('Content-type: text/html; charset=utf-8');
        
        if (!empty($_POST) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            $product = new Product();
            $product->updateProduct((int) $_GET['id'], $_POST);
            
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        $product = new Product();
        $catalog = new Catalog();
        $current_product = $product->get_product_by_id((int) $_GET['id']);
        $currencies = $product->get_currencies();
        $categories = $catalog->get_categories_inside_shop($current_product['id_shop']);
        $pictures = $product->get_pictures_by_product($current_product['id']);
        $param = $product->get_param_by_product($current_product['id']);
        $barcode = $product->get_barcode_by_product($current_product['id']);
        $dataTour = $product->get_dataTour_by_product($current_product['id']);
        $types = array(
            0 => 'Упрощенное описание',
            'vendor.model' => 'Произвольный товар',
            'book' => 'Книги',
            'audiobook' => 'Аудиокниги',
            'artist.title' => 'Музыкальная и видео продукция',
            'tour' => 'Туры',
            'event-ticket' => 'Билеты на мероприятие',
        );
        
        $output_array = array(
            'current_product' => $current_product,
            'currencies' => $currencies,
            'categories' => $categories,
            'pictures' => $pictures,
            'param' => $param,
            'barcode' => $barcode,
            'dataTour' => $dataTour,
            'types' => $types,
        );
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if ($_POST['option_type'] == 'change_type') {
                $current_product['type'] = $_POST['option_val'];
                $output_array = array(
                    'current_product' => $current_product,
                    'currencies' => $currencies,
                    'categories' => $categories,
                    'pictures' => $pictures,
                    'param' => $param,
                    'barcode' => $barcode,
                    'dataTour' => $dataTour,
                    'types' => $types,
                );
                $this->renderPartial('site/editProduct', $output_array);
            }
            exit;
        }
        $this->render('site/editProduct', $output_array);
    }
    
    public function actionEditCategory() {
		if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        if (!empty($_POST) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            
            $catalog = new Catalog();
            $catalog->updateCatalog((int) $_GET['id'], $_POST);
            
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        $catalog = new Catalog();
        $shop = new Shop();
        
        $cat_info = $catalog->get_cat_info_by_id((int) $_GET['id']);
        $shop_info = $shop->get_shop_by_id($cat_info['id_shop']);
        
        $output_array = array('cat_info' => $cat_info, 'shop_info' => $shop_info);
        
        $this->render('site/editCategory', $output_array);
    }
    
    public function actionAlternativeCategories(){
		if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        $catalog = new Catalog();
        if (!empty($_GET['del_id']) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $catalog->deleteCategoriesAlternativeById($_GET['del_id']);
            $catalog->updateCatalogByCatIdAlt(array($_GET['del_id']));
            header('Location: '.$_SERVER['REDIRECT_URL']);
        }
        if (!empty($_POST) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            
            $insert_array = array();
            foreach ($_POST as $key => $val) {
                if ($key == 'cat_name') {
                    foreach ($val as $key2 => $val2) {
                        $insert_array[$key2]['cat_name'] = $val2;
                    }
                    
                } else if ($key == 'cat_link') {
                    foreach ($val as $key2 => $val2) {
                        $insert_array[$key2]['ids'] = $val2;
                    }
                }
            }
            $yml_parser = new YMLParser();
            
            $catalog->deleteCategoriesAlternative();
            $catalog->updateCatalogGeneral('all', array('id_cat_alternative' => 0));
            foreach ($insert_array as $key => $val) {
                foreach ($val as $key2 => $val2) {
                    if ($key2 == 'cat_name') {
                        $translit = $yml_parser->translit(trim($val2));
                        $idCategoryAlternative = $catalog->insertIntoCategoriesAlternative(array('name' => $val2, 'translit' => $translit));
                    } else if ($key2 == 'ids') {
                    	if (gettype($idCategoryAlternative) == 'integer') {
                    		$catalog->updateCatalogGeneral($val2, array('id_cat_alternative' => $idCategoryAlternative));
                    	}
                        
                    }
                    
                }
            }
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        $shop = new Shop();
        $shops_ids = $shop->get_shops_ids();
        
        $shops_all_info = $shop->get_shops_all_info();
        $shops_id_to_info = array();
        foreach ($shops_all_info as $res) {
            $shops_id_to_info[$res['id']]['name'] = $res['name'];
            $shops_id_to_info[$res['id']]['company'] = $res['company'];
        }
        
        $catalog = new Catalog();
        
        $out = array();
        //$out = $catalog->tree_multiple_queries(0, 0, 7);
        foreach ($shops_ids as $id) {
            $catalog_for_tree = $catalog->get_catalog_for_tree($id);
			$min_parent = $catalog->select_min_parent($id);
            $out[$id] = $catalog->tree($catalog_for_tree, $min_parent, $id);
            $tree_from_array_for_option = $catalog->get_tree_from_array_for_option($out[$id], 0);
            $get_array_from_tree_for_option[$shops_id_to_info[$id]['name'].', '.$shops_id_to_info[$id]['company']] = $catalog->get_array_from_tree_for_option($tree_from_array_for_option);
        }
        
        $categoriesAlternative = $catalog->getCategoriesAlternative();
        
        $restricted_cats = $catalog->get_cats_with_link_to_cats_alt();
        
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if ($_POST['option_type'] == 'getCategoriesAlternative') {
                foreach($get_array_from_tree_for_option as $key2 => $val2) {
                    echo '<option style="color:red;" value="'.$key2.'">'.$key2.'</option>';
                    foreach($val2 as $key3 => $val3) {
                        if (in_array($key3, $restricted_cats)) {
                            echo '<option style="background: yellow;" disabled="disabled" value="0">'.$val3.'</option>';
                        } else {
                            echo '<option value="'.$key3.'">'.$val3.'</option>';
                        }
                    }
                }
                //$this->renderPartial('site/editProduct', $output_array);
            }
            exit;
        }
        //echo '<pre>';
        //print_r(array_merge($tt[0], $tt[1]));
        //echo '</pre>';
        
        $output_array = array(
            'out' => $out, 
            'categoriesAlternative' => $categoriesAlternative, 
            'get_array_from_tree_for_option' => $get_array_from_tree_for_option,
            'restricted_cats' => $restricted_cats
        );
        
        $this->render('site/AlternativeCategories', $output_array);
    }
    
    public function actionEditShop() {
		if (empty($_SESSION['login'])) {
	       $this->redirect($this->createUrl(Yii::app()->controller->id.'/control/login'));
	    }
	    $settings = new Settings();
	    $aff_id = $settings->get_setting_by_setting_name('aff_id');
	    if (empty($aff_id['setting_value'])) {
	    	header('Location: '.$this->index_point.'control/Settings?mess=1');
	    }
        if (!empty($_POST) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $shop = new Shop();
            $shop->updateShop((int) $_GET['id'], $_POST);
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        $shop = new Shop();
        $shop_info = $shop->get_shop_by_id((int) $_GET['id']);
        $output_array = array('shop_info' => $shop_info);
        
        $this->render('site/EditShop', $output_array);
    }
    
    public function actionDeleteProduct(){
    	$product = new Product();
    	$product->delete_product($_GET['id']);
    	header('Location: '.$_GET['url_redirect']);
    	//header('Location: '.$this->index_point.'control');
    }
    
    public function actionDeleteCategory(){
    	$catalog = new Catalog();
    	$next_category = $catalog->get_next_category_on_same_level($_GET['id_cat'], $_GET['id_shop']);
    	$catalog->delete_catalog($_GET['id_cat'], $_GET['id_shop']);
    	header('Location: '.$this->index_point.'control/ShowCatalog?id_cat='.$next_category['id_category'].'&id_shop='.$next_category['id_shop']);
    }
    
    public function actionDeleteShop(){
    	$shop = new Shop();
    	$id_shop = (int) $_GET['id_shop'];
    	$shop->deleteShop($id_shop);
    	
    	header('Location: '.$this->index_point.'control');
    }
    
    public function actionSettings(){
        $settings = new Settings();
        $setting_names = array('shop_name', 'aff_id');
        if (!empty($_POST) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $settings->update_settings($_POST);
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        $setting_info = $settings->get_settings($setting_names);
        $output_array = array('setting_info' => $setting_info);
        $this->render('site/Settings', $output_array);
    }
    
	public function actionLogin2()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionAdminLogout()
	{
		//Yii::app()->user->logout();
		unset($_SESSION['login']);
		$this->redirect(Yii::app()->homeUrl.'/control');
	}
    
    public function actionDownloadAllImages(){
        $parser = new YMLParser();
        $message = '';
        
        if (!empty($_GET) && empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_GET['execute'] == 1) {
            $DownloadAllImages = $parser->DownloadAllImages();
            $_SESSION['message_ok'] = 'ok';
            header('Location: '.$_SERVER['REDIRECT_URL']);
            exit;
        }
        if (!empty($_SESSION['message_ok'])) {
            $message = $_SESSION['message_ok'];
            unset($_SESSION['message_ok']);
        }
        //echo '<pre>';
        //print_r($_SERVER);
        //echo '</pre>';
        
        
        $output_array = array('message' => $message);
        $this->render('site/DownloadAllImages', $output_array);
    }
}
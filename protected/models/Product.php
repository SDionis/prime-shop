<?

class product {
    public function get_products_by_category($cat_id, $id_shop) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `products` WHERE id_category = ".(int)$cat_id." AND id_shop = ".(int)$id_shop." LIMIT 100"; 
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function get_product_ids_by_categories_and_shops($where_str) {
    	$db = Yii::app()->db;
    	$sql = "SELECT `id` FROM `products` WHERE ".$where_str;
    	$command = $db->createCommand($sql);
    	$result = $command->queryColumn();
    	return $result;
    }
    
    public function get_products_by_category_with_pager($current_page, $perpage, $cat_id, $id_shop) {
    	
    	$db = Yii::app()->db;
    	if (gettype($current_page) != 'integer') {
    		$current_page = 1;
    	}
    	if(empty($current_page)) {
    		$current_page = 1;
    	} else {
    		$current_page = (int) $current_page;
    	}
    	
    	if ($current_page < 1) {
    		$current_page = 1;
    	}
    	$str_query = "SELECT p.* FROM `products` p WHERE p.id_category = ".(int)$cat_id." AND p.id_shop = ".(int)$id_shop."";
    	    	
    	$start_position = ($current_page-1)*$perpage;
    	$sql_counter = "SELECT COUNT(*) `count_num` FROM `products` p 
                WHERE p.id_category = ".(int)$cat_id." AND p.id_shop = ".(int)$id_shop."";
    	$command = $db->createCommand($sql_counter);
    	$total_amount = $command->queryScalar();
    	
    	$sql = $str_query . ' LIMIT '. $start_position .', '. $perpage;
    	
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	
    	$total_pages = ceil($total_amount/$perpage);
    	if ($total_amount < $perpage) {
    		$perpage = $total_amount;
    	}
    	 
    	$return_array = array();
    	$return_array['data'] = $data;
    	$return_array['total_amount'] = $total_amount;
    	$return_array['total_pages'] = $total_pages;
    	$return_array['current_page'] = $current_page;
    	
    	return $return_array;
    }
    
    public function get_all_products() {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `products`"; 
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function get_main_picture($id) {
        $db = Yii::app()->db;
        $sql = "SELECT `picture` FROM `pictures` WHERE id_product = ".$id." ORDER BY `id` ASC LIMIT 1";
        $command = $db->createCommand($sql);
        $result = $command->queryScalar();
        return $result;
    }
    
    public function get_product_by_id($id) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `products` WHERE id = ".$id." LIMIT 1";
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_products_by_ids($ids) {
    	$db = Yii::app()->db;
    	//$sql = "SELECT * FROM `products` WHERE id = IN (".implode(',', $ids).")";
    	$sql = "SELECT p.*,
        	(SELECT pic.`picture` FROM `pictures` pic WHERE pic.id_product = p.id ORDER BY pic.id ASC LIMIT 1) main_picture
	        FROM `products` p 
	        /*INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop*/
    		WHERE p.id IN (".implode(',', $ids).") 
	        ORDER BY p.`id` DESC";
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	return $result;
    }
    
    public function get_product_by_translit($translit) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `products` WHERE `translit` = ".$db->quoteValue($translit)." LIMIT 1";
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_cat_info_by_prod_info($id_cat, $id_shop) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `categories` WHERE `id_category` = ".(int) $id_cat." AND `id_shop` = ".(int) $id_shop." LIMIT 1";
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_currencies() {
        $db = Yii::app()->db;
        $sql = "SELECT id_currency FROM `currencies`";
        $command = $db->createCommand($sql);
        $result = $command->queryColumn();
        return $result;
    }
    public function get_pictures_by_product($id_prod) {
        $db = Yii::app()->db;
        $sql = "SELECT `picture` FROM `pictures` WHERE id_product = ".$id_prod;
        $command = $db->createCommand($sql);
        $result = $command->queryColumn();
        return $result;
    }
    
    public function get_param_by_product($id_prod) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `param` WHERE id_product = ".$id_prod;
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        return $result;
    }
    
    public function get_barcode_by_product($id_prod) {
        $db = Yii::app()->db;
        $sql = "SELECT `barcode` FROM `barcode` WHERE id_product = ".$id_prod;
        $command = $db->createCommand($sql);
        $result = $command->queryColumn();
        return $result;
    }
    
    public function get_dataTour_by_product($id_prod) {
        $db = Yii::app()->db;
        $sql = "SELECT `dataTour` FROM `datatour` WHERE id_product = ".$id_prod;
        $command = $db->createCommand($sql);
        $result = $command->queryColumn();
        return $result;
    }
    
    public function updateProduct($id, $data) {
        $db = Yii::app()->db;
        $sub_query = array();
        $query_pictures = array();
        $params = array();
        $query_dataTour = array();
        $query_barcode = array();
        foreach ($data as $key => $val) {
            switch($key){
                case 'id_category':
                    $sub_query[] = " `id_category` = ".(int) $val." ";
                    break;
                case 'id_currency':
                    $sub_query[] = " `id_currency` = ".$db->quoteValue($val)." ";
                    break;
                case 'url':
                    $sub_query[] = " `url` = ".$db->quoteValue($val)." ";
                    break;
                case 'price':
                    $sub_query[] = " `price` = ".$db->quoteValue($val)." ";
                    break;
                case 'store':
                    $sub_query[] = " `store` = ".$db->quoteValue($val)." ";
                    break;
                case 'pickup':
                    $sub_query[] = " `pickup` = ".$db->quoteValue($val)." ";
                    break;
                case 'delivery':
                    $sub_query[] = " `delivery` = ".$db->quoteValue($val)." ";
                    break;
                case 'local_delivery_cost':
                    $sub_query[] = " `local_delivery_cost` = ".$db->quoteValue($val)." ";
                    break;
                case 'typePrefix':
                    $sub_query[] = " `typePrefix` = ".$db->quoteValue($val)." ";
                    break;
                case 'vendor':
                    $sub_query[] = " `vendor` = ".$db->quoteValue($val)." ";
                    break;
                case 'vendorCode':
                    $sub_query[] = " `vendorCode` = ".$db->quoteValue($val)." ";
                    break;
                case 'model':
                    $sub_query[] = " `model` = ".$db->quoteValue($val)." ";
                    break;
                case 'description':
                    $sub_query[] = " `description` = ".$db->quoteValue($val)." ";
                    break;
                case 'sales_notes':
                    $sub_query[] = " `sales_notes` = ".$db->quoteValue($val)." ";
                    break;
                case 'manufacturer_warranty':
                    $sub_query[] = " `manufacturer_warranty` = ".$db->quoteValue($val)." ";
                    break;
                case 'age':
                    $sub_query[] = " `age` = ".$db->quoteValue($val)." ";
                    break;
                case 'adult':
                    $sub_query[] = " `adult` = ".$db->quoteValue($val)." ";
                    break;
                case 'country_of_origin':
                    $sub_query[] = " `country_of_origin` = ".$db->quoteValue($val)." ";
                    break;
                case 'type':
                    $sub_query[] = " `type` = ".$db->quoteValue($val)." ";
                    break;
                case 'available':
                    $sub_query[] = " `available` = ".$db->quoteValue($val)." ";
                    break;
                case 'downloadable':
                    $sub_query[] = " `downloadable` = ".$db->quoteValue($val)." ";
                    break;     
                case 'author':
                    $sub_query[] = " `author` = ".$db->quoteValue($val)." ";
                    break;
                case 'name':
                    $sub_query[] = " `name` = ".$db->quoteValue($val)." ";
                    break;
                case 'publisher':
                    $sub_query[] = " `publisher` = ".$db->quoteValue($val)." ";
                    break;
                case 'series':
                    $sub_query[] = " `series` = ".$db->quoteValue($val)." ";
                    break;
                case 'year':
                    $sub_query[] = " `year` = ".(int) $val." ";
                    break;
                case 'ISBN':
                    $sub_query[] = " `ISBN` = ".$db->quoteValue($val)." ";
                    break;
                case 'volume':
                    $sub_query[] = " `volume` = ".(int) $val." ";
                    break;
                case 'part':
                    $sub_query[] = " `part` = ".(int) $val." ";
                    break;
                case 'language':
                    $sub_query[] = " `language` = ".$db->quoteValue($val)." ";
                    break;
                case 'binding':
                    $sub_query[] = " `binding` = ".$db->quoteValue($val)." ";
                    break;
                case 'page_extent':
                    $sub_query[] = " `page_extent` = ".(int) $val." ";
                    break;    
                case 'table_of_contents':
                    $sub_query[] = " `table_of_contents` = ".$db->quoteValue($val)." ";
                    break;
                case 'performed_by':
                    $sub_query[] = " `performed_by` = ".$db->quoteValue($val)." ";
                    break;
                case 'performance_type':
                    $sub_query[] = " `performance_type` = ".$db->quoteValue($val)." ";
                    break;
                case 'storage':
                    $sub_query[] = " `storage` = ".$db->quoteValue($val)." ";
                    break;
                case 'format':
                    $sub_query[] = " `format` = ".$db->quoteValue($val)." ";
                    break;
                case 'recording_length':
                    $sub_query[] = " `recording_length` = ".$db->quoteValue($val)." ";
                    break;
                case 'artist':
                    $sub_query[] = " `artist` = ".$db->quoteValue($val)." ";
                    break;
                case 'title':
                    $sub_query[] = " `title` = ".$db->quoteValue($val)." ";
                    break;
                case 'media':
                    $sub_query[] = " `media` = ".$db->quoteValue($val)." ";
                    break;
                case 'starring':
                    $sub_query[] = " `starring` = ".$db->quoteValue($val)." ";
                    break;
                case 'director':
                    $sub_query[] = " `director` = ".$db->quoteValue($val)." ";
                    break;
                case 'originalName':
                    $sub_query[] = " `originalName` = ".$db->quoteValue($val)." ";
                    break;
                case 'country':
                    $sub_query[] = " `country` = ".$db->quoteValue($val)." ";
                    break;
                case 'worldRegion':
                    $sub_query[] = " `worldRegion` = ".$db->quoteValue($val)." ";
                    break;
                case 'region':
                    $sub_query[] = " `region` = ".$db->quoteValue($val)." ";
                    break;
                case 'days':
                    $sub_query[] = " `days` = ".(int) $val." ";
                    break;
                case 'hotel_stars':
                    $sub_query[] = " `hotel_stars` = ".$db->quoteValue($val)." ";
                    break;
                case 'room':
                    $sub_query[] = " `room` = ".$db->quoteValue($val)." ";
                    break;
                case 'meal':
                    $sub_query[] = " `meal` = ".$db->quoteValue($val)." ";
                    break;
                case 'included':
                    $sub_query[] = " `included` = ".$db->quoteValue($val)." ";
                    break;
                case 'transport':
                    $sub_query[] = " `transport` = ".$db->quoteValue($val)." ";
                    break;
                case 'place':
                    $sub_query[] = " `place` = ".$db->quoteValue($val)." ";
                    break;
                case 'hall':
                    $sub_query[] = " `hall` = ".$db->quoteValue($val)." ";
                    break;
                case 'hall_url':
                    $sub_query[] = " `hall_url` = ".$db->quoteValue($val)." ";
                    break;
                case 'hall_part':
                    $sub_query[] = " `hall_part` = ".$db->quoteValue($val)." ";
                    break;
                case 'date':
                    $sub_query[] = " `date` = ".$db->quoteValue($val)." ";
                    break;
                case 'is_premiere':
                    $sub_query[] = " `is_premiere` = ".(int) $val." ";
                    break;
                case 'is_kids':
                    $sub_query[] = " `is_kids` = ".(int) $val." ";
                    break;
                case 'bid':
                    $sub_query[] = " `bid` = ".(int) $val." ";
                    break;
                case 'cbid':
                    $sub_query[] = " `cbid` = ".(int) $val." ";
                    break;
                case 'on_main':
                    $sub_query[] = " `on_main` = ".(int) $val." ";
                    break;
                case 'new_sign':
                    $sub_query[] = " `new_sign` = ".(int) $val." ";
                    break;
                case 'spesial_sign':
                    $sub_query[] = " `spesial_sign` = ".(int) $val." ";
                    break;
                
                case 'picture':
                    foreach ($val as $val2) {
                        $query_pictures[] = "(".(int) $id.", ".$db->quoteValue($val2).")";
                    }
                    break;
                case 'dataTour':
                    foreach ($val as $val2) {
                        $query_dataTour[] = "(".(int) $id.", ".$db->quoteValue($val2).")";
                    }
                    break;
                case 'barcode':
                    foreach ($val as $val2) {
                        $query_barcode[] = "(".(int) $id.", ".$db->quoteValue($val2).")";
                    }
                    break;
                case 'param_name':
                    foreach ($val as $val2) {
                        $params['name'][] = $db->quoteValue($val2);
                    }
                    break;
                case 'param_unit':
                    foreach ($val as $val2) {
                        $params['unit'][] = $db->quoteValue($val2);
                    }
                    break;
                case 'param_value':
                    foreach ($val as $val2) {
                        $params['value'][] = $db->quoteValue($val2);
                    }
                    break;
            }
        }
        
        if (!empty($sub_query)) {
            $sql = "UPDATE `products` SET ".implode(',', $sub_query)." WHERE id = ".$id;
            $command = $db->createCommand($sql);
            $command->execute();
        }
        
        if (!empty($params)) {
            $param_inserts = array();
            foreach ($params as $key => $val) {
                foreach ($val as $key2 => $val2) {
                    $param_inserts[$key2][$key] = $val2;
                }
            }
            foreach ($param_inserts as $key => $val) {
                $param_inserts2[] = " (".(int) $id.", ".$val['name'].", ".$val['unit'].", ".$val['value'].") ";
            }
            $sql = "DELETE FROM `param` WHERE id_product = ".$id;
            $command = $db->createCommand($sql);
            $command->execute();
            $sql = "INSERT INTO `param` (`id_product`, param_name, param_unit, param_value) VALUES ".implode(' , ', $param_inserts2);
            $command = $db->createCommand($sql);
            $command->execute();        
        }
        if ($data['type'] == 'tour') {
            $sql = "DELETE FROM `datatour` WHERE id_product = ".$id;
            $command = $db->createCommand($sql);
            $command->execute();
        }
        if (!empty($query_dataTour)) {
            $sql = "INSERT INTO `datatour` (`id_product`, `dataTour`) VALUES ".implode(' , ', $query_dataTour);
            $command = $db->createCommand($sql);
            $command->execute();
        }
        if (in_array($data['type'], array('', 'vendor.model', 'artist.title'))) {
            $sql = "DELETE FROM `barcode` WHERE id_product = ".$id;
            $command = $db->createCommand($sql);
            $command->execute();
        }
        if (!empty($query_barcode)) {
            $sql = "INSERT INTO `barcode` (`id_product`, `barcode`) VALUES ".implode(' , ', $query_barcode);
            $command = $db->createCommand($sql);
            $command->execute();
        }
        
        if (!empty($query_pictures)) {
            $sql = "DELETE FROM `pictures` WHERE id_product = ".$id;
            $command = $db->createCommand($sql);
            $command->execute();
            $sql = "INSERT INTO `pictures` (`id_product`, `picture`) VALUES ".implode(' , ', $query_pictures);
            $command = $db->createCommand($sql);
            $command->execute();
        }
        
        
    }
    
    public function get_products_by_categories($cat_ids) {
        $db = Yii::app()->db;
        $sql = "SELECT p.* FROM `products` p 
                INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop  
                WHERE c.`id` IN (".implode(',', $cat_ids).")"; 
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function pager($current_page, $perpage, $cat_ids) {
		$db = Yii::app()->db;
		if (gettype($current_page) != 'integer') {
		    $current_page = 1;
		}
        if(empty($current_page)) {
            $current_page = 1;
        } else {
            $current_page = (int) $current_page;
        }

        if ($current_page < 1) {
            $current_page = 1;
        }
        
        $str_query = "SELECT p.*, 
                (SELECT `picture` FROM `pictures` pic2 WHERE pic2.id_product = p.id ORDER BY pic2.id ASC LIMIT 1) main_picture, 
        		sh.offer_id 
                FROM `products` p 
                INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop 
        		INNER JOIN `shops` sh ON sh.id = p.id_shop 
                WHERE c.`id` IN (".implode(',', $cat_ids).")";

        $start_position = ($current_page-1)*$perpage;
		$sql_counter = "SELECT COUNT(*) `count_num` FROM `products` p 
                INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop   
				INNER JOIN `shops` sh ON sh.id = p.id_shop 
                WHERE c.`id` IN (".implode(',', $cat_ids).")";
	    $command = $db->createCommand($sql_counter);
        $total_amount = $command->queryScalar();
          
		$sql = $str_query . ' LIMIT '. $start_position .', '. $perpage;
		
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        
        $total_pages = ceil($total_amount/$perpage);
	    if ($total_amount < $perpage) {
            $perpage = $total_amount;
        }
	    
        $return_array = array();
        $return_array['data'] = $data;
        $return_array['total_amount'] = $total_amount;
        $return_array['total_pages'] = $total_pages; 
	    $return_array['current_page'] = $current_page;
        
        return $return_array;
    }
    
    public function product_exists_by_translit($translit) {
        $db = Yii::app()->db;
        $sql = "SELECT COUNT(*) FROM `products` WHERE `translit` = ".$db->quoteValue($translit)."";
        $command = $db->createCommand($sql);
        $data = $command->queryScalar();
        return $data;
    }
    
    public function get_products_by_new_sign() {
    	$db = Yii::app()->db;
    	$sql = "SELECT p.*,
        	(SELECT `picture` FROM `pictures` pic2 WHERE pic2.id_product = p.id ORDER BY pic2.id ASC LIMIT 1) main_picture
	        FROM `products` p 
	        /*INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop*/
    		WHERE p.new_sign = 1 
	        ORDER BY p.`id` DESC LIMIT 0, 4";
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	if (count($data) > 4) {
    		$rand_keys = array_rand($data, 4);
    		$new_arr = array();
    		foreach ($rand_keys as $rand_key) {
    			$new_arr[] = $data[$rand_key];
    		}
    		$data = $new_arr;
    	}
    	return $data;
    }
    
    public function get_products_by_spesial_sign() {
    	$db = Yii::app()->db;
    	$sql = "SELECT p.*,
        	(SELECT `picture` FROM `pictures` pic2 WHERE pic2.id_product = p.id ORDER BY pic2.id ASC LIMIT 1) main_picture
	        FROM `products` p 
	        /*INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop*/
    		WHERE p.spesial_sign = 1 
	        ORDER BY p.`id` DESC LIMIT 0, 4";
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	if (count($data) > 4) {
    		$rand_keys = array_rand($data, 4);
    		$new_arr = array();
    		foreach ($rand_keys as $rand_key) {
    			$new_arr[] = $data[$rand_key];
    		}
    		$data = $new_arr;
    	}
    	return $data;
    }
    
    public function get_product_ids(){
    	$db = Yii::app()->db;
    	$sql = "SELECT `id`FROM `products`";
    	$command = $db->createCommand($sql);
    	$result = $command->queryColumn();
    	return $result;
    }
    
    public function get_prod_name($prod_info) {
    	
        switch($prod_info['type']) {
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
                $prod_name = $prod_info['name'];
                break;
            case 'event-ticket':
                $prod_name = $prod_info['name'];
                break;
        }
        return $prod_name;
    }
    
    #Обрезка строки
    function cutString($string, $maxlen) {
    	$string = strip_tags($string);
    	$string = trim($string);
    	$maxlen = $maxlen*2;
    	$string = str_replace("&nbsp;", "", $string);
    	$len = (mb_strlen($string) > $maxlen)? mb_strripos(mb_substr($string, 0, $maxlen), ' '): $maxlen;
    	$cutStr = mb_substr($string, 0, $len);
    	
    	return (mb_strlen($string) > $maxlen)? $cutStr . '...': $cutStr;
    }
    
    function crop($image, $x_o, $y_o, $w_o, $h_o) {
        /*
          $x_o и $y_o - координаты левого верхнего угла выходного изображения на исходном
          $w_o и h_o - ширина и высота выходного изображения
        */
        if (($x_o < 0) || ($y_o < 0) || ($w_o < 0) || ($h_o < 0)) {
          echo "Некорректные входные параметры";
          return false;
        }
        list($w_i, $h_i, $type) = getimagesize($image); // Получаем размеры и тип изображения (число)
        $types = array("", "gif", "jpeg", "png"); // Массив с типами изображений
        $ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа
        if ($ext) {
          $func = 'imagecreatefrom'.$ext; // Получаем название функции, соответствующую типу, для создания изображения
          $img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
        } else {
          echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
          return false;
        }
        if ($x_o + $w_o > $w_i) $w_o = $w_i - $x_o; // Если ширина выходного изображения больше исходного (с учётом x_o), то уменьшаем её
        if ($y_o + $h_o > $h_i) $h_o = $h_i - $y_o; // Если высота выходного изображения больше исходного (с учётом y_o), то уменьшаем её
        $img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения
        imagecopy($img_o, $img_i, 0, 0, $x_o, $y_o, $w_o, $h_o); // Переносим часть изображения из исходного в выходное
        $func = 'image'.$ext; // Получаем функция для сохранения результата
        return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
    }
    
    function resizeimgW($filename, $smallimage, $w, $h){
        // Имя файла с масштабируемым изображением
        $filename = $filename;
        // Имя файла с уменьшенной копией.
        $smallimage = $smallimage;
        // определим коэффициент сжатия изображения, которое будем генерить
        $ratio = $w/$h;
        // получим размеры исходного изображения
        $size_img = getimagesize($filename);
        // получим коэффициент сжатия исходного изображения
        $src_ratio=$size_img[0]/$size_img[1];
        // Здесь вычисляем размеры уменьшенной копии, чтобы при масштабировании сохранились
        // пропорции исходного изображения
        if ($ratio>$src_ratio)
                {
                  $h = $w/$src_ratio;
                }
        else
                {
                  $w = $h*$src_ratio;
                }
        // создадим пустое изображение по заданным размерам
        $dest_img = imagecreatetruecolor($w, $h);
        // создаем jpeg из файла
        $src_img = imagecreatefromjpeg($filename);
        // масштабируем изображение     функцией imagecopyresampled()
        // $dest_img - уменьшенная копия
        // $src_img - исходной изображение
        // $w - ширина уменьшенной копии
        // $h - высота уменьшенной копии
        // $size_img[0] - ширина исходного изображения
        // $size_img[1] - высота исходного изображения
        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
        // сохраняем уменьшенную копию в файл
        imagejpeg($dest_img, $smallimage);
        // чистим память от созданных изображений
        imagedestroy($dest_img);
        imagedestroy($src_img);
        return true;
    }
    
    public function parse_request_url($url_request_uri, $page) {
    	$url_request_uri = explode('?', $url_request_uri);
    	$url = $url_request_uri[1];
    	$page = (int) $page;
    	$change = 0;
    	$url = explode('&',$url);
    	foreach($url as $key=>$value) {
    		$val = explode('=', $value);
    		if ($val[0] == 'page') {
    			$url[$key] = $val[0].'='.$page;
    			$change = 1;
    			break;
    		}
    	}
    	if ($change == 0) {
    		$url[count($url)] = 'page='.$page;
    	}
    	$url = implode('&', $url);
    	$url_request_uri[1] = $url;
    	$url_request_uri = implode('?', $url_request_uri);
    	return $url_request_uri;
    }
    
    public function get_rus_names_currencies(){
    	$db = Yii::app()->db;
    	$sql = "SELECT `id_currency`, `rus_name` FROM `currescies_translations`";
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$out = array();
    	foreach($result as $row){
    		$out[$row['id_currency']] = $row['rus_name'];
    	}
    	return $out;
    }
    
    public function delete_product($id) {
    	$db = Yii::app()->db;
    	$command = $db->createCommand("START TRANSACTION;");
    	$command->query();
    	$sql = "DELETE FROM `pictures` WHERE id_product = ".(int) $id;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$sql = "DELETE FROM `param` WHERE id_product = ".(int) $id;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$sql = "DELETE FROM `datatour` WHERE id_product = ".(int) $id;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$sql = "DELETE FROM `barcode` WHERE id_product = ".(int) $id;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$sql = "DELETE FROM `products` WHERE id = ".(int) $id;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$command = $db->createCommand("COMMIT;");
    	$command->query();
    }
    
    public function delete_products($ids) {
    	if (!empty($ids)) {
	    	$db = Yii::app()->db;
	    	$sql = "DELETE FROM `pictures` WHERE id_product IN (".implode(',', $ids).")";
	    	$command = $db->createCommand($sql);
	    	$command->execute();
	    	$sql = "DELETE FROM `param` WHERE id_product IN (".implode(',', $ids).")";
	    	$command = $db->createCommand($sql);
	    	$command->execute();
	    	$sql = "DELETE FROM `datatour` WHERE id_product IN (".implode(',', $ids).")";
	    	$command = $db->createCommand($sql);
	    	$command->execute();
	    	$sql = "DELETE FROM `barcode` WHERE id_product IN (".implode(',', $ids).")";
	    	$command = $db->createCommand($sql);
	    	$command->execute();
	    	$sql = "DELETE FROM `products` WHERE id IN (".implode(',', $ids).")";
	    	$command = $db->createCommand($sql);
	    	$command->execute();
    	}
    }
    
}

?>
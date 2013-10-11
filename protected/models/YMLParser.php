<?
class YMLParser {
    public function parse($file, $offer_id){
        $xml = simplexml_load_file($file);
        $yml_catalog_date = $xml['date'][0];
        
        $shop_name = $xml->shop->name;
        $shop_company = $xml->shop->company;
        $shop_name = $xml->shop->name;
        $shop_url = $xml->shop->url;
        $shop_platform = $xml->shop->platform;
        $shop_version = $xml->shop->version;
        $shop_agency = $xml->shop->agency;
        $shop_email = $xml->shop->email;
        $local_delivery_cost = $xml->shop->local_delivery_cost;
        
        
        if (!$xml->shop->name || !$xml->shop->company) {
            exit;
        }
        if (count($xml->shop) <= 0) {
            exit;
        }
        if (count($xml->shop->offers) <= 0) {
            exit;
        }
        if (count($xml->shop->offers->offer) <= 0) {
            exit;
        }
        
        
        //echo '<pre>';
        //print_r(count($xml->shop->offers->offer));
        //echo '</pre>';
        
        $db = Yii::app()->db;
        $command = $db->createCommand("START TRANSACTION;");
        $command->query();
        
        $sql = "SELECT id FROM shops WHERE `name` = ".$db->quoteValue($shop_name)." 
                AND `company` = ".$db->quoteValue($shop_company)."";
        $command = $db->createCommand($sql);      
        $value = $command->queryScalar();
        
        if ($value > 0) {
            $sql = "UPDATE shops SET `name` = ".$db->quoteValue($shop_name).",  
                `company` = ".$db->quoteValue($shop_company).", 
                `date` = ".$db->quoteValue(date('Y-m-d H:i:s', strtotime($yml_catalog_date))).",
                `url` = ".$db->quoteValue($shop_url).",
                `platform` = ".$db->quoteValue($shop_platform).",
                `version` = ".$db->quoteValue($shop_version).",
                `agency` = ".$db->quoteValue($shop_agency).",
                `email` = ".$db->quoteValue($shop_email).", 
                local_delivery_cost = ".$db->quoteValue($local_delivery_cost).", 
                offer_id = ".(int) $offer_id." 
                WHERE id = ".$value."
                ";
            $command = $db->createCommand($sql);
            $command->execute();
            $shop_id = $value;
        } else {
            $sql = "INSERT INTO shops SET `name` = ".$db->quoteValue($shop_name).",  
                `company` = ".$db->quoteValue($shop_company).", 
                `date` = ".$db->quoteValue(date('Y-m-d H:i:s', strtotime($yml_catalog_date))).",
                `url` = ".$db->quoteValue($shop_url).",
                `platform` = ".$db->quoteValue($shop_platform).",
                `version` = ".$db->quoteValue($shop_version).",
                `agency` = ".$db->quoteValue($shop_agency).",
                `email` = ".$db->quoteValue($shop_email).",
                local_delivery_cost = ".$db->quoteValue($local_delivery_cost).", 
                offer_id = ".(int) $offer_id." 
                ";
            $command = $db->createCommand($sql);
            $command->execute();
            $shop_id = $db->getLastInsertID();
        }
        
        $sql = "SELECT id_currency FROM currencies";
        $command = $db->createCommand($sql);
        $currencies_from_db = $command->queryColumn();
        
        foreach($xml->shop->currencies->currency as $currency) {
            if (!in_array($currency['id'], $currencies_from_db)) {
                $sql = "INSERT INTO currencies SET id_currency = ".$db->quoteValue($currency['id']).", 
                        `rate` = ".$db->quoteValue($currency['rate']).", 
                        `plus` = ".(!empty($currency['plus'])?$currency['plus']:'0')."";
                $command = $db->createCommand($sql);
                $command->execute();
            } else {
                $sql = "UPDATE currencies SET  
                        `rate` = ".$db->quoteValue($currency['rate']).", 
                        `plus` = ".(!empty($currency['plus'])?$currency['plus']:'0')." WHERE id_currency = ".$db->quoteValue($currency['id'])."";
                $command = $db->createCommand($sql);
                $command->execute();
            }
        }
        
        $sql = "SELECT id_shop, id_category FROM categories";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $shops_from_db = array();
        $categories_from_db = array();
        foreach($result as $val){
            $shops_from_db[] = $val['id_shop'];
            $categories_from_db[] = $val['id_category'];
        }
        
        foreach($xml->shop->categories->category as $category) {
            if (!in_array($category['id'], $categories_from_db) || !in_array($shop_id, $shops_from_db)) {
                $sql = "INSERT INTO categories SET id_shop = ".(int)$shop_id.", 
                        `id_category` = ".(int)$category['id'].", 
                        `id_category_parent` = ".(int)$category['parentId'].", 
                        cat_name = ".$db->quoteValue($category).",
                        translit = ".$db->quoteValue($this->translit($category))."";
                $command = $db->createCommand($sql);
                $command->execute();
            } else {
                $sql = "UPDATE categories SET  
                        `id_category_parent` = ".(int)$category['parentId'].", 
                        cat_name = ".$db->quoteValue($category).", 
                        translit = ".$db->quoteValue($this->translit($category))."
                        WHERE `id_category` = ".(int)$category['id']." AND id_shop = ".(int)$shop_id."";
                $command = $db->createCommand($sql);
                $command->execute();
            }
        }
        
        $sql = "SELECT id_product FROM products";
        $command = $db->createCommand($sql);
        $products_from_db = $command->queryColumn();
        
        foreach($xml->shop->offers->offer as $offer) {
            switch ($offer['type']) {
                case '':
                    $prod_info = $offer->name;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'name',);
                    break;
                case 'vendor.model':
                    $prod_info = $offer->vendor.' '.$offer->model;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'vendor', 'model',);
                    break;
                case 'book':
                    $prod_info = $offer->name.' '.$offer->author;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'name',);
                    break;
                case 'audiobook':
                    $prod_info = $offer->name.' '.$offer->author;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'name',);
                    break;
                case 'artist.title':
                    $prod_info = $offer->title;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'title',);
                    break;
                case 'tour':
                    $prod_info = $offer->name;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'name', 'days','included', 'transport',);
                    break;
                case 'event-ticket':
                    $prod_info = $offer->name;
                    $necessary_fields = array('url', 'price', 'currencyId', 'categoryId', 'name','place','date',);
                    break;
            }
            $continue = 0;
            foreach ($necessary_fields as $necessary_field) {
                if (empty($offer->$necessary_field)) {
                    $continue = 1;
                    break;
                }
            }
            if ($continue == 1) {
                continue;
            }
            $translit = $db->quoteValue($this->translit(trim($prod_info)));
            if (in_array($shop_id, $shops_from_db) && in_array($offer['id'], $products_from_db)) {
                
                $sql = "SELECT id FROM `products` WHERE `id_shop` = ".(int)$shop_id." AND `id_product` = ".(int)$offer['id']."";
                $command = $db->createCommand($sql);      
                $product_id = $command->queryScalar();
                
                $sql = "UPDATE `products` SET 
                `translit` = ".$translit.", 
                `id_category` = ".(int)$offer->categoryId.",
                `id_currency` = ".$db->quoteValue($offer->currencyId).",
                `url` = ".$db->quoteValue($offer->url).",
                `price` = ".$db->quoteValue($offer->price).",
                `store` = ".$db->quoteValue($offer->store).",
                `pickup` = ".$db->quoteValue($offer->pickup).",
                `delivery` = ".$db->quoteValue($offer->delivery).",
                `local_delivery_cost` = ".$db->quoteValue($offer->local_delivery_cost).",
                `typePrefix` = ".$db->quoteValue($offer->typePrefix).",
                `vendor` = ".$db->quoteValue($offer->vendor).",
                `vendorCode` = ".$db->quoteValue($offer->vendorCode).",
                `model` = ".$db->quoteValue($offer->model).",
                `description` = ".$db->quoteValue($offer->description).",
                `sales_notes` = ".$db->quoteValue($offer->sales_notes).",
                `manufacturer_warranty` = ".$db->quoteValue($offer->manufacturer_warranty).",
                `age` = ".$db->quoteValue($offer->age).",
                `adult` = ".$db->quoteValue($offer->adult).",
                `country_of_origin` = ".$db->quoteValue($offer->country_of_origin).",
                `type` = ".$db->quoteValue($offer['type']).",
                `available` = ".$db->quoteValue($offer['available']).",
                `downloadable` = ".$db->quoteValue($offer->downloadable).",
                `author` = ".$db->quoteValue($offer->author).",
                `name` = ".$db->quoteValue($offer->name).",
                `publisher` = ".$db->quoteValue($offer->publisher).",
                `series` = ".$db->quoteValue($offer->series).",
                `year` = ".$db->quoteValue($offer->year).",
                `ISBN` = ".$db->quoteValue($offer->ISBN).",
                `volume` = ".$db->quoteValue($offer->volume).",
                `part` = ".$db->quoteValue($offer->part).",
                `language` = ".$db->quoteValue($offer->language).",
                `binding` = ".$db->quoteValue($offer->binding).",
                `page_extent` = ".$db->quoteValue($offer->page_extent).",
                `table_of_contents` = ".$db->quoteValue($offer->table_of_contents).",
                `performed_by` = ".$db->quoteValue($offer->performed_by).",
                `performance_type` = ".$db->quoteValue($offer->performance_type).",
                `storage` = ".$db->quoteValue($offer->storage).",
                `format` = ".$db->quoteValue($offer->format).",
                `recording_length` = ".$db->quoteValue($offer->recording_length).",
                `artist` = ".$db->quoteValue($offer->artist).",
                `title` = ".$db->quoteValue($offer->title).",
                `media` = ".$db->quoteValue($offer->media).",
                `starring` = ".$db->quoteValue($offer->starring).",
                `director` = ".$db->quoteValue($offer->director).",
                `originalName` = ".$db->quoteValue($offer->originalName).",
                `country` = ".$db->quoteValue($offer->country).",
                `worldRegion` = ".$db->quoteValue($offer->worldRegion).",
                `region` = ".$db->quoteValue($offer->region).",
                `days` = ".$db->quoteValue($offer->days).",
                `hotel_stars` = ".$db->quoteValue($offer->hotel_stars).",
                `room` = ".$db->quoteValue($offer->room).",
                `included` = ".$db->quoteValue($offer->included).",
                `transport` = ".$db->quoteValue($offer->transport).",
                `place` = ".$db->quoteValue($offer->place).",
                `hall` = ".$db->quoteValue($offer->hall).",
                `hall_url` = ".$db->quoteValue($offer->hall_url).",
                `hall_part` = ".$db->quoteValue($offer->hall_part).",
                `date` = ".$db->quoteValue(date('Y-m-d H:i:s', strtotime($offer->date))).",
                `is_premiere` = ".$db->quoteValue($offer->is_premiere).",
                `is_kids` = ".$db->quoteValue($offer->is_kids).",
                `bid` = ".$db->quoteValue($offer->bid).",
                `cbid` = ".$db->quoteValue($offer->cbid)." 
                WHERE `id_product` = ".(int)$offer['id']." AND `id_shop` = ".(int)$shop_id."";
                $command = $db->createCommand($sql);
                $command->execute();
                
                foreach ($offer->picture as $picture) {
                    $sql = "DELETE FROM pictures WHERE id_product = ".(int)$product_id."";
                    $sql = "UPDATE pictures SET 
                    picture = ".$db->quoteValue($picture)." 
                    WHERE id_product = ".(int)$product_id."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                    
                    $id_shop = $shop_id;
                    $AcImageCall = new AcImageCall();
                    $index_point = Yii::app()->controller->index_point;
                    $img_name_full = $picture;
                    $filename_parts = explode('/', $img_name_full);
                    $img_name = $filename_parts[count($filename_parts)-1];
                    $img_name_parts = explode('.', $img_name, 2);
                    //$out_name = $img_name_parts[0].'_'.$id_shop.'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
                    //$out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
                    //$out_name_full_show = $index_point.'img/resized/'.$out_name;
                    
                    $intermediate_save_img_path = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/original/'.$img_name_parts[0].'_'.$id_shop.'.'.$img_name_parts[1];
                    //if (!file_exists($intermediate_save_img_path)) {
                    	//$AcImageCall->grab_image($picture, $intermediate_save_img_path);
                    //}
                }
                foreach ($offer->barcode as $barcode) {
                    $sql = "DELETE FROM barcode WHERE id_product = ".(int)$product_id."";
                    $sql = "UPDATE barcode SET 
                    barcode = ".$db->quoteValue($barcode)." 
                    WHERE id_product = ".(int)$product_id."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                foreach ($offer->param as $param) {
                    $sql = "DELETE FROM param WHERE id_product = ".(int)$product_id."";
                    $sql = "UPDATE param SET 
                    param_name = ".$db->quoteValue($param['name']).", 
                    param_unit = ".$db->quoteValue($param['unit']).", 
                    param_value = ".$db->quoteValue($param)." 
                    WHERE id_product = ".(int)$product_id."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                foreach ($offer->dataTour as $dataTour) {
                    $sql = "DELETE FROM datatour WHERE id_product = ".(int)$product_id."";
                    $sql = "UPDATE datatour SET 
                    dataTour = ".$db->quoteValue(date('Y-m-d', strtotime($dataTour)))." 
                    WHERE id_product = ".(int)$product_id."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                
            } else {
                $sql = "INSERT INTO `products` SET `id_shop` = ".(int)$shop_id.", 
                `translit` = ".$translit.", 
                `id_category` = ".(int)$offer->categoryId.",
                `id_currency` = ".$db->quoteValue($offer->currencyId).",
                `id_product` = ".(int)$offer['id'].",
                `url` = ".$db->quoteValue($offer->url).",
                `price` = ".$db->quoteValue($offer->price).",
                `store` = ".$db->quoteValue($offer->store).",
                `pickup` = ".$db->quoteValue($offer->pickup).",
                `delivery` = ".$db->quoteValue($offer->delivery).",
                `local_delivery_cost` = ".$db->quoteValue($offer->local_delivery_cost).",
                `typePrefix` = ".$db->quoteValue($offer->typePrefix).",
                `vendor` = ".$db->quoteValue($offer->vendor).",
                `vendorCode` = ".$db->quoteValue($offer->vendorCode).",
                `model` = ".$db->quoteValue($offer->model).",
                `description` = ".$db->quoteValue($offer->description).",
                `sales_notes` = ".$db->quoteValue($offer->sales_notes).",
                `manufacturer_warranty` = ".$db->quoteValue($offer->manufacturer_warranty).",
                `age` = ".$db->quoteValue($offer->age).",
                `adult` = ".$db->quoteValue($offer->adult).",
                `country_of_origin` = ".$db->quoteValue($offer->country_of_origin).",
                `type` = ".$db->quoteValue($offer['type']).",
                `available` = ".$db->quoteValue($offer['available']).",
                `downloadable` = ".$db->quoteValue($offer->downloadable).",
                `author` = ".$db->quoteValue($offer->author).",
                `name` = ".$db->quoteValue($offer->name).",
                `publisher` = ".$db->quoteValue($offer->publisher).",
                `series` = ".$db->quoteValue($offer->series).",
                `year` = ".$db->quoteValue($offer->year).",
                `ISBN` = ".$db->quoteValue($offer->ISBN).",
                `volume` = ".$db->quoteValue($offer->volume).",
                `part` = ".$db->quoteValue($offer->part).",
                `language` = ".$db->quoteValue($offer->language).",
                `binding` = ".$db->quoteValue($offer->binding).",
                `page_extent` = ".$db->quoteValue($offer->page_extent).",
                `table_of_contents` = ".$db->quoteValue($offer->table_of_contents).",
                `performed_by` = ".$db->quoteValue($offer->performed_by).",
                `performance_type` = ".$db->quoteValue($offer->performance_type).",
                `storage` = ".$db->quoteValue($offer->storage).",
                `format` = ".$db->quoteValue($offer->format).",
                `recording_length` = ".$db->quoteValue($offer->recording_length).",
                `artist` = ".$db->quoteValue($offer->artist).",
                `title` = ".$db->quoteValue($offer->title).",
                `media` = ".$db->quoteValue($offer->media).",
                `starring` = ".$db->quoteValue($offer->starring).",
                `director` = ".$db->quoteValue($offer->director).",
                `originalName` = ".$db->quoteValue($offer->originalName).",
                `country` = ".$db->quoteValue($offer->country).",
                `worldRegion` = ".$db->quoteValue($offer->worldRegion).",
                `region` = ".$db->quoteValue($offer->region).",
                `days` = ".$db->quoteValue($offer->days).",
                `hotel_stars` = ".$db->quoteValue($offer->hotel_stars).",
                `room` = ".$db->quoteValue($offer->room).",
                `included` = ".$db->quoteValue($offer->included).",
                `transport` = ".$db->quoteValue($offer->transport).",
                `place` = ".$db->quoteValue($offer->place).",
                `hall` = ".$db->quoteValue($offer->hall).",
                `hall_url` = ".$db->quoteValue($offer->hall_url).",
                `hall_part` = ".$db->quoteValue($offer->hall_part).",
                `date` = ".$db->quoteValue(date('Y-m-d H:i:s', strtotime($offer->date))).",
                `is_premiere` = ".$db->quoteValue($offer->is_premiere).",
                `is_kids` = ".$db->quoteValue($offer->is_kids).",
                `bid` = ".$db->quoteValue($offer->bid).",
                `cbid` = ".$db->quoteValue($offer->cbid)."";
                
                $command = $db->createCommand($sql);
                $command->execute();
                $product_id = $db->getLastInsertID();
                foreach ($offer->picture as $picture) {
                    $sql = "INSERT INTO pictures SET id_product = ".(int)$product_id.", 
                    picture = ".$db->quoteValue($picture)."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                    
                    $id_shop = $shop_id;
                    $AcImageCall = new AcImageCall();
                    $index_point = Yii::app()->controller->index_point;
                    $img_name_full = $picture;
                    $filename_parts = explode('/', $img_name_full);
                    $img_name = $filename_parts[count($filename_parts)-1];
                    $img_name_parts = explode('.', $img_name, 2);
                    //$out_name = $img_name_parts[0].'_'.$id_shop.'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
                    //$out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
                    //$out_name_full_show = $index_point.'img/resized/'.$out_name;
                    
                    $intermediate_save_img_path = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/original/'.$img_name_parts[0].'_'.$id_shop.'.'.$img_name_parts[1];
                    //if (!file_exists($intermediate_save_img_path)) {
                    	//$AcImageCall->grab_image($picture, $intermediate_save_img_path);
                    //}
                }
                foreach ($offer->param as $param) {
                    $sql = "INSERT INTO param SET id_product = ".(int)$product_id.", 
                    param_name = ".$db->quoteValue($param['name']).", 
                    param_unit = ".$db->quoteValue($param['unit']).", 
                    param_value = ".$db->quoteValue($param)."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                foreach ($offer->barcode as $barcode) {
                    $sql = "INSERT INTO barcode SET id_product = ".(int)$product_id.", 
                    barcode = ".$db->quoteValue($barcode)."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                foreach ($offer->dataTour as $dataTour) {
                    $sql = "INSERT INTO datatour SET id_product = ".(int)$product_id.", 
                    dataTour = ".$db->quoteValue(date('Y-m-d', strtotime($dataTour)))."";
                    $command = $db->createCommand($sql);
                    $command->execute();
                }
                
                
            }
            //echo '<pre>';
            //print_r($offer);
            //echo '</pre>';
            //echo date('Y-m-d H:i:s', strtotime('2009-12-31T19:00'));
        }
        
        //echo '<pre>';
        //print_r($xml);
        //echo '</pre>';
        $command = $db->createCommand("COMMIT;");
        $command->query();
    }
    
    public function translit2($str) {
        $translit = array(
            'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'yo', 'Ж' => 'zh', 'З' => 'z',
            'И' => 'i', 'Й' => 'i', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r',
            'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'h', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
            'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            ' ' => '-', '!' => '', '?' => '', '('=> '', ')' => '', '#' => '', ',' => '', '№' => '',' - '=>'-','/'=>'-', '  '=>'-', '.' => '-',
            'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm', 'N' => 'n',
            'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z'
        );
        return strtr($str, $translit);
    }
    
    public function translit($str)
    {
    	$tr = array(
    			"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
    			"Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
    			"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
    			"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
    			"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
    			"Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
    			"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
    			"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
    			"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
    			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
    			"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
    			"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
    			"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
    			" "=> "_", "."=> "", "/"=> "_"
    	);
    	$urlstr = strtr($str,$tr);
    	$urlstr = preg_replace('/[^A-Za-z0-9_\-]/', '', $urlstr);
    	return $urlstr;
    }
    
    public function DownloadAllImages(){
        ignore_user_abort(true);
        set_time_limit(0);
        $db = Yii::app()->db;
        $sql = "SELECT pic.*, p.id_shop FROM `pictures` pic INNER JOIN `products` p ON p.id = pic.id_product";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        //echo count($result);exit;
        foreach ($result as $key => $row) {
            $picture = $row['picture'];
            $id_shop = $row['id_shop'];
            $AcImageCall = new AcImageCall();
            $index_point = Yii::app()->controller->index_point;
            $img_name_full = $row['picture'];
            $filename_parts = explode('/', $img_name_full);
            $img_name = $filename_parts[count($filename_parts)-1];
            $img_name_parts = explode('.', $img_name, 2);
            //$out_name = $img_name_parts[0].'_'.$id_shop.'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
            //$out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
            //$out_name_full_show = $index_point.'img/resized/'.$out_name;
            
            $intermediate_save_img_path = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/original/'.$img_name_parts[0].'_'.$id_shop.'.'.$img_name_parts[1];
            if (!file_exists($intermediate_save_img_path)) {
            	$AcImageCall->grab_image($picture, $intermediate_save_img_path);
            }
            //if($key == 100){
                //break;
            //}
        }
    }
}


?>
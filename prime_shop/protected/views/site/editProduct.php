
<form method="POST">
<table class="top_table">

<?

switch ($current_product['type']) {
    case '':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'local_delivery_cost' => array('type' => 'text', 'name' => 'local_delivery_cost', 'val' => $current_product['local_delivery_cost']),
            'name' => array('type' => 'text','name' => 'name', 'val' => $current_product['name']),
            'vendorCode' => array('type' => 'text','name' => 'vendorCode', 'val' => $current_product['vendorCode']),
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'sales_notes' => array('type' => 'text','name' => 'sales_notes', 'val' => $current_product['sales_notes']),
            'manufacturer_warranty' => array('type' => 'select','name' => 'manufacturer_warranty', 'val' => $current_product['manufacturer_warranty']),
            'country_of_origin' => array('type' => 'text','name' => 'country_of_origin', 'val' => $current_product['country_of_origin']),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
    case 'vendor.model':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'local_delivery_cost' => array('type' => 'text', 'name' => 'local_delivery_cost', 'val' => $current_product['local_delivery_cost']),
            'typePrefix' => array('type' => 'text','name' => 'typePrefix', 'val' => $current_product['typePrefix']),
            'vendor' => array('type' => 'text','name' => 'vendor', 'val' => $current_product['vendor']),
            'vendorCode' => array('type' => 'text','name' => 'vendorCode', 'val' => $current_product['vendorCode']),
            'model' => array('type' => 'text','name' => 'model', 'val' => $current_product['model']),
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'sales_notes' => array('type' => 'text','name' => 'sales_notes', 'val' => $current_product['sales_notes']),
            'manufacturer_warranty' => array('type' => 'select','name' => 'manufacturer_warranty', 'val' => $current_product['manufacturer_warranty']),
            'country_of_origin' => array('type' => 'text','name' => 'country_of_origin', 'val' => $current_product['country_of_origin']),
            'barcode' => array('type' => 'text','name' => 'barcode', 'val' => 'barcode'),
            'param' => array('type' => 'text','name' => 'param', 'val' => 'param'),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        
        break;
    case 'book':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'local_delivery_cost' => array('type' => 'text', 'name' => 'local_delivery_cost', 'val' => $current_product['local_delivery_cost']),
            'author' => array('type' => 'text','name' => 'author', 'val' => $current_product['author']),
            'name' => array('type' => 'text','name' => 'name', 'val' => $current_product['name']),
            'publisher' => array('type' => 'text','name' => 'publisher', 'val' => $current_product['publisher']),
            'series' => array('type' => 'text','name' => 'series', 'val' => $current_product['series']),
            'year' => array('type' => 'text','name' => 'year', 'val' => $current_product['year']),
            'ISBN' => array('type' => 'text','name' => 'ISBN', 'val' => $current_product['ISBN']),
            'volume' => array('type' => 'text','name' => 'volume', 'val' => $current_product['volume']),
            'part' => array('type' => 'text','name' => 'part', 'val' => $current_product['part']),
            'language' => array('type' => 'text','name' => 'language', 'val' => $current_product['language']),
            'binding' => array('type' => 'text','name' => 'binding', 'val' => $current_product['binding']),
            'page_extent' => array('type' => 'text','name' => 'page_extent', 'val' => $current_product['page_extent']),
            'table_of_contents' => array('type' => 'textarea','name' => 'table_of_contents', 'val' => $current_product['table_of_contents']), 
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'downloadable' => array('type' => 'select','name' => 'downloadable', 'val' => $current_product['downloadable']),
            'age' => array('type' => 'select','name' => 'age', 'val' => $current_product['age']),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
    case 'audiobook':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'author' => array('type' => 'text','name' => 'author', 'val' => $current_product['author']),
            'name' => array('type' => 'text','name' => 'name', 'val' => $current_product['name']),
            'publisher' => array('type' => 'text','name' => 'publisher', 'val' => $current_product['publisher']),
            'year' => array('type' => 'text','name' => 'year', 'val' => $current_product['year']),
            'ISBN' => array('type' => 'text','name' => 'ISBN', 'val' => $current_product['ISBN']),
            'language' => array('type' => 'text','name' => 'language', 'val' => $current_product['language']),
            'performed_by' => array('type' => 'text','name' => 'performed_by', 'val' => $current_product['performed_by']),
            'performance_type' => array('type' => 'text','name' => 'performance_type', 'val' => $current_product['performance_type']),
            'storage' => array('type' => 'text','name' => 'storage', 'val' => $current_product['storage']),
            'format' => array('type' => 'text','name' => 'format', 'val' => $current_product['format']),
            'recording_length' => array('type' => 'text','name' => 'recording_length', 'val' => $current_product['recording_length']),
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'downloadable' => array('type' => 'select','name' => 'downloadable', 'val' => $current_product['downloadable']),
            'age' => array('type' => 'select','name' => 'age', 'val' => $current_product['age']),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
        
    case 'artist.title':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'artist' => array('type' => 'text', 'name' => 'artist', 'val' => $current_product['artist']),
            'title' => array('type' => 'text', 'name' => 'title', 'val' => $current_product['title']),
            'year' => array('type' => 'text','name' => 'year', 'val' => $current_product['year']),
            'media' => array('type' => 'text','name' => 'media', 'val' => $current_product['media']),
            'starring' => array('type' => 'text','name' => 'starring', 'val' => $current_product['starring']),
            'director' => array('type' => 'text','name' => 'director', 'val' => $current_product['director']),
            'originalName' => array('type' => 'text','name' => 'originalName', 'val' => $current_product['originalName']),
            'country' => array('type' => 'text','name' => 'country', 'val' => $current_product['country']),
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'adult' => array('type' => 'select','name' => 'adult', 'val' => $current_product['adult']),
            'age' => array('type' => 'select','name' => 'age', 'val' => $current_product['age']),
            'barcode' => array('type' => 'text','name' => 'barcode', 'val' => 'barcode'),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
    case 'tour':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'local_delivery_cost' => array('type' => 'text', 'name' => 'local_delivery_cost', 'val' => $current_product['local_delivery_cost']),
            'worldRegion' => array('type' => 'text','name' => 'worldRegion', 'val' => $current_product['worldRegion']),
            'country' => array('type' => 'text','name' => 'country', 'val' => $current_product['country']),
            'region' => array('type' => 'text','name' => 'region', 'val' => $current_product['region']),
            'days' => array('type' => 'text','name' => 'days', 'val' => $current_product['days']),
            'dataTour' => array('type' => 'text','name' => 'dataTour', 'val' => 'dataTour'),
            'name' => array('type' => 'text','name' => 'name', 'val' => $current_product['name']),
            'hotel_stars' => array('type' => 'text','name' => 'hotel_stars', 'val' => $current_product['hotel_stars']),
            'room' => array('type' => 'text','name' => 'room', 'val' => $current_product['room']),
            'meal' => array('type' => 'text','name' => 'meal', 'val' => $current_product['meal']),
            'included' => array('type' => 'textarea','name' => 'included', 'val' => $current_product['included']),
            'transport' => array('type' => 'text','name' => 'transport', 'val' => $current_product['transport']),
            'description' => array('type' => 'textarea','name' => 'description', 'val' => $current_product['description']),
            'age' => array('type' => 'select','name' => 'age', 'val' => $current_product['age']),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
    case 'event-ticket':
        $data = array(
            'type' => array('type' => 'select', 'name' => 'type', 'val' => $current_product['type']),
            'available' => array('type' => 'select','name' => 'available', 'val' => $current_product['available']),
            'bid' => array('type' => 'text', 'name' => 'bid', 'val' => $current_product['bid']),
            'cbid' => array('type' => 'text', 'name' => 'cbid', 'val' => $current_product['cbid']),
            'url' => array('type' => 'text', 'name' => 'url', 'val' => $current_product['url']),
            'price' => array('type' => 'text','name' => 'price', 'val' => $current_product['price']),
            'translit' => array('type' => 'text','name' => 'translit', 'val' => $current_product['translit']),
            'id_currency' => array('type' => 'select','name' => 'id_currency', 'val' => $current_product['id_currency']),
            'id_category' => array('type' => 'select','name' => 'id_category', 'val' => $current_product['id_category']),
            'pictures' => array('type' => 'text','name' => 'pictures', 'val' => 'pictures'),
            'store' => array('type' => 'select','name' => 'store', 'val' => $current_product['store']),
            'pickup' => array('type' => 'select','name' => 'pickup', 'val' => $current_product['pickup']),
            'delivery' => array('type' => 'select','name' => 'delivery', 'val' => $current_product['delivery']),
            'local_delivery_cost' => array('type' => 'text', 'name' => 'local_delivery_cost', 'val' => $current_product['local_delivery_cost']),
            'name' => array('type' => 'text','name' => 'name', 'val' => $current_product['name']),
            'place' => array('type' => 'text','name' => 'place', 'val' => $current_product['place']),
            'hall' => array('type' => 'text','name' => 'hall', 'val' => $current_product['hall']),
            'hall_url' => array('type' => 'text','name' => 'hall_url', 'val' => $current_product['hall_url']),
            'hall_part' => array('type' => 'text','name' => 'hall_part', 'val' => $current_product['hall_part']),
            'date' => array('type' => 'text','name' => 'date', 'val' => $current_product['date']),
            'is_premiere' => array('type' => 'select','name' => 'is_premiere', 'val' => $current_product['is_premiere']),
            'is_kids' => array('type' => 'select','name' => 'is_kids', 'val' => $current_product['is_kids']),
            'age' => array('type' => 'select','name' => 'age', 'val' => $current_product['age']),
            'on_main' => array('type' => 'select','name' => 'on_main', 'val' => $current_product['on_main']),
            'new_sign' => array('type' => 'select','name' => 'new_sign', 'val' => $current_product['new_sign']),
            'spesial_sign' => array('type' => 'select','name' => 'spesial_sign', 'val' => $current_product['spesial_sign']),
        );
        break;
}
foreach($data as $key => $val) {
    
    switch ($val['type']) {
        case 'textarea':
            echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td><textarea name="'.$val['name'].'" >'.$val['val'].'</textarea></td></tr>';
            break;
        case 'text':
            $key_taken = 0;
            switch ($key) {
            	case 'translit': 
            		echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td><input readonly="readonly" type="text" name="'.$val['name'].'" value="'.$val['val'].'" /></td></tr>';
            		$key_taken = 1;
            		break;
                case 'pictures': 
                    echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td>';
                    foreach ($pictures as $picture) {
                        echo '<input type="text" name="picture[]" value="'.$picture.'" />';
                        echo '<a class="del_icon_pictures" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>';
                    }
                    echo '<a class="add_val_picture" href="">Добавить</a>';
                    echo '</td></tr>';
                    $key_taken = 1;
                    break;
                case 'param': 
                    echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td class="td_params">';
                    echo '<table class="table_params"><tr class="text_only"><td colspan="4">Параметры</td></tr><tr class="text_only"><td>Название</td><td>Ед. изм.</td><td>Величина</td><td></td></tr>';
                    foreach ($param as $param_val) {
                        echo '<tr><td width="50%"><input type="text" name="param_name[]" value="'.$param_val['param_name'].'" /></td>';
                        echo '<td><input type="text" name="param_unit[]" value="'.$param_val['param_unit'].'" /></td>';
                        echo '<td><input type="text" name="param_value[]" value="'.$param_val['param_value'].'" /></td>';
                        echo '<td><a class="del_icon_params" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a></td></tr>';
                    }
                    echo '</table>';
                    echo '<a class="add_val_param" href="">Добавить</a>';
                    echo '</td></tr>';
                    $key_taken = 1;
                    break;
                case 'barcode': 
                    echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td>';
                    foreach ($barcode as $barcode_scalar) {
                        echo '<input type="text" name="barcode[]" value="'.$barcode_scalar.'" />';
                        echo '<a class="del_icon_barcode" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>';
                    }
                    echo '<a class="add_val_barcode" href="">Добавить</a>';
                    echo '</td></tr>';
                    $key_taken = 1;
                    break;
                case 'dataTour': 
                    echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td>';
                    foreach ($dataTour as $dataTour_scalar) {
                        echo '<input type="text" name="dataTour[]" value="'.$dataTour_scalar.'" />';
                        echo '<a class="del_icon_dataTour" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>';
                    }
                    echo '<a class="add_val_dataTour" href="">Добавить</a>';
                    echo '</td></tr>';
                    $key_taken = 1;
                    break;
                    break;
            }
            if ($key_taken == 0) {
                echo '<tr class="tr_data"><td class="td_name">'.$key.'</td><td><input type="text" name="'.$val['name'].'" value="'.$val['val'].'" /></td></tr>';
            }
            break;
        case 'select':
            switch ($key) {
                case 'id_currency': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    foreach ($currencies as $currency) {
                        $selected = '';
                        if ($currency == $val['val']) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="'.$currency.'">'.$currency.'</option>';
                    }
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'id_category': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    foreach ($categories as $category) {
                        $selected = '';
                        if ($category['id_category'] == $val['val']) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option '.$selected.' value="'.$category['id_category'].'">'.$category['cat_name'].'</option>';
                         
                    }
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'store': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;  
                case 'pickup': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'delivery': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break; 
                case 'manufacturer_warranty': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;  
                case 'downloadable': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break; 
                case 'age': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == '0') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == '6') {
                        $selected3 = 'selected="selected"';
                    } else if ($val['val'] == '12') {
                        $selected3 = 'selected="selected"';
                    } else if ($val['val'] == '16') {
                        $selected3 = 'selected="selected"';
                    } else if ($val['val'] == '18') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="0">0</option>';
                    echo '<option '.$selected3.' value="6">6</option>';
                    echo '<option '.$selected3.' value="12">12</option>';
                    echo '<option '.$selected3.' value="16">16</option>';
                    echo '<option '.$selected3.' value="18">18</option>';
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'available': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'adult': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if (empty($val['val'])) {
                        $selected1 = 'selected="selected"';
                    } else if ($val['val'] == 'true') {
                        $selected2 = 'selected="selected"';
                    } else if ($val['val'] == 'false') {
                        $selected3 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value=""></option>';
                    echo '<option '.$selected2.' value="true">true</option>';
                    echo '<option '.$selected3.' value="false">false</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'is_premiere': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    $selected3 = '';
                    if ($val['val'] <= 0) {
                        $selected2 = 'selected="selected"';
                    } else {
                        $selected1 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value="1">Да</option>';
                    echo '<option '.$selected2.' value="0">Нет</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'is_kids': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    if ($val['val'] <= 0) {
                        $selected2 = 'selected="selected"';
                    } else {
                        $selected1 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value="1">Да</option>';
                    echo '<option '.$selected2.' value="0">Нет</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'type': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    
                    
                    foreach ($types as $type_val => $type_name) {
                        $selected = '';
                        if ($type_val == $val['val']) {
                            $selected = 'selected="selected"';
                        }
                        
                        $type_val_output = $type_val;
                        if ($type_val == '0') {
                            $type_val_output = '';
                        }
                        
                        echo '<option '.$selected.' value="'.$type_val_output.'">'.$type_name.'</option>';
                    }
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'on_main': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    if ($val['val'] <= 0) {
                        $selected2 = 'selected="selected"';
                    } else {
                        $selected1 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value="1">Да</option>';
                    echo '<option '.$selected2.' value="0">Нет</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'new_sign': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    if ($val['val'] <= 0) {
                        $selected2 = 'selected="selected"';
                    } else {
                        $selected1 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value="1">Да</option>';
                    echo '<option '.$selected2.' value="0">Нет</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
                case 'spesial_sign': 
                    echo '<tr class="tr_data">
                    <td class="td_name">'.$key.'</td><td>
                    <select name="'.$val['name'].'">';
                    $selected1 = '';
                    $selected2 = '';
                    if ($val['val'] <= 0) {
                        $selected2 = 'selected="selected"';
                    } else {
                        $selected1 = 'selected="selected"';
                    }
                    echo '<option '.$selected1.' value="1">Да</option>';
                    echo '<option '.$selected2.' value="0">Нет</option>';
                    
                    echo '</select>
                    </td>
                    </tr>';
                    break;
            }
            
            break;
    }
    
}


?>
<!--<tr class="tr_data">
    <td class="td_name">На главной</td>
    <td><input type="checkbox" name="on_main" /></td>
</tr>-->
</table>
<div class="save_button_container"><input type="submit" value="Сохранить" /></div>

</form>

<style type="text/css">

</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="type"]').live('change', function(){
            $.ajax({
                url: '',  
                type: 'POST',
                data: {option_type:'change_type', option_val: $(this).val()},                              
                success: function (data_return) { 
                    $('.top_table').html($(data_return).find('.top_table:first').html());
                    //console.info($(data_return).find('.top_table:first').html());
                },              
            });
        });
        
        $('.add_val_picture').live('click', function(){
            //var input_name = $(this).prev().attr('name');
            //var input_type = $(this).prev().attr('type');
            //console.info($(this).prev('input').attr('name'));
            $(this).before('<input type="text" name="picture[]" /><a class="del_icon_pictures" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.add_val_param').live('click', function(){
            $('.table_params tr:last').after('<tr><td><input type="text" name="param_name[]" /></td><td><input type="text" name="param_unit[]" /></td><td><input type="text" name="param_value[]" /></td><td><a class="del_icon_params" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a></td></tr>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_pictures').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
        
        $('.del_icon_params').live('click', function(){
            $(this).parent().parent().remove();
            return false;
        });
        
        $('.add_val_barcode').live('click', function(){
            $(this).before('<input type="text" name="barcode[]" /><a class="del_icon_barcode" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_barcode').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
        
        $('.add_val_dataTour').live('click', function(){
            $(this).before('<input type="text" name="dataTour[]" /><a class="del_icon_dataTour" href=""><img width="20px" height="20px" src="../images/delete.png" title="удалить"/></a>');
            $(this).blur();
            return false;
        });
        
        $('.del_icon_dataTour').live('click', function(){
            $(this).prev().remove();
            $(this).blur();
            $(this).remove();
            return false;
        });
    });
    

</script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />
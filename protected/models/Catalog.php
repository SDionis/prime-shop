<?php

class catalog {
	
	public function select_min_parent($id_shop){
		$db = Yii::app()->db;
		$sql = "SELECT MIN(`id_category_parent`) FROM `categories` WHERE id_shop = ".(int)$id_shop;
		$command = $db->createCommand($sql); 
		$result = $command->queryScalar();
		return $result;
	}
    
    public function select_info_by_first_translit($translit){
		$db = Yii::app()->db;
        $sql = "SELECT c.id_category, c.id_shop FROM `categories` c
    	LEFT JOIN categories_alternative ca on c.id_cat_alternative = ca.id
    	WHERE c.translit = (".$db->quoteValue($translit).") OR
    	ca.translit = (".$db->quoteValue($translit).") AND c.id_category IN 
        (SELECT MIN(`id_category_parent`) FROM `categories` GROUP BY id_shop)";
		$command = $db->createCommand($sql); 
		$result = $command->queryRow();
		return $result;
	}
    
    public function get_next_category_on_same_level($id_cat, $id_shop){
    	$db = Yii::app()->db;
    	$sql = "SELECT * FROM `categories` WHERE id_category_parent = 
    			(SELECT id_category_parent from `categories` WHERE id_category = ".(int)$id_cat." AND id_shop = ".(int)$id_shop.")  
    			AND id_category > ".(int)$id_cat." AND id_shop = ".(int)$id_shop." ORDER BY id_category ASC LIMIT 1";
    	$command = $db->createCommand($sql);
    	$result = $command->queryRow();
    	if (empty($result)) {
    		$sql = "SELECT * FROM `categories` WHERE id_category_parent = 
    			(SELECT id_category_parent from `categories` WHERE id_category = ".(int)$id_cat." AND id_shop = ".(int)$id_shop.")  
    			AND id_category < ".(int)$id_cat." AND id_shop = ".(int)$id_shop." ORDER BY id_category DESC LIMIT 1";
	    	$command = $db->createCommand($sql);
	    	$result = $command->queryRow();
	    	if (empty($result)) {
	    		$sql = "SELECT * FROM `categories` WHERE id_category =
    			(SELECT id_category_parent from `categories` WHERE id_category = ".(int)$id_cat." AND id_shop = ".(int)$id_shop.")
    			";
	    		$command = $db->createCommand($sql);
	    		$result = $command->queryRow();
	    		if (empty($result)) {
	    			$sql = "SELECT * FROM `categories` WHERE id_category = (SELECT MIN(id_category) from `categories` LIMIT 1)";
	    			$command = $db->createCommand($sql);
	    			$result = $command->queryRow();
	    		}
	    	}
    	}
    	return $result;
    }
    
    public function tree_multiple_queries($id, $level=0, $id_shop){
        $db = Yii::app()->db;
        $out = array();
        $sql = "SELECT * FROM `categories` WHERE id_category_parent = ".(int)$id;
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        foreach ($result as $row) {
            $level++;
            //echo '<pre>';
            //print_r($row);
            //echo '</pre>';
            //echo '<p style="padding-left:'.($level*10).'px;">';
            //echo $level;
            //echo $row['cat_name'];
            //echo '</p>';
            
            $out_local = $this->tree_multiple_queries($row['id_category'], $level, $id_shop);
            if ($out_local) {
                $row['childs'] = $out_local;
            }
            $out[] = $row;
            $level--;
        }
        return $out;
    }
    
    public function tree($arr, $parent, $id_shop){
    	$db = Yii::app()->db;
    	$out=array();
    	if (!isset($arr[$parent])) {
    		return $out;
    	}
    	foreach ($arr[$parent] as $row) {
    		
    		$out_local = $this->tree($arr, $row['id_category'], $id_shop);
    
    		if ($out_local) {
    			$row['childs'] = $out_local;
    		}
    		
    		$out[] = $row;
    		
    	}
    	return $out;
    }
    
    public function tree_for_face($arr, $parent, $id_shop){
    	$db = Yii::app()->db;
        $out=array();
        if (!isset($arr[$parent])) {
            return $out;
        }
        foreach ($arr[$parent] as $row) {
        	
        	$sql = "SELECT COUNT(*) FROM `products` p
                		INNER JOIN `categories` c ON c.id_category = p.id_category
                		WHERE c.id = ".$row['id'];
        	$command = $db->createCommand($sql);
        	$count = $command->queryScalar();
        	
        	$_SESSION['out'] = array();
        	$all_childs = $this->get_all_childs2($row['id_category'], $row['id_shop']);
        	unset($_SESSION['out']);
        	if (!empty($all_childs)) {
        		$count_all_childs = $this->get_count_prods_by_ids_cats($all_childs, $id_shop);
        	} else {
        		$count_all_childs = 0;
        	}
        	
        	//if ($row['translit'] == 'Black_Friday') {
        		//print_r($all_childs);
        	//}
        	if ($count_all_childs > 0) {
        		$out_local = $this->tree_for_face($arr, $row['id_category'], $id_shop);
        		
        		if ($out_local) {
        			$row['childs'] = $out_local;
        		}
        	}
        	
            if ($count > 0 || $count_all_childs > 0) {
            	$out[] = $row;
            }
            
            
        }
        return $out;
    }
     
    public function tree2($arr, $parent, $id_shop){
        $out=array();
        if (!isset($arr[$parent])) {
            return $out;
        }
        foreach ($arr[$parent] as $row) {
            
            $out_local = $this->tree2($arr, $row['id_category'], $id_shop);
            if ($out_local) {
                //list($key, $val) = each($out_local);
                $row['childs'] = $out_local;
            }
            $out[$row['cat_name']] = $row;
            
        }
        return $out;
    }
    
    public function get_catalog_for_tree($id_shop){
        $db = Yii::app()->db;
        if (empty($id_shop)) {
            $sql = "SELECT * FROM `categories`";
        } else {
            $sql = "SELECT * FROM `categories` WHERE id_shop = ".(int)$id_shop;
        }
        
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        $res = array();
        foreach ($result as $row) {
            $res[$row['id_category_parent']][] = $row;
        }
        return $res;
    }
    
    
    
    public function show_tree_from_array($arr){
        echo '<ul>';
        foreach($arr as $val){
            if (isset($_GET['id_cat']) && isset($_GET['id_shop']) && $val['id_category'] == $_GET['id_cat'] && $val['id_shop'] == $_GET['id_shop']) {
                echo '<li><a style="color:red;" href="?id_cat='.$val['id_category'].'&id_shop='.$val['id_shop'].'">'.$val['cat_name'].'</a></li>';
            } else {
                echo '<li><a href="?id_cat='.$val['id_category'].'&id_shop='.$val['id_shop'].'">'.$val['cat_name'].'</a></li>';
            }
        //print_r($val);echo '<br>';
            if (isset($val['childs'])) {
                $this->show_tree_from_array($val['childs']);
            }
        }
        echo '</ul>';
    }
    
    public function get_count_prods_by_ids_cats($arr, $id_shop){
    	$db = Yii::app()->db;
    	$sql = "SELECT COUNT(*) FROM `products` p
                		INNER JOIN `categories` c ON c.id_category = p.id_category AND c.id_shop = p.id_shop AND c.id_shop = ".$id_shop."  
                		WHERE c.id IN (".implode(',', $arr).")";
    	$command = $db->createCommand($sql);
    	$count = $command->queryScalar();
    	return $count;
    }
    
    public function get_tree_from_array($arr){
    	$db = Yii::app()->db;
    	
        $out = array();
        foreach($arr as $val){
            //$val_ids = array();
            //$val_ids[] = $val['id'];
        	//$sql = "SELECT COUNT(*) FROM `products` p 
                		//INNER JOIN `categories` c ON c.id_category = p.id_category 
                		//WHERE c.id = ".$val['id'];
        	//$command = $db->createCommand($sql);
        	//$count = $command->queryScalar();
        	
            if (isset($val['childs'])) {
            	//$_SESSION['out'] = array();
            	//$child_cats = $this->get_all_childs2($val['id_category'], $val['id_shop']);
            	//unset($_SESSION['out']);
            	//$count_all_childs = $this->get_count_prods_by_ids_cats($child_cats);
            	
            	//if ($count > 0 || $count_all_childs > 0) {
            		$out[$val['cat_name']]['data'][$val['translit']][] = $val['id'];
            	//}
            	//if ($count_all_childs > 0) {
            		$out_local = $this->get_tree_from_array($val['childs']);
            		$out[$val['cat_name']]['childs'] = $out_local;
            	//}
                
                //$out[$val['cat_name']] = array('data' => array($val['translit'] => $val['id']), 'childs' => $out_local);
                
                
            } else {
                //$out[$val['cat_name']] = array('data' => array($val['translit'] => $val['id']));
                //if (!empty($val['id']) && $count > 0) {
                if (!empty($val['id'])) {
                	$out[$val['cat_name']]['data'][$val['translit']][] = $val['id'];
                }
                
            }
            //$val_ids = array();
        }
        return $out;
    }
    
    public function get_tree_from_array_for_option($arr, $level){
        
        $out = array();
        $prefix = '';
        $level++;
        for ($i=0; $i<$level; $i++) {
            $prefix .= ' - ';
        }
        foreach($arr as $val){
            if (isset($val['childs'])) {
                $out_local = $this->get_tree_from_array_for_option($val['childs'], $level);
                $out[$val['id']] = array('cat_name' => $prefix.$val['cat_name'], 'childs' => $out_local);
            } else {
                $out[$val['id']] = array('cat_name' => $prefix.$val['cat_name']);
            }
        }
        $level--;
        return $out;
    }
    
    public function get_array_from_tree_for_option($arr, $new_array = 1){
        static $out = array();
        if ($new_array == 1) {
            $out = array();
        }
        
        foreach($arr as $key => $val){
            $out[$key] = $val['cat_name'];
            if (isset($val['childs'])) {
                $out_local = $this->get_array_from_tree_for_option($val['childs'], 0);
            }
        }
        return $out;
    }
    
    public function get_cats_with_link_to_cats_alt(){
        $db = Yii::app()->db;
        $sql = "SELECT `id` FROM `categories` WHERE id_cat_alternative > 0";
        $command = $db->createCommand($sql); 
        $result = $command->queryColumn();
        return $result;
    }
    
    public function get_cat_info_by_id_shop_and_id_cat($cat_id, $id_shop){
        $sql = "SELECT * FROM `categories` WHERE id_category = ".(int) $cat_id." AND id_shop = ".(int) $id_shop;
        $db = Yii::app()->db;
        $command = $db->createCommand($sql); 
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_cat_info_by_id($id){
        $sql = "SELECT * FROM `categories` WHERE `id` = ".(int) $id;
        $db = Yii::app()->db;
        $command = $db->createCommand($sql); 
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_cat_info_by_ids($ids){
        $sql = "SELECT * FROM `categories` WHERE `id` IN (".implode(',', $ids).")";
        $db = Yii::app()->db;
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function get_categories_inside_shop($id_shop){
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `categories` WHERE id_shop = ".$id_shop;
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    public function get_first_category_id_by_shop($id_shop){
        $db = Yii::app()->db;
        $sql = "SELECT `id_category` FROM `categories` WHERE id_shop = ".$id_shop." ORDER BY `id` LIMIT 1";
        $command = $db->createCommand($sql); 
        $result = $command->queryScalar();
        return $result;
    }
    public function getCategoriesAlternative() {
        $db = Yii::app()->db;
        $sql = "SELECT ca.id cat_alt_id, ca.name cat_alt_name, c.id cat_id, c.cat_name cat_name 
        FROM `categories_alternative` ca LEFT JOIN `categories` c ON c.id_cat_alternative = ca.id";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $return_array = array();
        
        foreach ($result as $val) {
            $return_array[$val['cat_alt_id']]['cat_alt_name'] = $val['cat_alt_name'];
            $return_array[$val['cat_alt_id']]['links'][$val['cat_id']] = $val['cat_name'];
        }
        return $return_array;
    }
    public function updateCatalog($id, $data) {
        $db = Yii::app()->db;
        $sql = "UPDATE `categories` SET `cat_name` = ".$db->quoteValue($data['cat_name'])." WHERE id = ".$id;
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    public function updateCatalogGeneral($ids, $data) {
        $db = Yii::app()->db;
        if (gettype($ids) == 'string' && $ids == 'all') {
            $sql_end = " NOT IN (0)";
        } else {
            $sql_end = "IN (".implode(',', $ids).")";
        }
        $insert_arr = array();
        foreach ($data as $key => $val) {
            $insert_str[] = " `".$key."` = ".$db->quoteValue($val)." ";
        }
        
        $sql = "UPDATE `categories` SET ".implode(' , ', $insert_str)." WHERE `id` ".$sql_end;
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    public function updateCatalogByCatIdAlt($ids) {
        $db = Yii::app()->db;
        
        $sql = "UPDATE `categories` SET id_cat_alternative = 0 WHERE id_cat_alternative IN (".implode(',',$ids).")";
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    public function deleteCategoriesAlternative() {
        $db = Yii::app()->db;
        $sql = "DELETE FROM `categories_alternative`";
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    public function insertIntoCategoriesAlternative($data) {
        $db = Yii::app()->db;
        $sql = "INSERT INTO `categories_alternative` SET `name` = ".$db->quoteValue($data['name']).", 
                `translit` = ".$db->quoteValue($data['translit'])."";
        $command = $db->createCommand($sql); 
        $command->execute();
        return $db->getLastInsertID();
    }
    public function deleteCategoriesAlternativeById($id) {
        $db = Yii::app()->db;
        $sql = "DELETE FROM `categories_alternative` WHERE `id` = ".(int) $id;
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    
    public function display_merged_cats($arr, $all_parents, $index_point, $translit_extend=array(), $url_translit) {
        
        if (empty($arr)) {
            return false;
        }
        if (empty($out)) {
            $out = '';
        }
        
        foreach ($arr as $key => $val) {
            //foreach ($val_iterative as $key => $val) {
            $arrow = '';
            $active = '';
            //if (!isset($val['childs'])) {
            if (!isset($val['childs'])) {
                $arrow = '<i class="icon-caret-right"></i>';
            }
            list($key2, $val2) = each($val['data']);
            $translit = $key2;
            
            $translit_extend_str = implode('/', $translit_extend);
            //echo $translit_extend_str;
            if (!empty($url_translit) && $url_translit == $translit && ($_GET['id'] == $translit_extend_str.'/'.$translit || count(explode('/', $_GET['id'])) == 1)) {
                $active = 'active';
                $_SESSION['category_ids'] = $val['data'][$translit];
                $_SESSION['cat_name'] = $key;
            }
            //} else {
               ///$translit = '#';
            //}
            
            if (strlen($translit_extend_str) > 0) {
                $translit_extend_str .= '/';
            }
            $out .= '<li>';
			$out .= '<a class="invarseColor '.$active.'" href="'.$index_point.$translit_extend_str.$translit.'">'.$arrow.$key.'</a>';
			//print_r($all_parents);
            if (isset($val['childs']) && in_array($translit, $all_parents)) {
                $translit_extend[] = $translit;
                $out .= '<ul>';
                $out .= $this->display_merged_cats($val['childs'], $all_parents, $index_point, $translit_extend, $url_translit);
                $out .= '</ul>';
                array_pop($translit_extend);
            }
            $out .= '</li>';
            //$translit_extend = '';
            //}
        }
        
        return $out;
    }
    
    public function get_catalog_for_tree_with_cat_alt($id_shop){
        $db = Yii::app()->db;
        if (empty($id_shop)) {
            $sql = "select c.id, c.id_shop, c.id_category, c.id_category_parent, COALESCE(ca.name, c.cat_name) cat_name, COALESCE(ca.translit, c.translit) translit from categories c 
                    left join categories_alternative ca on c.id_cat_alternative = ca.id";
        } else {
            $sql = "select c.id, c.id_shop, c.id_category, c.id_category_parent, COALESCE(ca.name, c.cat_name) cat_name, COALESCE(ca.translit, c.translit) translit from categories c 
                    left join categories_alternative ca on c.id_cat_alternative = ca.id 
                    WHERE c.id_shop = ".(int)$id_shop;
        }
        
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        $res = array();
        foreach ($result as $row) {
            $res[$row['id_category_parent']][] = $row;
        }
        return $res;
    }
    
    public function catalog_exists_by_translit($translit){
        $db = Yii::app()->db;
        $sql = "SELECT COUNT(*) FROM `categories` c 
         LEFT JOIN categories_alternative ca on c.id_cat_alternative = ca.id 
			WHERE c.translit = ".$db->quoteValue($translit)." OR 
			ca.translit = ".$db->quoteValue($translit)."";
        $command = $db->createCommand($sql); 
        $data = $command->queryScalar();
        return $data;
    }
    
    public function get_all_parents($id_parent, $id_shop) {
    	if (empty($row)) {
    		static $row = array();
    	}
    	$db = Yii::app()->db;
    	
    	$sql = "select c.id, c.id_shop, c.id_category, c.id_category_parent, COALESCE(ca.name, c.cat_name) cat_name, COALESCE(ca.translit, c.translit) translit from categories c
                    left join categories_alternative ca on c.id_cat_alternative = ca.id
                    WHERE id_category = ".(int) $id_parent." AND id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$data = $command->queryRow();
    	
    	if ($data['id_category'] != 0) {
    		$row[] = $data['translit'];
    		$this->get_all_parents($data['id_category_parent'], $id_shop);
    		
    	} 
    	return $row;
    }
    
    public function get_all_childs($id_cat, $id_shop) {
    	$db = Yii::app()->db;
        if (empty($out)) {
            static $out = array();
        }
        $sql = "select c.id, c.id_shop, c.id_category, c.id_category_parent, COALESCE(ca.name, c.cat_name) cat_name, 
        		COALESCE(ca.translit, c.translit) translit from categories c
                    left join categories_alternative ca on c.id_cat_alternative = ca.id
                    WHERE c.id_category_parent = ".(int) $id_cat." AND c.id_shop = ".(int) $id_shop;
        //echo $sql.'<br>';
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        
        foreach ($data as $row) {
        	$out[] = $row;
        	$this->get_all_childs($row['id_category'], $row['id_shop']);
        }
        return $out;    
    }
    
    public function get_all_childs2($id_cat, $id_shop, $static_is_null = 0) {
    	$db = Yii::app()->db;
    	
    	$sql = "select c.id, c.id_shop, c.id_category from categories c 
                    WHERE c.id_category_parent = ".(int) $id_cat." AND c.id_shop = ".(int) $id_shop;
    	//echo $sql.'<br>';
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    
    	foreach ($data as $row) {
    		$_SESSION['out'][] = $row['id'];
    		$this->get_all_childs2($row['id_category'], $row['id_shop']);
    	}
    	return $_SESSION['out'];
    }
    
    public function get_categories_by_translit($translit) {
    	$db = Yii::app()->db;
    	$sql = "SELECT c.* FROM `categories` c 
    	LEFT JOIN categories_alternative ca on c.id_cat_alternative = ca.id
    	WHERE c.translit = ".$db->quoteValue($translit)." OR
    	ca.translit = ".$db->quoteValue($translit)."";
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	return $data;
    }
    
    public function get_categories_by_translit_array($translit_array) {
    	$db = Yii::app()->db;
    	foreach ($translit_array as $key => $arr) {
    		$translit_array[$key] = $db->quoteValue($arr);
    	}
    	$sql = "SELECT c.id_category, c.id_shop FROM `categories` c
    	LEFT JOIN categories_alternative ca on c.id_cat_alternative = ca.id
    	WHERE c.translit IN (".implode(', ', $translit_array).") OR
    	ca.translit IN (".implode(', ', $translit_array).")";
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	return $data;
    }
    
    public function menu() {
    	$db = Yii::app()->db;
    	$sql = "SELECT COALESCE(ca.name, c.cat_name) cat_name,
        		COALESCE(ca.translit, c.translit) translit FROM categories c
                    left join categories_alternative ca on c.id_cat_alternative = ca.id
                    WHERE id_category_parent = (SELECT MIN(id_category_parent) FROM `categories`)";
    	
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
        if (count($data) <= 2) {
            //$data = array();
            $sql = "SELECT COALESCE(ca.name, c.cat_name) cat_name,
        		COALESCE(ca.translit, c.translit) translit FROM categories c
                    left join categories_alternative ca on c.id_cat_alternative = ca.id
                    WHERE c.id_category_parent = (SELECT id_category FROM `categories` WHERE id_category_parent = (SELECT MIN(id_category_parent) FROM `categories`) LIMIT 1)";
            $command = $db->createCommand($sql);
    	    $data2 = $command->queryAll();
            $i=0;
            foreach ($data2 as $row) {
                $data['childs'][$i] = $row;
                $i++;
            }
        }
    	return $data;
    }
    
    public function menu2($parent_id, $id_shop, $level) {
    	if ($parent_id == 0) {
    		$parent_id = '0';
    	}
    	$out = array();
    	$db = Yii::app()->db;
    	$sql = "SELECT c.id, c.id_category, COALESCE(ca.name, c.cat_name) cat_name,
        		COALESCE(ca.translit, c.translit) translit FROM categories c
                    left join categories_alternative ca on c.id_cat_alternative = ca.id
                    WHERE id_category_parent = ".$parent_id." AND c.id_shop = ".$id_shop;
    	 
    	$command = $db->createCommand($sql);
    	$data = $command->queryAll();
    	foreach ($data as $row) {
    		$level++;
    		
    		$sql = "SELECT COUNT(*) FROM `products` p
                		INNER JOIN `categories` c ON c.id_category = p.id_category
                		WHERE c.id = ".$row['id'];
    		$command = $db->createCommand($sql);
    		$count = $command->queryScalar();
    		
    		$_SESSION['out'] = array();
    		$all_childs = $this->get_all_childs2($row['id_category'], $id_shop);
    		unset($_SESSION['out']);
    		if (!empty($all_childs)) {
    			$count_all_childs = $this->get_count_prods_by_ids_cats($all_childs, $id_shop);
    		} else {
    			$count_all_childs = 0;
    		}
    		
    		
    		if ($count_all_childs > 0 || $count > 0) {
    			$out[$row['translit']]['name'] = $row['cat_name'];
	    		if ($level < 2) {
	    			$out[$row['translit']]['childs'] = $this->menu2($row['id_category'], $id_shop, $level);
	    		}
    		}
    		$level--;
    	}
    	
    	return $out;
    }
    
    public function get_min_parent_by_shop($id_shop) {
    	$db = Yii::app()->db;
    	$sql = "SELECT MIN(id_category_parent) FROM `categories` WHERE id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$data = $command->queryScalar();
    	return $data;
    }
    
    public function select_cat_info_by_translit($url_parts, $root_info=array(), $i=1){
        $db = Yii::app()->db;
        //if ($i == 1) {
            static $out = array();    
        //}
        $id_cat = $root_info['id_category'];
        $id_shop = $root_info['id_shop'];
        $translit = $url_parts[$i];
        $sql = "select c.id_shop, c.id_category, c.id_category_parent, COALESCE(ca.translit, c.translit) translit 
                        from categories c
                        left join categories_alternative ca on c.id_cat_alternative = ca.id
                        WHERE c.id_category_parent = ".(int) $id_cat." AND c.id_shop = ".(int) $id_shop." AND 
                        c.translit = (".$db->quoteValue($translit).") OR
                        ca.translit = (".$db->quoteValue($translit).")";
        $command = $db->createCommand($sql);
        $data = $command->queryRow();
        $out[]= $data;
        $i++;
        if (!empty($url_parts[$i])) {
            $this->select_cat_info_by_translit($url_parts, $root_info=array('id_category' => $data['id_category'], 'id_shop' => $data['id_shop']), $i);
        }
        return $out;
    }
    
    public function delete_catalog($id_cat, $id_shop){
    	$db = Yii::app()->db;
    	$all_child_ids = $this->get_all_child_ids($id_cat, $id_shop);
    	$where = array();
    	foreach ($all_child_ids as $row) {
    		$where[] = " (id_category = ".$row['id_category']." AND id_shop = ".$row['id_shop'].") ";
    	}
    	$command = $db->createCommand("START TRANSACTION;");
    	$command->query();
    	$sql = "DELETE FROM `categories` WHERE id_category = ".(int) $id_cat." AND id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$command->execute();
    	$sql = "DELETE FROM `products` WHERE id_category = ".(int) $id_cat." AND id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$command->execute();
	    	if (!empty($where)) {
		    	$where_str = implode(' OR ', $where);
		    	$sql = "DELETE FROM `categories` WHERE ".$where_str;
		    	$command = $db->createCommand($sql);
		    	$command->execute();
		    	$product = new Product();
		    	$product_ids = $product->get_product_ids_by_categories_and_shops($where_str);
		    	$product->delete_products($product_ids);
	    	}
    	$command = $db->createCommand("COMMIT;");
    	$command->query();
    }
    
    public function get_all_child_ids($id_cat, $id_shop){
    	$db = Yii::app()->db;
    	
    	$sql = "SELECT id, id_category, id_shop, id_category_parent FROM `categories` WHERE id_shop = ".(int)$id_shop;
    	
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$res = array();
    	foreach ($result as $row) {
    		$res[$row['id_category_parent']][] = $row;
    	}
    	$out = $this->tree_for_all_child_ids($res, $id_cat, $id_shop);
    	return $out;
    }
    
    public function tree_for_all_child_ids($arr, $parent, $id_shop){
    	static $out = array();
    	if (!isset($arr[$parent])) {
    		return $out;
    	}
    	foreach ($arr[$parent] as $row) {
    		$out[] = $row;
    		$out_local = $this->tree_for_all_child_ids($arr, $row['id_category'], $id_shop);
    	}
    	return $out;
    }
    
    public function delete_cats_by_shop($id_shop){
    	$db = Yii::app()->db;
    	$sql = "SELECT id_category FROM `categories` WHERE id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$where = array();
    	foreach ($result as $row) {
    		$where[] = " (id_category = ".$row['id_category']." AND id_shop = ".$id_shop.") ";
    	}
    	if (!empty($where)) {
	    	$where_str = implode(' OR ', $where);
	    	$product = new Product();
	    	$product_ids = $product->get_product_ids_by_categories_and_shops($where_str);
	    	$product->delete_products($product_ids);
    	}
    	$sql = "DELETE FROM `categories` WHERE id_shop = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$command->execute();
    }
}

?>
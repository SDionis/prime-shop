<?php

class shop {
    public function get_shops_ids() {
        $db = Yii::app()->db;
        $sql = "SELECT id FROM `shops`";
        $command = $db->createCommand($sql); 
        $result = $command->queryColumn();
        return $result;
    }
    public function get_shops_all_info() {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `shops`";
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    public function get_first_shop_id() {
        $db = Yii::app()->db;
        $sql = "SELECT `id` FROM `shops` ORDER BY `id` LIMIT 1";
        $command = $db->createCommand($sql);
        $result = $command->queryScalar();
        return $result;
    }
    
    public function get_shop_by_id($id_shop) {
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `shops` WHERE `id` = ".$id_shop;
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function updateShop($id, $data){
        $db = Yii::app()->db;
        $arr = array();
        foreach($data as $key => $row){
        	if (gettype($row) == 'integer') {
        		$arr[] = '`'.$key.'` = '.(int) $row;
        	} else {
        		$arr[] = '`'.$key.'` = '.$db->quoteValue($row);
        	}
        	
        }
        $sql = "UPDATE `shops` SET ".implode(',', $arr)." WHERE `id` = ".$id;
        $command = $db->createCommand($sql); 
        $command->execute();
    }
    
    public function deleteShop($id_shop){
    	$db = Yii::app()->db;
    	$catalog = new Catalog();
    	$catalog->delete_cats_by_shop($id_shop);
    	$sql = "DELETE FROM `shops` WHERE id = ".(int) $id_shop;
    	$command = $db->createCommand($sql);
    	$command->execute();
    }
    
    public function getCounts(){
    	$db = Yii::app()->db;
    	$sql = "SELECT * FROM `counts`";
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$out = array();
    	foreach($result as $val) {
    		$out[$val['name']] = $val['script'];
    	}
    	return $out;
    }
    
    public function updateCounts($name, $val) {
    	$db = Yii::app()->db;
    	$sql = "SELECT count(*) amount FROM `counts` WHERE `name` = ".$db->quoteValue($name);
    	$command = $db->createCommand($sql);
    	$result = $command->queryScalar();
    	if ($result > 0) {
    		$sql = "UPDATE `counts` SET `script` = ".$db->quoteValue($val)." WHERE `name` = ".$db->quoteValue($name);
    		$command = $db->createCommand($sql);
    		$command->execute();
    	} else {
    		$this->insertCounts($name, $val);
    	}
    	
    }
    
    public function insertCounts($name, $val) { 
    	$db = Yii::app()->db;
    	$sql = "INSERT INTO `counts` SET `script` = ".$db->quoteValue($val).", `name` = ".$db->quoteValue($name);
    	$command = $db->createCommand($sql);
    	$command->execute();
    }
    
    public function show_tables(){
    	$db = Yii::app()->db;
    	$sql = "SHOW TABLES;";
    	$command = $db->createCommand($sql);
    	$result = $command->queryColumn();
    	return $result;
    }
    
    public function delete_table($table){
    	$db = Yii::app()->db;
    	$sql = "DROP table ".$table.";";
    	$command = $db->createCommand($sql);
    	$command->execute();
    	//echo $sql.'<br>';
    }
    
}

?>
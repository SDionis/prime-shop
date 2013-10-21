<?php

class Metatags {
    
    public function get_metatags($metatags_names){
        $db = Yii::app()->db;
        foreach ($metatags_names as $key => $metatag_name) {
            $sql = "SELECT * FROM `metatags` WHERE `name` = ".$db->quoteValue($key)."";
            $command = $db->createCommand($sql); 
            $result = $command->queryRow();
            if (empty($result)) {
                $sql = "INSERT INTO `metatags` SET `name` = ".$db->quoteValue($key).", 
                		`descr` = ".$db->quoteValue($metatag_name)."";
                $command = $db->createCommand($sql);
                $command->execute();
            }
        }
        $sql = "SELECT * FROM `metatags`";
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function update_metatags($arr_save){
        $db = Yii::app()->db;
        foreach ($arr_save as $key => $val) {
            $sql = "UPDATE `metatags` SET `value` = ".$db->quoteValue($val)." WHERE `name` = ".$db->quoteValue($key)."";
            $command = $db->createCommand($sql);
            $command->execute();
        }
    }
    
    public function get_metatag_by_metatag_name($metatag_name){
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `metatags` WHERE `name` = ".$db->quoteValue($metatag_name)."";
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_metatags_info_by_metatags_names($metatags_names){
    	$db = Yii::app()->db;
    	foreach($metatags_names as $key => $metatag_name) {
    		$metatags_names[$key] = $db->quoteValue($metatag_name);
    	}
    	$sql = "SELECT * FROM `metatags` WHERE `name` IN (".implode(',', $metatags_names).")";
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$out = array();
    	foreach($result as $val){
    		$out[$val['name']] = $val['value'];
    	}
    	return $out;
    }
    
    
}

?>
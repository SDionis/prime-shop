<?php

class Settings {
    
    public function get_settings($setting_names){
        $db = Yii::app()->db;
        foreach ($setting_names as $key => $setting_name) {
            $sql = "SELECT * FROM `settings` WHERE `setting_name` = ".$db->quoteValue($key)."";
            $command = $db->createCommand($sql); 
            $result = $command->queryRow();
            if (empty($result)) {
                $sql = "INSERT INTO `settings` SET `setting_name` = ".$db->quoteValue($key).", 
                		setting_cyr_name = ".$db->quoteValue($setting_name)."";
                $command = $db->createCommand($sql);
                $command->execute();
            }
        }
        $sql = "SELECT * FROM `settings`";
        $command = $db->createCommand($sql); 
        $result = $command->queryAll();
        return $result;
    }
    
    public function update_settings($arr_save){
        $db = Yii::app()->db;
        foreach ($arr_save as $key => $val) {
            $sql = "UPDATE `settings` SET `setting_value` = ".$db->quoteValue($val)." WHERE `setting_name` = ".$db->quoteValue($key)."";
            $command = $db->createCommand($sql);
            $command->execute();
        }
    }
    
    public function get_setting_by_setting_name($setting_name){
        $db = Yii::app()->db;
        $sql = "SELECT * FROM `settings` WHERE `setting_name` = ".$db->quoteValue($setting_name)."";
        $command = $db->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }
    
    public function get_settings_info_by_setting_names($setting_names){
    	$db = Yii::app()->db;
    	foreach($setting_names as $key => $setting_name) {
    		$setting_names[$key] = $db->quoteValue($setting_name);
    	}
    	$sql = "SELECT * FROM `settings` WHERE `setting_name` IN (".implode(',', $setting_names).")";
    	$command = $db->createCommand($sql);
    	$result = $command->queryAll();
    	$out = array();
    	foreach($result as $val){
    		$out[$val['setting_name']] = $val['setting_value'];
    	}
    	return $out;
    }
    
    
}

?>
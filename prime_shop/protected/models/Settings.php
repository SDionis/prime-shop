<?php

class Settings {
    
    public function get_settings($setting_names){
        $db = Yii::app()->db;
        foreach ($setting_names as $setting_name) {
            $sql = "SELECT * FROM `settings` WHERE `setting_name` = ".$db->quoteValue($setting_name)."";
            $command = $db->createCommand($sql); 
            $result = $command->queryRow();
            if (empty($result)) {
                $sql = "INSERT INTO `settings` SET `setting_name` = ".$db->quoteValue($setting_name)."";
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
}

?>
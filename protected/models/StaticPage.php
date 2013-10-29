<?php 
class StaticPage {
	
	public function getStaticPagesPerPage($current_page, $perpage) {
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
	
		$str_query = "SELECT sp.* FROM `static_pages` sp";
		$start_position = ($current_page-1)*$perpage;
		$sql_counter = "SELECT COUNT(*) `count_num` FROM `static_pages` sp";
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
	
	public function getStaticPageById($id){
		$db = Yii::app()->db;
		$sql = "SELECT sp.* FROM `static_pages` sp WHERE sp.id = ".(int) $id;
		$command = $db->createCommand($sql);
		$data = $command->queryRow();
		return $data;
	}
	
	public function getStaticPageByTranslit($translit){
		$db = Yii::app()->db;
		$sql = "SELECT * FROM `static_pages` WHERE translit = ".$db->quoteValue($translit);
		$command = $db->createCommand($sql);
		$data = $command->queryRow();
		return $data;
	}
	
	public function getCountStaticPageByTranslit($translit){
		$db = Yii::app()->db;
		$sql = "SELECT COUNT(*) FROM `static_pages` WHERE translit = ".$db->quoteValue($translit);
		$command = $db->createCommand($sql);
		$data = $command->queryScalar();
		return $data;
	}
	
	public function getStaticPages($fields=array()){
		$db = Yii::app()->db;
		if (empty($fields)) {
			$fields = 'sp.*';
		} else {
			foreach($fields as $key => $val){
				$fields[$key] = "`".$val."`";
			}
			$fields = implode(',', $fields);
		}
		$sql = "SELECT ".$fields." FROM `static_pages` sp ";
		$command = $db->createCommand($sql);
		$data = $command->queryAll();
		return $data;
	}
	
	public function updateStaticPage($data, $id){
		$db = Yii::app()->db;
		$sub_query = array();
		foreach($data as $key => $val){
			if(is_int($val)){
				$sub_query[] = " `".$key."` = ".(int) $val." ";
			}else {
				$sub_query[] = " `".$key."` = ".$db->quoteValue($val)." ";
			}
			
		}
		
		$sql = "UPDATE `static_pages` SET ".implode(',', $sub_query)." WHERE id = ".(int) $id;
		$command = $db->createCommand($sql);
		$command->execute();
	}
	
	public function insertStaticPage($data){
		$db = Yii::app()->db;
		$sub_query = array();
		foreach($data as $key => $val){
			if(is_int($val)){
				$sub_query[] = " `".$key."` = ".(int) $val." ";
			}else {
				$sub_query[] = " `".$key."` = ".$db->quoteValue($val)." ";
			}
				
		}
		
		$sql = "INSERT INTO `static_pages` SET ".implode(',', $sub_query)." ";
		$command = $db->createCommand($sql);
		$command->execute();
		return $db->getLastInsertID();
	}
	
	public function deleteStaticPage($id) {
		$db = Yii::app()->db;
		$sql = "DELETE FROM `static_pages` WHERE id = ".(int) $id;
		$command = $db->createCommand($sql);
		$command->execute();
	}
}
?>
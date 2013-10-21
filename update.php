<?php
ignore_user_abort(true);
//session_start();
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Дата в прошлом
	Header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
	Header("Pragma: no-cache"); // HTTP/1.1
	Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
	header('Content-Type: text/html;charset=UTF-8');
	$updated = 0;
	
	$is_not_writable = array();
	$error = array();
	$msg = '';
	
	function removeDirectory($dir) {
		if ($objs = glob($dir."/{,.}*", GLOB_BRACE)) {
			foreach($objs as $obj) {
				$dir_tree = explode('/', $obj);
				$dir_last_in_tree = $dir_tree[(count($dir_tree)-1)];
				if ($dir_last_in_tree == '.' || $dir_last_in_tree == '..') {
					continue;
				}
				//echo $obj.'<br />';
				is_dir($obj) ? removeDirectory($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	}
	
	function checkDirectory($dir) {
		global $is_not_writable;
		if ($objs = glob($dir."/*")) {
			foreach($objs as $obj) {
				if (!is_writable($obj)) {
					$is_not_writable[] = $obj;
				}
				is_dir($obj) ? checkDirectory($obj) : '';
			}
		}
	}
	
	function recurse_copy($src,$dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file,$dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
	
	$dir_source = getcwd().'/archive_update';
	$dir_to = getcwd();
	$download_path = 'https://github.com/primelead/prime-shop/archive/master.zip';
	$archive_path = getcwd().'/archive.zip';
	$current_version_archive_size_file = getcwd().'/conf/current_version_archive_size.conf';
	$temp_dir = getcwd().'/temp_files';
	@mkdir($temp_dir);
	
	if (is_writable(getcwd())){
		$ch = curl_init($download_path);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/24.0");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_FILE, $fp);
		$exec = curl_exec($ch);
	
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$headers = substr($exec, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$data = substr($exec, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	
		curl_close($ch);
		if ($http_code == 200) {
			$fp = fopen($archive_path,'w+b');
			fwrite($fp, $data);
			fclose($fp);
		}
		
	} else {
		die('Директория '.getcwd().' не имеет доступа на запись');
	}
	
	checkDirectory($dir_to);
	if (!empty($is_not_writable)) {
		foreach($is_not_writable as $val){
			$msg .= $val.'<br />';
		}
		die($msg);
	} else {
		if (is_writable($dir_to)) {
			
			if (class_exists('ZipArchive')) {
				$zip = new ZipArchive();
				$res = $zip->open('archive.zip');
				if ($res === TRUE) {
					$zip->extractTo('archive_update/');
					$zip->close();
				} else {
					die('Не могу найти файл архива!');
				}
			} else {
				include_once 'libs/pclzip-2-8-2/pclzip.lib.php';
				$archive = new PclZip("archive.zip");
				if ($archive->extract(PCLZIP_OPT_PATH, "archive_update/") == 0) {
					die("Error : ".$archive->errorInfo(true));
				}
			}
			
			$dirs_from = scandir($dir_source);
			$dir_from = $dir_source.'/'.$dirs_from[2];
			
			if ($conf_file = file(getcwd().'/conf/conf.conf')) {
				$db_connect_values = array();
				foreach ($conf_file as $conf_file_option) {
					$conf_file_option = rtrim($conf_file_option);
					$conf_file_option_parts = explode(':', $conf_file_option);
					$db_connect_values[$conf_file_option_parts[0]] = $conf_file_option_parts[1];
				}
			}
			
			$dsn = 'mysql:host='.$db_connect_values['db_host'].';dbname='.$db_connect_values['db_name'];
			$username = $db_connect_values['db_user'];
			$password = $db_connect_values['db_pass'];
			$opt = array(
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				//PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			);
			try {
				$db = new PDO($dsn,$username,$password, $opt);
			} catch(PDOException $e){
				$error[] = $e->getMessage();
			}
			if (!empty($error)) {
				foreach($error as $val){
					$msg .= $val.'<br />';
				}
				die($msg);
			}
			
			$db->query("SET NAMES 'utf8'");
			$db->query("SET CHARSET 'utf8'");
			
			$tables = "SHOW TABLES";
			$table_names_arr = array();
			$res = $db->query($tables);
			
			$fp = fopen( $temp_dir."/dump.sql", "a" );
			if (!empty($fp) || 1==1 ) {
				while($table = $res->fetch()) {
					foreach($table as $table_name){
						$table_names_arr[] = "`".$table_name."`";
						$sql = "SELECT COUNT(*) FROM `".$table_name."`";
						$count_query = $db->query($sql);
						if ($count_query->fetchColumn() <= 0) {
							continue;
						}
						$rows = "SELECT * FROM `".$table_name."`";
						$r = $db->query($rows);
						$query_whole = array();
						$j=0;
						while($row = $r->fetch()){
							if(empty($row)){
								continue;
							}
							$query = array();
							if($j == 0){
								$fields_sql = array();
							}
							foreach ( $row as $key => $field ){
								if($j == 0){
									$fields_sql[] = "`".$key."`";
								}
								if (is_null($field)) {
									$field = "NULL";
								}else{
									$field = $db->quote($field);
								}
								$query[] = $field;
							}
							$query_str = "(".implode(',', $query).")";
							$query_whole[] = $query_str;
							if ($j == 0) {
								$j++;
							}
						}
						$fields_sql_str = "(".implode(',', $fields_sql).")";
						$query_whole_str = implode(',', $query_whole);
						$query = "INSERT INTO `".$table_name."` ".$fields_sql_str." VALUES ".$query_whole_str.";\n";
						//echo $query.'<br />';
						fwrite ($fp, $query);
					}
				}
			}
			fclose ($fp);
			unset($query);
			unset($fields_sql_str);
			unset($query_whole_str);
			unset($fields_sql);
			
			$table_names_str = implode(',', $table_names_arr);
			$sql = "DROP TABLE ".$table_names_str;
			$db->query($sql);
			
			$filename = $dir_from.'/sql/tables.sql';
			$sql_content = file_get_contents($filename);
			$db->query($sql_content);
			
			copy(getcwd().'/conf/conf.conf', getcwd().'/temp_files/conf.conf');
			
			recurse_copy($dir_from, $dir_to);
			
			$dir_source_version = getcwd().'/archive_version_update';
			$dirs_from_version = scandir($dir_source_version);
			$dir_from_version = $dir_source_version.'/'.$dirs_from_version[2];
			$new_version = file_get_contents($dir_from_version.'/version.conf');
			file_put_contents(getcwd().'/conf/version.conf', $new_version);
			copy(getcwd().'/temp_files/conf.conf', getcwd().'/conf/conf.conf');
			
			$filename = getcwd().'/temp_files/dump.sql';
			$sql_content = file_get_contents($filename);
			
			try {
				$db->query("START TRANSACTION;");	
				//$db->query($sql_content) or die(print_r($db->errorInfo(), true));
				$db->query($sql_content);
				$db->query("COMMIT;");
				unset($sql_content);
				if($db->errorInfo()){
					print_r($db->errorInfo(), true);
				}
				
			} catch(PDOException $e){
				$error[] = $e->getMessage();
				print_r($error);
			}
			unset($sql_content_queries);
			removeDirectory(getcwd().'/temp_files');
			removeDirectory(getcwd().'/archive_update');
			unlink(getcwd().'/archive.zip');
			removeDirectory(getcwd().'/archive_version_update');
			unlink(getcwd().'/archive_version.zip');
			$updated = 1;
			$db = null;
		}
		
	}
}

?>
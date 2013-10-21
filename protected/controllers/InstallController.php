<?php 
class InstallController extends Controller{
	
	public function __construct(){
		Yii::app()->layout = 'control';
		$this->layout = 'control';
		//session_start();
	}
	
	public function actionIndex(){
		$install = 0;
		chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
		if ($conf_file = file('conf.conf')) {
			foreach ($conf_file as $conf_file_option) {
				$conf_file_option = rtrim($conf_file_option);
				$conf_db_file_option_parts = explode(':', $conf_file_option);
				if ($conf_db_file_option_parts[0] == 'is_install' && $conf_db_file_option_parts[1] == 1) {
					$install = 1;
				}
			}
		}
		if ($install == 0){
			header('Location: '.Yii::app()->request->baseUrl.'/control');
			exit;
		}
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
			!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$install = 0;
			chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
			if ($conf_file = file('conf.conf')) {
				foreach ($conf_file as $conf_file_option) {
					$conf_file_option = rtrim($conf_file_option);
					$conf_db_file_option_parts = explode(':', $conf_file_option);
					if ($conf_db_file_option_parts[0] == 'is_install' && $conf_db_file_option_parts[1] == 1) {
						$install = 1;
					}
				}
			}
			//print_r($_POST);exit;
			$error = array();
			if($install != 1) {
				$error[] = 'Уже установлено';
			}
			
			//chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
			$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/conf/conf.conf';
			if (!is_writable($target_obj)) {
				$error[] = 'файл "'.$target_obj.'" должен иметь права на запись';
			}
			$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/img/original';
			if (!is_writable($target_obj)) {
				$error[] = 'каталог "'.$target_obj.'" должен иметь права на запись';
			}
			$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/img/resized';
			if (!is_writable($target_obj)) {
				$error[] = 'каталог "'.$target_obj.'" должен иметь права на запись';
			}
			if (!empty($error)) {
				echo json_encode($error);
				exit;
			}
			
			if (empty($_POST['db_pass']) || empty($_POST['db_pass_repeat']) || empty($_POST['db_login']) || empty($_POST['db_name']) || empty($_POST['db_host'])) {
				$error[] = 'Заполните все поля';
			}
			
			if ($_POST['db_pass'] != $_POST['db_pass_repeat']) {
				$error[] = 'Пароли не совпадают';
			}
			if (!empty($error)) {
				echo json_encode($error);
				exit;
			}
			
			$dsn = 'mysql:host='.$_POST['db_host'].';dbname='.$_POST['db_name'];
			$username = $_POST['db_login'];
			$password = $_POST['db_pass'];
			
			try {
				$db = new PDO($dsn,$username,$password);
			} catch(PDOException $e){
				$error[] = $e->getMessage();
			}
			if (!empty($error)) {
				echo json_encode($error);
				exit;
			}
			$db->query("SET NAMES 'utf8'");
			chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
				
			$data = array(
				'db_host' => $_POST['db_host'],
				'db_user' => $_POST['db_login'],
				'db_pass' => $_POST['db_pass'],
				'db_name' => $_POST['db_name'],
			);
			$str = '';
			foreach ($data as $key => $val) {
				$str .= $key.':'.$val."\n";
			}
			
			$filename = dirname($_SERVER['SCRIPT_FILENAME']).'/conf/conf.conf';
			if (is_writable($filename)) {
				if (!file_put_contents($filename, $str)) {
					$error[] = 'Не удалось добавить данные в конфигурационный файл';
				}
				if (!empty($error)) {
					echo json_encode($error);
					exit;
				}
			}
			$filename = dirname($_SERVER['SCRIPT_FILENAME']).'/sql/tables.sql';
			$sql_content = file_get_contents($filename);
			$db->query("START TRANSACTION;");
			$db->exec($sql_content);
			$filename = dirname($_SERVER['SCRIPT_FILENAME']).'/sql/data.sql';
			$sql_content = file_get_contents($filename);
			$db->exec($sql_content);
			$db->query("COMMIT;");
			echo json_encode('');
			exit;
		}
		$error = array();
		$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/conf/conf.conf';
		
		if (!is_writable($target_obj)) {
			$error[] = 'файл "'.$target_obj.'" должен иметь права на запись';
		}
		$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/img/original';
		if (!is_writable($target_obj)) {
			$error[] = 'каталог "'.$target_obj.'" должен иметь права на запись';
		}
		$target_obj = dirname($_SERVER['SCRIPT_FILENAME']).'/img/resized';
		if (!is_writable($target_obj)) {
			$error[] = 'каталог "'.$target_obj.'" должен иметь права на запись';
		}
		
		$this->render('site/install', array('error' => $error));
	}
}

?>
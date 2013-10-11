<?php 
class AcImageCall {
	
	public function resize($filename, $width, $height, $id_shop='0', $id_product='0') {
		if (1 == 2) {
			return $filename;
		}
		$index_point = Yii::app()->controller->index_point;
		$img_name_full = $filename;
		$filename_parts = explode('/', $img_name_full);
		$img_name = $filename_parts[count($filename_parts)-1];
		$img_name_parts = explode('.', $img_name, 2);
		$out_name = $img_name_parts[0].'_'.$id_shop.'_'.$id_product.'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
		$out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
		$out_name_full_show = $index_point.'img/resized/'.$out_name;
		if (file_exists($out_name_full)) {
			return $out_name_full_show;
		}
		$intermediate_save_img_path = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/original/'.$img_name_parts[0].'_'.$id_shop.'_'.$id_product.'.'.$img_name_parts[1];
		if (!file_exists($intermediate_save_img_path)) {
            //echo $intermediate_save_img_path;
			$this->grab_image($filename, $intermediate_save_img_path);
		}
		//return $intermediate_save_img_path;
		/*require_once($_SERVER['DOCUMENT_ROOT'].$index_point.'libs/AcImage/AcImage.php');
		if(AcImage::isFileExists($filename)){
			try {
				
				AcImage::setRewrite(true);
				
				$img_name_full = $intermediate_save_img_path;
				//unset($filename);
				$img = AcImage::createImage($img_name_full);
				$img_name_full_parts = explode('/', $img_name_full);
				$img_name = $img_name_full_parts[count($img_name_full_parts)-1];
				
				$img_name_parts = explode('.', $img_name, 2);
				
				$img->resize($width, $height);
				$out_name = $img_name_parts[0].'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
				$out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
				$out_name_full_show = $index_point.'img/resized/'.$out_name;
				$img->save($out_name_full);
				unset($img);
				//unlink($img_name_full);
				return $out_name_full_show;
			} catch (FileNotFoundException $ex){
				$ex->getMessage();
			}
		}*/
        
        $image = new image($intermediate_save_img_path);
        $image->resize($width, $height);
        
        $img_name_full = $intermediate_save_img_path;
        $img_name_full_parts = explode('/', $img_name_full);
        $img_name = $img_name_full_parts[count($img_name_full_parts)-1];
        $img_name_parts = explode('.', $img_name, 2);
        $out_name = $img_name_parts[0].'_'.$width.'x'.$height.'_resized.'.$img_name_parts[1];
        $out_name_full = $_SERVER['DOCUMENT_ROOT'].$index_point.'img/resized/'.$out_name;
        $out_name_full_show = $index_point.'img/resized/'.$out_name;
        //$image->save('resized/mySmallImage.jpg');
        $image->save($out_name_full);
        return $out_name_full_show;
	}
	
	public function grab_image($url,$saveto){
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch , CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0");
		$raw=curl_exec($ch);
		curl_close ($ch);
		if(file_exists($saveto)){
			unlink($saveto);
		}
		$fp = fopen($saveto,'x');
		fwrite($fp, $raw);
		fclose($fp);
	}
}

?>
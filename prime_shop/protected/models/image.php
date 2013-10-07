<?php
class image{
    private $file;              //Путь к файлу с исходным изображением
    private $image;             //Исходное изображение
    private $image_new=false;   //Изображение после масштабирования
 	
    /*
    
    Пользоваться так :
    $image->resize(200, 200);
    $image->save('resized/mySmallImage.jpg');
     
    */
    
    /**
     * Загрузка файла для обработки
     *
     * @param string $file путь к файлу
     */
    public function __construct($file)
    {
        if(!file_exists($file)) return false;
 
        //Получаем информацию о файле
        list($width, $height, $image_type) = getimagesize($file);
 		
        //Создаем изображение из файла
        switch ($image_type)
        {
            case 1: $this->image = imagecreatefromgif($file); break;
            case 2: $this->image = imagecreatefromjpeg($file); break;
            case 3: $this->image = imagecreatefrompng($file); break;
            default: return '';  break;
        }
        $this->file=$file;
    }
 
    /**
     * Масштабирует исходное изображение
     *
     * @param int $W Ширина
     * @param int $H Высота
     */
    public function resize($W, $H)
    {
        $this->image_new=false;
 
        $X=ImageSX($this->image);
        $Y=ImageSY($this->image);
 
 
        $H_NEW=$Y;
        $W_NEW=$X;
 
        if($X>$W){
            $W_NEW=$W;
            $H_NEW=$W*$Y/$X;
        }
 
        if($H_NEW>$H){
            $H_NEW=$H;
            $W_NEW=$H*$X/$Y;
        }
 
        $H=(int)$H_NEW;
        $W=(int)$W_NEW;
 
 
        $this->image_new=imagecreatetruecolor($W,$H);
        imagecopyresampled($this->image_new,$this->image,0,0,0,0,$W,$H,$X,$Y);
 
    }
 
 
    /**
     * Сохранение файла
     *
     * @param string $file Путь к файлу (если не указан, записывает в исходный)
     * @param int $qualiti Качество сжатие JPEG
     */
    public function save($file=false, $qualiti=90)
    {
        if(!$file || $file==$this->file) {
            $file=$this->file;
            if(!$this->image_new) return true;
            else ImageJpeg($this->image_new, $file, $qualiti);
        }else{
            if(!$this->image_new) copy($this->file, $file);
            else ImageJpeg($this->image_new, $file, $qualiti);
        }
    }
}

?>

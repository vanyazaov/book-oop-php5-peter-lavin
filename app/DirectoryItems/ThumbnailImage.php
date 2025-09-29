<?php
// требуется GD 2.0.1 или выше
class ThumbnailImage
{
	private $image;
	// не применимо к gif или png
	private $quality = 100;
	private $mimetype;
	private $imageproperties;
	private $initialfilesize;
	
	public function __construct($file, $thumbnailsize = 100){
		// проверить путь
		is_file($file) or die ("Файл: $file не существует.");
		$this->initialfilesize = filesize($file);
		$this->imageproperties = getimagesize($file) or die ("Неправильный тип файла.");
		// новая функция image_type_to_mime_type
		$this->mimetype = image_type_to_mime_type($this->imageproperties[2]);	
		// создать изображение
		switch($this->imageproperties[2]){
			case IMAGETYPE_JPEG:
				$this->image = imagecreatefromjpeg($file);	
				break;
			case IMAGETYPE_GIF:	
				$this->image = imagecreatefromgif($file);
				break;
			case IMAGETYPE_PNG:
				$this->image = imagecreatefrompng($file);
				break;
			default:
				die("Не удалось создать изображение.");
		}
		$this->createThumb($thumbnailsize);
	}
	
	public function __destruct(){
		if(isset($this->image)){
			imagedestroy($this->image);			
		}
	}
	
	// вывод изображения
	public function getImage(){	
		header("Content-type: $this->mimetype");
		switch($this->imageproperties[2]){
			case IMAGETYPE_JPEG:
				imagejpeg($this->image,null,$this->quality);
				break;
			case IMAGETYPE_GIF:
				imagegif($this->image);
				break;
			case IMAGETYPE_PNG:
				imagepng($this->image);
				break;
			default:
				die("Не удалось создать изображение..");
		}
	}
	
	public function getMimeType(){
		return $this->mimetype;
	}
	
	public function getQuality(){
		$quality = null;
		if($this->imageproperties[2] == IMAGETYPE_JPEG){
			$quality = $this->quality;
		}
		return $quality;
	}
	
	public function setQuality($quality){
		if($quality > 100 || $quality  <  1){
			$quality = 75;
        }
		if($this->imageproperties[2] == IMAGETYPE_JPEG){
			$this->quality = $quality;
		}
	}
	
	public function getInitialFileSize(){	
		return $this->initialfilesize;
	}
	
	private function createThumb($thumbnailsize){
		// элементы массива
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
		// корректировать только если размер больше миниатюры
		if($srcW > $thumbnailsize || $srcH > $thumbnailsize) {
			$reduction = $this->calculateReduction($thumbnailsize);
			// получить пропорции
      		$desW = $srcW/$reduction;
      		$desH = $srcH/$reduction;								
			$copy = imagecreatetruecolor($desW, $desH);						
			imagecopyresampled($copy,$this->image,0,0,0,0,$desW, $desH, $srcW, $srcH)
				 or die ("Копирование изображения не удалось.");			
			// уничтожить оригинал
			imagedestroy($this->image);
			$this->image = $copy;		
		}
	}
	
	private function calculateReduction($thumbnailsize){
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
		// вычисление коэф. масшабирования
      	if($srcW < $srcH){
      		$reduction = round($srcH/$thumbnailsize);
      	}else{  			
      		$reduction = round($srcW/$thumbnailsize);
      	}
		return $reduction;
	}
}

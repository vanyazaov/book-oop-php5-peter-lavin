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
		//$this->createThumb($thumbnailsize);
	}
}

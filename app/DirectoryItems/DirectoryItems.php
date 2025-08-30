<?php 
// везде добавляем модификаторы доступа public/private
class DirectoryItems 
{
	// переменная экземпляра/член данных/свойство
	// используем модификаторы доступа, появившиеся в PHP5 и закрываем свойства класса от внешних изменений.
	private $filearray = array();

	// Используем для конструктора волшебный метод вместо имени класса.
	public function __construct($directory){ // в качестве параметра принимает строковую переменную
		$d = '';
		if(is_dir($directory))
		{
			$d = opendir($directory) or die("Не могу открыть каталог.");
			while(false !== ($f = readdir($d)))
			{
				if(is_file("$directory/$f"))
				{
					$this->filearray[]=$f;
				}
			}
			closedir($d);
		}else{
			//error
			die('Следует передать имя каталога.');
		}
	}

	// обертывающие методы (методы для доступа к уже имеющимся функциям PHP)
	public function indexOrder(){
		sort($this->filearray);
	}
	public function naturalCaseInsensitiveOrder(){
		natcasesort($this->filearray);
	}
	public function getCount() {
		return count($this->filearray);
	}
	// метод, проверяющий, что все файлы содержат изображения
	public function checkAllImages(){
		$bln=true;
		$extension='';
		$types= array('jpg', 'jpeg', 'gif', 'png');
		foreach ($this->filearray as $value){
			$extension = substr($value,(strpos($value, ".")+1));
			$extension = strtolower($extension);
			if(!in_array($extension, $types)){
				$bln = false;
				break;
			}
		}
		return $bln;
	}
	// метод, отдающий собранный массив данных
	public function getFileArray(){
		return $this->filearray;
	}			
}

<?php 
// Модифицируем класс, расширяя его возможности
// Вместо списка будем создавать ассоциативный массив, в котором в качестве ключей будут имена файлов
// Это позволит использовать их в качестве имени к картинке
class DirectoryItems 
{
	private $filearray = array();
	// свойство класса для хранения символа замены
	private $replacechar;
	// свойство класса для хранения переданного имени директории с файлами
	private $directory;

	// Модифицируем конструктор, добавив новый параметр, 
	// по которому будем определять символ в имени файла для замены на пробел
	// по умолчанию, это будет "_"
	public function __construct($directory, $replacechar = "_") {
	    // производим инициализацию свойств объекта переданными значениями
		$this->directory = $directory;
		$this->replacechar = $replacechar;
		
		$d = '';
		if(is_dir($directory)) {
			$d = opendir($directory) or die("Не могу открыть каталог.");
			while(false !== ($f = readdir($d))) {
				if(is_file("$directory/$f")) {
					// используем новый метод для создания заголовка файлу
					$title = $this->createTitle($f);
					// сохраняем как ассоциативный массив
					$this->filearray[$f] = $title;
				}
			}
			closedir($d);
		} else {
			//error
			die('Следует передать имя каталога.');
		}
	}
	
	// Добавили деструктор, который уничтожит свойство с массивом
	public function __destruct(){
		unset($this->filearray);
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
		foreach ($this->filearray as $key => $value) {
			$extension = substr($key,(strpos($key, ".")+1));
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
	
	// Добавили вспомогательный метод для формирования заголовка из имени файла
	private function createTitle($title) {
		// убираем расширение у имени
		$title = substr($title, 0, strrpos($title, "."));
		// заменяем разделители слов
		$title = str_replace($this->replacechar, " ", $title);
		return $title;
	}			
}

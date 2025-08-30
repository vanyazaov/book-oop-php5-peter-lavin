<?php 

class DirectoryItems 
{
	// переменная экземпляра/член данных/свойство
	var $filearray = array();
	////////////////////////////////////////////////////////////////////
	//constructor
	////////////////////////////////////////////////////////////////////
	function DirectoryItems($directory){ // в качестве параметра принимает строковую переменную
		$d = '';
		if(is_dir($directory))
		{
			$d = opendir($directory) or die("Не могу открыть каталог.");
			while(false !== ($f = readdir($d)))
			{
				if(is_file("$directory/$f"))
				{
					$this->filearray[]=$f; // используем $this-> для доступа к свойству текущего объекта
				}
			}
			closedir($d);
		}else{
			//error
			die('Следует передать имя каталога.');
		}
	}
	////////////////////////////////////////////////////////////////////
	//public functions 
	////////////////////////////////////////////////////////////////////
	// обертывающие методы (методы для доступа к уже имеющимся функциям PHP)
	function indexOrder(){
		sort($this->filearray);
	}
	function naturalCaseInsensitiveOrder(){
		natcasesort($this->filearray);
	}
	function getCount() {
		return count($this->filearray);
	}
	// метод, проверяющий, что все файлы содержат изображения
	function checkAllImages(){
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
	function getFileArray(){
		return $this->filearray;
	}			
}

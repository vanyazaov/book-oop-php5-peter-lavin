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
}

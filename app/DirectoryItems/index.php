<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>DirectoryItems * Images</title>
</head>
<body>
    <h1>DirectoryItems</h1>
    <p><a href="/">Вернуться назад</a></p>
    <?php
        // требуем файл, содержащий определение класса
        require 'DirectoryItems.php';
        $directory = 'graphics';
        // в PHP5 объекты передаются по ссылке по умолчанию, синтаксис  =& излишен.
        $di = new DirectoryItems($directory, '-');
        // убеждаемся, что все файлы в каталоге - изображения
        $di->imagesOnly();
        // сортируем имена без учета регистра
        $di->naturalCaseInsensitiveOrder();
        // получаем массив
        $filearray = $di->getFileArray();
        echo "<div style=\"text-align:center;\">";
        echo "Нажмите на имя файла, чтобы просмотреть полную версию.<br />";
        // перебираем массив и выводим собранные данные
        $size = 100;  
        foreach ($filearray as $key => $value){
            $path = "$directory/".$key;
             
	        echo "<img src=\"getthumb.php?path=$path&amp;size=$size\" 
	             style=\"border:1px solid black;margin-top:20px;\" 
	             alt= \"$value\"/><br> <a href=\"$path\" target=\"_blank\">Title: $value</a><br />\n";
        }
        echo "</div><br />";
    ?>
</body>
</html>

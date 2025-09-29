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
        // в PHP5 объекты передаются по ссылке по умолчанию, синтаксис  =& излишен.
        $di = new DirectoryItems('graphics', '-');
        // убеждаемся, что все файлы в каталоге - изображения
        if(!$di->checkAllImages()){
            // Если не так, то оставляем только изображения
	        $di->imagesOnly();
        }
        // сортируем имена без учета регистра
        $di->naturalCaseInsensitiveOrder();
        // получаем массив
        $filearray = $di->getFileArray();
        echo "<div style=\"text-align:center;\">";
        // перебираем массив и выводим собранные данные
        foreach ($filearray as $key => $value){
	        echo "<img src=\"graphics/$key\" /><br />Title: $value<br />\n";
        }
        echo "</div><br />";
    ?>
</body>
</html>

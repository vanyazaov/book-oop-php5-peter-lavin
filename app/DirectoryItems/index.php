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
        // создаем объект и возвращаем ссылку на неё (совместимость с PHP4)
        // передаем в конструктор имя каталога
        $di =& new DirectoryItems('graphics');
        // убеждаемся, что все файлы в каталоге - изображения
        $di->checkAllImages()or die('Не все файлы графические.');
        // сортируем имена без учета регистра
        $di->naturalCaseInsensitiveOrder();
        // получаем массив
        $filearray = $di->getFileArray();
        echo "<div style=\"text-align:center;\">";
        // перебираем массив и выводим собранные данные
        foreach ($filearray as $value){
	        echo "<img src=\"graphics/$value\" /><br />file name: $value<br />\n";
        }
        echo "</div><br />";
    ?>
</body>
</html>

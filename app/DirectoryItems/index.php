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
        require 'DirectoryItems.php';
        $di =& new DirectoryItems('graphics');
        $di->checkAllImages() or die('Не все файлы графические.');
        $di->naturalCaseInsensitiveOrder();
        // получаем массив
        $filearray = $di->getFileArray();
        var_dump($filearray);
    ?>
</body>
</html>

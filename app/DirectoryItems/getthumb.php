<?php
// этот файл будет источником для тега img
require 'ThumbnailImage.php';

$path = @$_GET["path"];
$maxsize = (int) @$_GET["size"];
if(!$maxsize){
	$maxsize=100;
}
if(isset($path)){
  $thumb = new ThumbNailImage($path, $maxsize);	
  $thumb->getImage();
}

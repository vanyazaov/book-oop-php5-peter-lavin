<?php
//this file will be the src for an img tag
require 'ThumbnailImage.php';

$thumb = new ThumbNailImage('graphics/Picture-010.jpg', 500);	
$thumb->getImage();

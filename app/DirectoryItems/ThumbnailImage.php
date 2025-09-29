<?php
// требуется GD 2.0.1 или выше
class ThumbnailImage
{
	private $image;
	// не применимо к gif или png
	private $quality = 100;
	private $mimetype;
	private $imageproperties;
	private $initialfilesize;
}

<?php

namespace ThatChrisR\Image\ImageType;

use ThatChrisR\Image\ImageType\ImageTypeInterface;

class GifTypeImage implements ImageTypeInterface
{

	public function create_image($image)
	{
		return imagecreatefromgif($image);
	}

}
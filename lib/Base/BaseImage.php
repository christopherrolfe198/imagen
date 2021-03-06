<?php
/**
 * This is the main image class
 *
 * @package \ThatChrisR\Imagen
 * @author Christopher Rolfe christopher.rolfe198@gmail.com
 */

namespace ThatChrisR\Imagen\Base;

use ThatChrisR\Imagen\ImageType\ImageTypeFactory;
use \Exception;

/**
 * The base class to handle accessing the image properties
 */
class BaseImage
{
	/**
	 * The image resource
	 */
	private $_image;

	/**
	 * The images height
	 */
	protected $_height;

	/**
	 * The images width
	 */
	protected $_width;

	/**
	 * Creates our basic image and grabs the height and width
	 *
	 * @param string $imagePath Path the the image we are manipulating
	 */
	public function __construct($imagePath)
	{
		try {
			$this->_image = $this->_get_image($imagePath);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		$this->_width = imagesx($this->_image);
		$this->_height = imagesy($this->_image);
	}

	public function __toString()
	{
		return $this->_image;
	}

	/**
	 * Simple getter to return the image height
	 */
	public function get_image_height()
	{
		return $this->_height;
	}
	
	/**
	 * Simple getter to return the image width
	 */
	public function get_image_width()
	{
		return $this->_width;
	}

	/**
	 * Returns the image resource to be manipulated
	 *
	 * @todo investigate whether this can be removed by restructuring the code
	 *
	 * @return resource Image resource
	 */
	public function get_image_resource()
	{
		return $this->_image;
	}

	public function set_image_resource($image)
	{
		$this->_image = $image;
	}

	/**
	 * Creates an image from the factory and returns the image resource
	 *
	 * @param string $imagePath Path the the image we are manipulating
	 */
	private function _get_image($imagePath)
	{
		if(is_resource($imagePath)) {
			if (get_resource_type($imagePath) == 'gd') {
				return $imagePath;
			}
		}

		// Create our factory and get a class that can instantiate the image
		$imageFactory = new ImageTypeFactory();
		try {
			$imageType = $imageFactory::create(pathinfo($imagePath, PATHINFO_EXTENSION));
			// Because the class implements our interface we know it has a create image method
			$image = $imageType->create_image($imagePath);
			return $image;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}

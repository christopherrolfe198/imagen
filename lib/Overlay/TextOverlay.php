<?php
/**
 * Overlays text
 *
 * @package \ThatChrisR\Imagen
 * @author Christopher Rolfe christopher.rolfe198@gmail.com
 */

namespace ThatChrisR\Imagen\Overlay;

use ThatChrisR\Imagen\Base\BaseImage;

/**
 * Handles overlaying text
 */
class TextOverlay
{
	/**
	 * Holds the image to manipulate, must be an instance of BaseImage
	 */
	private $image;

	/**
	 * An array to handle fonts
	 */
	public static $fonts = array();

	/**
	 * An array to handle the text colours
	 */
	public static $colours = array();

	public function __construct(BaseImage $image)
	{
		$this->image = $image->get_image_resource();
	}

	/**
	 * Adds a font to the fonts array
	 */
	public static function add_font($font_name, $font_path)
	{
		self::$fonts[$font_name] = $font_path;
	}

	/**
	 * Adds a colour to the colours array
	 */
	public static function add_colour($colour_name, $colour_path)
	{
		self::$colours[$colour_name] = $colour_path;
	}

	/**
	 * Adds text to an image
	 * @todo migrate the creation of a colour resource out of the function
	 * @todo Set the xpos and ypos to be done based on percentages
	 */
	public function add_text($text, $colour_name, $font_name, $xpos = 0, $ypos = 0, $size = 16)
	{
		$colour = self::$colours[$colour_name];

		if (is_string($colour)) {
			self::$colours[$colour_name] = $this->_create_hex_colour_resource($colour);
		}

		imagettftext(
			$this->image,					// Image resource
			$size,							// Font size
			0,								// Font Angle
			$xpos,							// X position
			$ypos,							// Y position
			self::$colours[$colour_name],	// Colour to use from the array
			self::$fonts[$font_name],		// Font to use from array
			$text 							// Text to add
			);
		return $this->image;
	}

	protected function _create_hex_colour_resource($colour) {
		$first = intval(substr($colour, 0, 2));
		$second = intval(substr($colour, 2, 2));
		$third = intval(substr($colour, 4, 2));
		return imagecolorallocate($this->image, $first, $second, $third);
	}
}

<?php

namespace Barcode;

class Barcode_Driver
{
	/**
	* Driver config
	* @var array
	*/
	protected $config = array(
		'font'    => '',
		'color'   => array(),
		'bgcolor' => array(),
		'height'  => '',
		'width'   => '',
		'scale'   => '',
		'format'  => ''
	);

	/**
	* Driver constructor
	*
	* @param array $config driver config
	*/
	public function __construct(array $config = array())
	{
		\Arr::merge($this->config, $config);
	}

	/**
	* Get a driver config setting.
	*
	* @param string $key the config key
	* @return mixed the config setting value
	*/
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	* Set a driver config setting.
	*
	* @param string $key the config key
	* @param mixed $value the new config value
	* @return object $this for chaining
	*/
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	/**
	* Set the font.
	*
	* @param string $font the font path or name
	* @param mixed $auto autoload the font from vendor/WINDIR
	* @return object $this for chaining
	*/
	public function set_font($font, $auto = false)
	{
		if ($auto)
		{
			if ($win = \Input::server('WINDIR', false) && file_exists($win))
			{
				return $this->set_config('font', $win . '\Fonts\\' . $font . '.ttf');
			}
			else
			{
				return $this->set_config('font', \Package::exists('barcode') . 'vendor' . DS . $font . '.ttf');
			}
		}
		else
		{
			return $this->set_config('font', $font);
		}
	}

	/**
	* Set the color.
	*
	* @param int $red The red value
	* @param int $green The green value
	* @param int $blue The blue value
	* @return object $this for chaining
	*/
	public function set_color($red = 0, $green = 0, $blue = 0)
	{
		return $this->set_config('color', array($red, $green, $blue));
	}

	/**
	* Set the bgcolor.
	*
	* @param int $red The red value
	* @param int $green The green value
	* @param int $blue The blue value
	* @return object $this for chaining
	*/
	public function set_bgcolor($red = 0, $green = 0, $blue = 0)
	{
		return $this->set_config('bgcolor', array($red, $green, $blue));
	}

	/**
	* Set the colors with hex values
	*
	* @param string		color 		The foreground color to set (In hexadecimal values)
	* @param string		bgcolor 	The Background color to set (In hexadecimal values)
	* @return object $this for chaining
	*/
	function set_hexcolor($color, $bgcolor) {
		$this->set_color(hexdec(\Str::sub($color, 1, 2)), hexdec(\Str::sub($color, 3, 2)), hexdec(\Str::sub($color, 5, 2)));
		$this->set_bgcolor(hexdec(\Str::sub($bgcolor, 1, 2)), hexdec(\Str::sub($bgcolor, 3, 2)), hexdec(\Str::sub($bgcolor, 5, 2)));
		return $this;
	}

	/**
	* Set the scale
	*
	* @param int $scale The scale value
	* @return object $this for chaining
	*/
	public function set_scale($scale)
	{
		return $this->set_config('scale', $scale);
	}

	/**
	* Set the format (PNG, JPG)
	*
	* @param int $format The format value
	* @return object $this for chaining
	*/
	public function set_format($format)
	{
		return $this->set_config('format', $format);
	}
}
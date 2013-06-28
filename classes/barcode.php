<?php

namespace Barcode;

class BarcodeException extends \FuelException {}

class Barcode
{

	public static function forge($driver, array $config = array())
	{
		$class = '\\Barcode\\Barcode_' . ucfirst(strtolower($driver));

		if( ! class_exists($class, true))
		{
			throw new \FuelException('Could not find Barcode driver: ' . $class);
		}

		return new $class($config);
	}

	/**
	 * class constructor
	 *
	 * @param	void
	 * @access	private
	 * @return	void
	 */
	final private function __construct() {}

}
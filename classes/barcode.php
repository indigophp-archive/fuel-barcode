<?php

namespace Barcode;

class BarcodeException extends \FuelException {}

class Barcode
{

	public static function forge($driver, $config = array())
	{
		$class = '\\Barcode\\Barcode_' . ucfirst(strtolower($driver));
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
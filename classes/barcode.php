<?php

namespace Barcode;

class BarcodeException extends \FuelException {}

class Barcode
{
	/**
	 * Barcode driver forge.
	 *
	 * @param	string			$driver		Driver name
	 * @param	mixed			$config		Extra config array
	 * @return  Queue instance
	 */
	public static function forge($driver = 'tcpdf', array $config = array())
	{
		$class = '\\Barcode\\Barcode_' . ucfirst(strtolower($driver));

		if( ! class_exists($class, true))
		{
			throw new \FuelException('Could not find Barcode driver: ' . $class);
		}

		return new $class($driver, $config);
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
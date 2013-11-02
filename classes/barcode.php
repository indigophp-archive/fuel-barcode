<?php

namespace Barcode;

class BarcodeException extends \FuelException {}

class Barcode
{
	/**
	 * Default config
	 *
	 * @var array
	 */
	protected static $_defaults = array();

	/**
	 * Init
	 */
	public static function _init()
	{
		\Config::load('barcode', true);
		static::$_defaults = \Config::get('barcode.defaults', array());
	}

	/**
	 * Barcode driver forge.
	 *
	 * @param	array			$config		Config array or driver name
	 * @return  Barcode_Driver
	 */
	public static function forge($config = array())
	{
		// When a string was passed it's just the driver type
		if (is_string($config))
		{
			$driver = $config;
			$config = array();
		}

		// Get driver if not set, get it from config
		empty($driver) and $driver = \Arr::get($config, 'driver', \Config::get('barcode.driver', 'tcpdf'));

		$class = '\\Barcode\\Barcode_' . ucfirst(strtolower($driver));

		if( ! class_exists($class))
		{
			throw new \FuelException('Could not find Barcode driver: ' . $class);
		}

		$config = \Arr::merge(static::$_defaults, \Config::get('barcode.drivers.' . $driver, array()), $config);

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

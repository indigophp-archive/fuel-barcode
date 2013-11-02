<?php

namespace Barcode;

abstract class Barcode_Driver
{
	/**
	* Driver config
	*
	* @var array
	*/
	protected $config = array();

	/**
	 * Driver instance
	 *
	 * @var mixed
	 */
	protected $instance = null;

	/**
	 * Formats supported by driver
	 *
	 * @var array
	 */
	protected $formats = array();

	/**
	* Driver constructor
	*
	* @param array $config driver config
	*/
	public function __construct(array $config = array())
	{
		$this->config = $config;
	}

	/**
	* Get a driver config setting
	*
	* @param	string|null		$key		Config key
	* @param	mixed			$default	Default value
	* @return	mixed						Config setting value or the whole config array
	*/
	public function get_config($key = null, $default = null)
	{
		return is_null($key) ? $this->config : \Arr::get($this->config, $key, $default);
	}

	/**
	* Set a driver config setting
	*
	* @param	string|array	$key		Config key or array of key-value pairs
	* @param	mixed			$value		New config value
	* @return	$this						$this for chaining
	*/
	public function set_config($key, $value = null)
	{
		if (is_array($key))
		{
			$this->config = \Arr::merge($this->config, $key);
		}
		else
		{
			\Arr::set($this->config, $key, $value);
		}

		return $this;
	}

	/**
	 * Initialize driver
	 *
	 * @param  string $code Barcode data
	 * @param  string $type Barcode type
	 * @return $this
	 */
	public function init($code, $type)
	{
		if ( ! in_array(strtolower($type), $this->formats))
		{
			throw new BarcodeException('Format ' . $type . ' is not supported by this driver :' . get_called_class());
		}

		$this->instance = call_user_func(array($this, '_initialize'), $code, $type);
		return $this;
	}

	/**
	 * Abstract function to load the driver
	 *
	 * @return mixed Driver instance
	 */
	abstract protected function _initialize($code, $type);

	/**
	 * Get default values
	 *
	 * @return mixed
	 */
	abstract public function get_defaults($ext = 'pnga');


	/**
	 * Magic functions catching non-existent functions/variables and passing them to the driver
	 */

	public function __call($method, $arguments)
	{
		if (method_exists($this->instance, $method))
		{
				$return = call_user_func_array(array($this->instance, $method), $arguments);
				return $return;
		}
		else
		{
			throw new \BadMethodCallException('Invalid method: '.get_called_class().'::'.$method);
		}
	}

	public function __get($name)
	{
		if (isset($this->{$name}))
		{
			return $this->{$name};
		}
		elseif(isset($this->instance->{$name}))
		{
			return $this->instance->{$name};
		}
		else
		{
			throw new \OutOfBoundsException('Undefined property: ' . get_called_class() . '::' . $name);
		}
	}

	public function __set($name, $value)
	{
		if (isset($this->{$name})) {
			$this->{$name} = $value;
		}
		else
		{
			$this->instance->{$name} = $value;
		}
	}
}

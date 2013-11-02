<?php

namespace Barcode;

abstract class Controller_Barcode extends \Controller
{
	/**
	 * Barcode instance
	 *
	 * @var Barcode_Driver
	 */
	protected $barcode;

	protected $data = array();

	public function before($data = null)
	{
		parent::before($data);

		$data = array();

		if ( ! $this->request->is_hmvc())
		{
			$data = array(
				'type'   => \Input::param('type', 'c39'),
				'width'  => (int) \Input::param('width', \Input::param('w')),
				'height' => (int) \Input::param('height', \Input::param('h')),
				'color'  => \Input::param('color', \Input::param('c'))
			);
		}

		$data = \Arr::merge($data, \Uri::to_assoc(4));
		$this->data = array_filter($data);
	}

	public function action_index($code)
	{
		if (strpos($code, '.'))
		{
			$code = explode('.', $code);

			$ext = $code[1];
			$code = $code[0];
		}
		else
		{
			$ext = \Input::param('ext', \Input::extension() ?: 'png');
		}

		$this->barcode->init($code, $this->data['type']);

		is_callable(array($this, $ext)) or $ext = 'png';

		$data = $this->barcode->get_defaults($ext);
		$data = \Arr::merge($data, \Arr::filter_keys($this->data, array_keys($data)));
		return \Response::forge(call_user_func_array(array($this, $ext), $data), 200, array('Content-Disposition' => 'inline; filename="' . $code . '.' . $ext . '"'));
	}

	abstract public function png();

	public function router($method, $params)
	{
		if ( ! is_callable(array($this, 'action_' . $method)))
		{
			return $this->action_index($method);
		}
		else
		{
			return call_user_func_array(array($this, 'action_' . $method), $params);
		}
	}
}
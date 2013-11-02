<?php

namespace Barcode;

class Controller_Barcode_Tcpdf extends Controller_Barcode
{
	public function before($data = null)
	{
		$this->barcode = Barcode::forge('tcpdf');

		return parent::before($data);
	}

	public function png()
	{
		$data = func_get_args();

		if (isset($data[2]))
		{
			if (is_string($data[2]) and strpos($data[2], '|'))
			{
				$data[2] = explode('|', $data[2]);
			}
			else
			{
				$data[2] = array(0, 0, 0);
			}
		}

		return call_user_func_array(array($this->barcode, 'getBarcodePNG'), $data);
	}

	public function svg()
	{
		return call_user_func_array(array($this->barcode, 'getBarcodeSVG'), func_get_args());
	}

	public function svgi()
	{
		return call_user_func_array(array($this->barcode, 'getBarcodeSVGcode'), func_get_args());
	}

	public function html()
	{
		return call_user_func_array(array($this->barcode, 'getBarcodeHTML'), func_get_args());
	}
}

<?php

namespace Barcode;

class Barcode_Tcpdf extends Barcode_Driver
{
	public function init($code, $type)
	{
		if (in_array(strtolower($type), array('datamatrix', 'qrcode', 'pdf417')))
		{
			$barcode = new \TCPDF2DBarcode($code, $type);
		}
		else
		{
			$barcode = new \TCPDFBarcode($code, $type);
		}

		$this->instance = $barcode;

		return $this;
	}
}
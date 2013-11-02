<?php

namespace Barcode;

class Barcode_Tcpdf extends Barcode_Driver
{
	protected $formats = array(
		'c39',
		'c39+',
		'c39e',
		'c39e+',
		'c93',
		's25',
		's25+',
		'i25',
		'i25+',
		'c128',
		'c128a',
		'c128b',
		'c128c',
		'ean2',
		'ean5',
		'ean8',
		'ean13',
		'upca',
		'upce',
		'msi',
		'msi+',
		'postnet',
		'planet',
		'rms4cc',
		'kix',
		'imb',
		'codabar',
		'code11',
		'pharma',
		'pharma2t',
		'datamatrix',
		'pdf417',
		'pdf417,a',
		'pdf417,e',
		'pdf417,t',
		'pdf417,s',
		'pdf417,f',
		'pdf417,o0',
		'pdf417,o1',
		'pdf417,o2',
		'pdf417,o3',
		'pdf417,o4',
		'pdf417,o5',
		'pdf417,o6',
		'qrcode',
		'qrcode,l',
		'qrcode,m',
		'qrcode,q',
		'qrcode,h',
		'raw',
		'raw2',
		'test',
	);

	protected $d2 = array(
		'datamatrix',
		'pdf417',
		'pdf417,a',
		'pdf417,e',
		'pdf417,t',
		'pdf417,s',
		'pdf417,f',
		'pdf417,o0',
		'pdf417,o1',
		'pdf417,o2',
		'pdf417,o3',
		'pdf417,o4',
		'pdf417,o5',
		'pdf417,o6',
		'qrcode',
		'qrcode,l',
		'qrcode,m',
		'qrcode,q',
		'qrcode,h',
		'raw',
		'raw2',
		'test',
	);

	protected function _initialize($code, $type)
	{
		if (in_array(strtolower($type), $this->d2))
		{
			$barcode = new \TCPDF2DBarcode($code, $type);
		}
		else
		{
			$barcode = new \TCPDFBarcode($code, $type);
		}

		return $barcode;
	}

	public function get_defaults($ext = 'png')
	{
		if ($this->instance instanceof \TCPDF2DBarcode)
		{
			$default = array(
				'width'  => 3,
				'height' => 3,
				'color'  => 'black'
			);

			switch ($ext) {
				case 'html':
					$default['width'] = 10;
					$default['height'] = 10;
					break;
				case 'png':
					$default['color'] = array(0, 0, 0);
					break;
			}
		}
		else
		{
			$default = array(
				'width'  => 2,
				'height' => 30,
				'color'  => 'black'
			);

			switch ($ext) {
				case 'png':
					$default['color'] = array(0, 0, 0);
					break;
			}
		}

		return $default;
	}
}

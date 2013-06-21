<?php

namespace Barcode;

class Controller_Barcode_Tcpdf extends \Controller
{
	public function action_index($code = null, $type = null, $width = null, $height = null, $color = null)
	{
		is_null($code) && $code = \Input::param('code');
		is_null($type) && $type = \Input::param('type');

		is_null($width) && $width = \Input::param('width', \Input::param('w', 2));
		is_null($height) && $height = \Input::param('height', \Input::param('h', 30));
		is_null($color) && $color = \Input::param('color', \Input::param('c', 'black'));

		$barcode = Barcode::forge('tcpdf');
		$barcode->init($code, $type);

		switch (\Input::extension()) {
			case 'png':
				! is_array($color) && $color = array(0, 0, 0);
				$barcode->getBarcodePNG($width, $height, $color);
				break;

			case 'svg':
				$barcode->getBarcodeSVG($width, $height, $color);
				break;

			case 'svgi':
				$barcode->getBarcodeSVGcode($width, $height, $color);
				break;

			case 'html':
				$barcode->getBarcodeHTML($width, $height, $color);
				break;

			default:
				! is_array($color) && $color = array(0, 0, 0);
				$barcode->getBarcodePNG($width, $height, $color);
				break;
		}
	}
}
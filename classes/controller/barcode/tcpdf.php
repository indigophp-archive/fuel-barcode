<?php

namespace Barcode;

class Controller_Barcode_Tcpdf extends \Controller
{

	protected $barcode;

	protected $data = array(
		'type'   => 'c39',
		'ext'    => 'png',
		'width'  => 2,
		'height' => 30,
		'color'  => 'black'
	);

	public function before($data = null)
	{
		parent::before($data);

		$this->barcode = Barcode::forge('tcpdf');

		if ( ! $this->request->is_hmvc())
		{
			$data = array(
				'code'   => \Input::param('code'),
				'type'   => \Input::param('type', 'c39'),
				'ext'    => \Input::param('ext', \Input::extension()),
				'width'  => \Input::param('width', \Input::param('w', 2)),
				'height' => \Input::param('height', \Input::param('h', 30)),
				'color'  => \Input::param('color', \Input::param('c', 'black'))
			);
			$this->data = \Arr::merge($this->data, $data);
		}

		$this->data = \Arr::merge($this->data, \Uri::to_assoc(4));

		if ($this->get('ext') == 'png') {
			$color = \Arr::get($this->data, 'color', '');

			if (is_string($color) && strpos($color, '|') !== false)
			{
				\Arr::set($this->data, 'color', explode('|', $color));
			}
		}

		$this->barcode->init($this->get('code'), $this->get('type'));
	}

	public function get($item)
	{
		return \Arr::get($this->data, $item);
	}

	public function action_index()
	{

		switch ($this->get('ext')) {
			case 'png':
				$this->action_png();
				break;

			case 'svg':
				$this->action_svg();
				break;

			case 'svgi':
				$this->action_svgi();
				break;

			case 'html':
				return $this->action_html();
				break;

			default:
				$this->action_png();
				break;
		}
	}

	public function action_png()
	{
		$color = $this->get('color');
		! is_array($color) && $color = array(0, 0, 0);

		$this->barcode->getBarcodePNG($this->get('width'), $this->get('height'), $color);
	}

	public function action_svg()
	{
	$this->barcode->getBarcodeSVG($this->get('width'), $this->get('height'), $this->get('color'));
	}

	public function action_svgi()
	{
		$this->barcode->getBarcodeSVGcode($this->get('width'), $this->get('height'), $this->get('color'));
	}

	public function action_html()
	{
		return $this->barcode->getBarcodeHTML($this->get('width'), $this->get('height'), $this->get('color'));
	}
}
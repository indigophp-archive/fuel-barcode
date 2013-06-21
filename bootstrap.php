<?php

Autoloader::add_core_namespace('Barcode');

Autoloader::add_classes(array(
	'Barcode\\Barcode' => __DIR__ . '/classes/barcode.php',
	'Barcode\\BarcodeException' => __DIR__ . '/classes/barcode.php',
	'Barcode\\Barcode_Driver' => __DIR__ . '/classes/barcode/driver.php',

	'Barcode\\Barcode_Tcpdf' => __DIR__ . '/classes/barcode/tcpdf.php',
	'Barcode\\Controller_Barcode_Tcpdf' => __DIR__ . '/classes/controller/barcode/tcpdf.php',
));
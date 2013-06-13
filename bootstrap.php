<?php


Autoloader::add_classes(array(
	'Barcode\\Barcode' => __DIR__ . '/classes/barcode.php',
	'Barcode\\BarcodeException' => __DIR__ . '/classes/barcode.php',
	'Barcode\\Barcode_Driver' => __DIR__ . '/classes/barcode/driver.php',
));
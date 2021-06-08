<?php
namespace Unisrc\xu\lib\enc\b64;

/*
	Convert standard base64 encoding to URL safe base64 encoding.

DESCR:
	Replace standard, but not url safe base64 chars,
	'+', '/' and '=' with url safe '-', '_', and ''.

PARAMS:
	$b64std
		A standard base64 string.

RETURNS:
	string
		url safe base64
*/
class stdtousf {

	public static function _($b64std){

		static $search = [ '+','/','=' ], $replace = [ '-','_', '' ];

		return str_replace($search, $replace, $b64std); 
	}
}

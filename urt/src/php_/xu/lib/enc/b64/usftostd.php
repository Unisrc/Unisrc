<?php
namespace Unisrc\xu\lib\enc\b64;

/*
	Convert URL safe base64 encoding to standard base64 encoding.
	
DESCR:
	Replace non standard, but url safe "base64" chars,
	'-' and '_' with the initial standard chars '+' and '/',
	and reconstruct the standard end padding with '=' chars.

PARAMS:
	$b64usf
		An urls safe "base64" string.

RETURNS:
	string
		standard base64
*/
class usftostd {

	public static function _($b64usf){

		static $search = [ '-','_' ], $replace = [ '+','/' ];

		$b64std = str_replace($search, $replace, $b64usf);

		if($m4 = (strlen($b64std) % 4)){

			$b64std .= substr('====', $m4);
		}

		return $b64std; 
	}
}

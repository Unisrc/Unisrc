<?php
namespace Unisrc\xu\lib\enc\b64;

use Unisrc\xu\lib\enc\b64\stdtousf;
/*
DESCR:
	Encode data from initial to base64 format.

PARAMS:
	$data
		The initial data to be encoded.

	$urlsafe	bool
		Replace the standard, but not url safe chars, with safe ones.
		See: stdtousf

RETURNS:
	string
		data in base 64 format.

NOTES:
• assert: use same $urlsafe value in encode, decode and validate
for a particular data io channel.
*/
class encode {

	public static function _($data, $urlsafe=true){

		$b64 = base64_encode($data); 

		return ($urlsafe) ? stdtousf::_($b64) : $b64; 
	}
}

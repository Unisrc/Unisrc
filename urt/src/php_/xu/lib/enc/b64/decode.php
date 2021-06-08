<?php
namespace Unisrc\xu\lib\enc\b64;

use Unisrc\xu\lib\enc\b64\usftostd;

/*
DESCR:
	Decode data from base64 to initial format .

PARAMS:
	$b64
		The base64 data to be decoded.

	$urlsafe	bool
		Restore the standard, not url safe chars, again
		See: usftostd

RETURNS:
	string
		data in initial format.

NOTES:
• assert: use same $urlsafe value in encode, decode and validate
for a particular data io channel.
*/
class decode {

	public static function _($b64, $urlsafe=true){

		if($urlsafe){ $b64 = usftostd::_($b64); }

		return base64_decode($b64); 
	}
}

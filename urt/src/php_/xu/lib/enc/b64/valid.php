<?php
namespace Unisrc\xu\lib\enc\b64;

/*
DESCR:
	Checks if all the characters in a string
	consists of chars that belong to base64 encoded string,
	in the two flavours this api provides; standard or urlsafe.

PARAMS:
	$b64
		base64 encoded string to check out

	$urlsafe	bool
		$b64 is url safe encoded.

NOTES:
• assert: use same $urlsafe value in encode, decode and validate
for a particular data io channel.
*/
class valid {

	public static function _($b64, $urlsafe=true){

		if(is_string($b64)){

			if(preg_match('/^[A-Za-z0-9'.(($urlsafe) ? '_-' : '+/=').']+/', $b64)){

				return true;
			}
		}

		return false;
	}
}

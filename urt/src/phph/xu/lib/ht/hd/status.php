<?php
namespace Unisrc\xu\lib\ht\hd;


/*
DESCR:
	Forms a status response header,
	that is send to the browser/user agent immediately.

PARAMS:
	$i		integer
		HTTP status code.
		See, the switch statement for supported options.

RETURNS:
	Nothing.


NOTES:

*/
class status {

	public static function _($i){

		switch($i){
		case 204: $t = 'No Content'; break;
		case 301: $t = 'Moved Permanently'; break;
		case 302: $t = 'Found'; break;
		case 307: $t = 'Temporary Redirect'; break;
		case 404: $t = 'Not Found'; break;
		}

		$stt = "HTTP/1.1 $i $t";

		header($stt);
	}
}

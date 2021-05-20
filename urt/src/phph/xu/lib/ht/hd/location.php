<?php
namespace Unisrc\xu\lib\ht\hd;

use Unisrc\xu\lib\ht\rq\navigation;

/*
DESCR:
	Depending on caller input, forms a particular HTTP "Location" header
	argument, that is returned or send to browser/user agent immediately.

PARAMS:
	$host
		false		default
			Uses current server HTTP host string.
		string
			'@' at [0]
				Redirects unconditionally to the specified URI, that follows the
				'@' character, as is, discarding any $path, $qstr and $ret
				settings.

				It is the same as calling: header('Location: '.$yourstring);
			any
				Must be any valid HTTP host name URI component.

	$path
		false		default
			Any path is excluded from location
		true
			Current path is used equally in location
		string
			Given path is used in location

	$qstr
		false		default
			Any query string is excluded from location
		true
			Current query string is used equally in location
		string
			Given query string is used in location

	$ret
		false		default
			Don't return resulting location string, redirect immediately.
		true
			Return resulting location string, omit the redirect.
			This will not work when $host is string starting with '@'.

RETURNS:
	nothing
		arg host[0]=='@'||ret==false
	string
		arg host[0]!='@'&&ret==true

NOTES:

*/
class location {

	public static function _($host=false, $path=false, $qstr=false, $ret=false){

		if(isset($host[0]) && ($host[0] == '@')){//specify any redirect string

			$location = substr($host, 1);

		}else{

			list(, , $svurl, $navurl) = navigation::_();

			$protocol = (array_key_exists('HTTPS', $_SERVER)) ? 'https' : 'http';

			if(!$host){ $host = $_SERVER['HTTP_HOST']; }

			$location = $protocol.'://'.$host.$svurl;

			if($path){
				if($path === true){
					$location .= $navurl;
				}else{
					$location .= '/'.trim($path, '/');
				}
			}

			$location = rtrim($location, '/').'/';

			if($qstr){
				if($qstr === true){
					$qstr =  ($qs = $_SERVER['QUERY_STRING']) ? ('?'.$qs) : '';
				}
				$location .= '?'.$qstr;
			}

			if($ret){ return $location; }
		}

		header('Location: '.$location);
		exit();
	}
}

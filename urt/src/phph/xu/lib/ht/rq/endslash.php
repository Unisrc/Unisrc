<?php
namespace Unisrc\xu\lib\ht\rq;

use Unisrc\xu\lib\ht\hd\status;
use Unisrc\xu\lib\ht\hd\location;

/*
DESCR:
	Enforces that $navurl ends with a '/',
	and if not, a "301 Moved Permanently" redirect will be performed
	to the same path with '/' appended.

PARAMS:
	list(, , $svurl, $navurl) = navigation::_()

RETURNS:
	nothing

NOTES:

*/
class endslash {

	public static function _($svurl, $navurl){

		//last char of navurl is not a slash
		if(($ch = $navurl[strlen($navurl) - 1]) != '/'){

			/*
			If navurl does not end with '/', as it is supposed to...
			enforce always ending with '/', so that query strings can be
			attached like '/nav/i/ga/tion/url/?name=value&name2=value2&...'
			*/

			$pd = strrpos($navurl, '.');
			$ps = strrpos($navurl, '/');

			/*
			there is no dot ||
			last dot comes before last slash; it's not an url to a file ||
			last dot is last char; odd ball is considered path component
			*/
			if(($pd === false) || ($pd < $ps) || ($ch == '.')){

				/*
				conclusion:
				last component of navurl:
				+ has no ending slash
				+ does not spec a file/mime type, since it has no extension
				+ should be a dir component
				Do correction:
				*/
				$location = '@http'.((isset($_SERVER['HTTPS'])) ? 's':'').'://'
							.$_SERVER['HTTP_HOST'].$svurl.$navurl
							.'/' //this is it!
							.(($query = $_SERVER['QUERY_STRING']) ? '?'.$query : '')
							;
				/*
				NOTE: location::_() is designed to build the kind of URLs
				we just did above, but for that part, it indirectly requires
				this call to complete; have $navurl endslash corrected.
				*/

				status::_(301);
				location::_($location);

				exit();
			}
		}
	}
}

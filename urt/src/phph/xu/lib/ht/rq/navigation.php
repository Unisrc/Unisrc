<?php
namespace Unisrc\xu\lib\ht\rq;


/*
DESCR:
	Analyses the HTTP navigation URL, and returns a list of convenient
	variables.

PARAMS:
	none

RETURNS:
	array
		Having the following contents...

			[ $svroot, $svdir, $svurl, $navurl ]

		where...

		$svroot
			Apache's DocumentRoot directory with '/' appended.
			i.e.: "/abs/path/www/"

		$svdir
			Apache's DocumentRoot + possible subdir this app is running from;
			i.e.: "/abs/path/www/urlpath/to/webapp/"

		$svurl
			$svdir's http url equivalent.
			If present always starts with '/' and never ends with '/'.
			If it is empty, the webapp is served at the root
			i.e.: "/urlpath/to/webapp"
			i.e.: ""	
			Also see: $navurl.

		$navurl
			Navigation on top of $svurl.
			
			It is always safe to do $svurl.$navurl to get the complet http
			urlpath inside the request URI.

			Always starts with a '/' and is at least '/'.

			Enforce to always have it end with '/' as well, take a look at
			function endslash().

			i.e.:
				$uri = "/urlpath/to/webapp/app/specific/nav/path/"; //???
				$svurl	= "/urlpath/to/webapp";
				$navurl	= "/app/specific/nav/path/";
			i.e.:
				$uri = "/webapp/app/specific/nav/path/"; //???
				$svurl	= "/webapp";
				$navurl	= "/app/specific/nav/path/";
			i.e.:
				$uri = "/app/specific/nav/path/"; //???
				$svurl	= "";
				$navurl	= "/app/specific/nav/path/";

NOTES:
*/
class navigation {

	public static function _(){

		static $data;

		if(!$data){

			$svroot = $_SERVER['DOCUMENT_ROOT'];

			//Full fs path of server directory (where index.php is)
			$svdir = dirname($_SERVER['SCRIPT_FILENAME']);

			/*
			Relative url of the server directory from document root
			It could be '' or '/a/sub/dir' where index.php is catching requests.
			Note: does never end with '/'.
			*/
			$svurl = str_replace($svroot, '', $svdir);

			$svroot .= '/';
			$svdir .= '/';

			//Navigation url on top of $svurl
			$navurl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

			//served from a subdir on top of DOCUMENT_ROOT
			if($svurl){
				//remove that same string from beginning of $navurl
				$navurl = substr($navurl, strlen($svurl));
			}
			
			$data =  [ $svroot, $svdir, $svurl, $navurl ];
		}

		return $data;
	}
}

<?php
namespace Unisrc\xu\lib;

/*
Class php_/xu/ubs/zzz/Env
initializes the data in this function
with a reference to the $Env object.

$Env is owned by the initialized app.
The app can add its own variables,
which are immediately available here.
The ones starting with '_' are private
and not returned by this function.
*/
class env {

	public static function _($k){

		static $Env;
		
		if($Env) return ($k[0] != '_') ? $Env->{$k} : null;

		//init once
		self::keys($Env = $k);
	}

	public static function keys($_=null){

		static $keys=[], $Env;

		if($keys) return $keys;//3. after 1 and 2 once.

		if($Env){//2. keys not collected yet; collect and return

			$list = array_keys((array)$Env);

			foreach($list as $k)
				if($k[0] != '_')
					$keys[] = $k;

			return $keys;
		}

		$Env = $_;//1. init by ::_(); drop of $Env ref.
	}
}
/*
○ NOTES:
♦ All Unisrc paths always end with a '/'. If not, it will be mentioned.

○ SUPPORTED KEYS:
♦ common:
	mts		float:		timestamp; microtime
	uts		integer:	timestamp
	cli		bool:		cli | http
	lcd		chars(2):	language code

	unisrc	abspath:	Unisrc directory
	urtree	abspath:	Unisrc Runtime Tree (URT)

	astsys	abspath:	URT ast/sys/ dir
	astwww	abspath:	URT ast/www/ dir
	cfgdir	abspath:	URT cfg/ dir; unit's config specifications and implementations
	srcdir	abspath:	URT src/ dir
	js_dir	abspath:	URT src/js_/ dir
	jsbdir	abspath:	URT src/jsb/ dir
	php_dir	abspath:	URT src/php_/ dir
	phpcdir	abspath:	URT src/phpc/ dir
	phphdir	abspath:	URT src/phph/ dir

	stctxa	string:		Storage context - app;	MUST be set by $Env owner APP
	stctxu	string:		Storage context - user; MAY be set by $Env owner APP

	unidat	abspath:	Unisrc's central data dir in stctxa | stctxu context
	datetc	abspath:	Data: Edit to config
	datmfs	abspath:	Data: Memory file system; small frequently changing files
	datvar	abspath:	Data: Variable data; larger less frequently changing files
	datusr	abspath:	Data: User data; project/media files, bulk, dump, stash, mail, etc.

♦ cli:
	pwd			abspath of working directory
	xdir		execution directory
	xfile		execution file name

♦ http:			(for the next 4 see: src/phph/xu/lib/ht/rq/navigation.php)
	svroot		abspath: docroot directory of server
	svdir		abspath: served subdir; docroot of server + possible subdir;
						could be same as svroot
	svurl		absurlpath: like svdir, but on top of docroot-url;
						if present, starts with '/' but never ends with '/'.
						if empty, app is served from docroot-url/svroot
	navurl		relurlpath: $svurl.$navurl to get the complete http urlpath;
						Any UMR navurl is virtual and passed as is to index.php
						by mod_rewrite.
						Always starts and ends with '/', and is at least '/';
						end with '/' is enforced by function endslash().
	rtaurl		absurlpath: to link that puts Unisrc/rta/ online
	asturl		absurlpath:	rtaurl.'ast/' ~> rta/urt/ast/ -> urt/ast/www/
	js_url		absurlpath:	rtaurl.'js_/' ~> rta/urt/js_/ -> urt/src/js_/
	jsburl		absurlpath:	rtaurl.'jsb/' ~> rta/urt/jsb/ -> urt/src/jsb/
*/
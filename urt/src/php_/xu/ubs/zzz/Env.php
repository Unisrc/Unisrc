<?php
namespace Unisrc\xu\ubs\zzz;

use Unisrc\xu\lib\env as libenv;
use Unisrc\xu\lib\cls\dntons;

//src/phph/*
use Unisrc\xu\lib\ht\rq\navigation;
use Unisrc\xu\lib\ht\rq\endslash;
use Unisrc\xu\lib\ht\rq\nodes;

/*
DESCR:
	Env::init($application=null, $arguments=null, $rtaurl='')

	THE assigned way to initialize Unisrc Enviroment and startup an application.

	It ensures a simple but consistent enviroment for all building blocks
	to run in.

	Env::init() creates and setup the $Env object that holds all standard
	environment variables. 
	Function "src/php_/xu/lib/env::_($key)" is init	with $Env, so all env vars
	are available system wide on a var per call read only basis. The ones that
	start with '_' will not be returned and so are private.
	The application that is launched will own $Env and is able to add its own
	specific vars to it, that are immediately reflected inside env::_().

PARAMS:
	$application
		null
			No app is booted.
			In effect only the enviroment variables and the Unisrc class loader
			are set.

		string
			Dot notated static method name that represents the entry point of
			the application. Start with the devns, end with class name and
			method, like so: 'tld.sld.path.to.AppClass::init'

	$arguments	(handled if $application)
		null		default
			no arguments for app
		string | number
			single simple type argument
		array
			application arguments

	$rtaurl			Run Time Assets
		Only for HTTP applications; not considered in CLI mode.

		Local absolute URL path, to the symbolic link that puts directory
		'/abs/path/to/Unisrc/rta' online, which is a dir with a
		collection of symbolic links to dirs into Unisrc/*
		which need to be served over http to feed the client side of
		applications.

		''
			Use system defaults: '/{svurl}/@/'.
			Default for serving any application including  Unisrc Server (UBS).

		'/absolute/urlpath/'
			Note: start with a '/'.
			Absolute from server root URL '/'.

			Use this to borrow/tap the rtaurl of UBS from any other
			application its {svurl}.
NOTES:
+++ This file is behind the zzz private fence and so is not to be included
directly from outside domain xu.*; instead use scripts:
	"udt/(epc|eph)/xu/ubs/*.php".
For using the variables setup in this class use: "src/php_/xu/lib/env.php"
*/
class Env {

	public static function init($UNISRC, $application='', $arguments='', $rtaurl=''){

		$Env = (object)[];

		$Env->mts = $mts = microtime(true);
		$Env->uts = (int)$mts;
		$Env->cli = $CLI = (php_sapi_name() == 'cli');
		$Env->lcd = 'en';

		$Env->unisrc = $UNISRC;
		$Env->rttree = $rttree = $UNISRC.'urt/';

		$Env->astsys = $rttree.'ast/sys/';
		$Env->astwww = $rttree.'ast/www/';
		$Env->cfgdir = $rttree.'cfg/';
		$Env->srcdir = $srcdir = $rttree.'src/';
		$Env->js_dir = $srcdir.'js_/';
		$Env->jsbdir = $srcdir.'jsb/';
		$Env->php_dir = $php_dir = $srcdir.'php_/';
		$Env->phpcdir = $phpcdir = $srcdir.'phpc/';
		$Env->phphdir = $phphdir = $srcdir.'phph/';

		$Env->stctxa = '';
		$Env->stctxu = '';

		$Env->unidat = $unidat = $UNISRC.'dat/';
		$Env->datetc = $unidat.'etc/';
		$Env->datmfs = $unidat.'mfs/';
		$Env->datvar = $unidat.'var/';
		$Env->datusr = $unidat.'usr/';

	//---

		$phpxdir = ($CLI) ? $phpcdir : $phphdir;

		$classLoader = function($nsClass) use ($phpxdir, $php_dir){

			$rpClass = str_replace('\\', '/', substr($nsClass, 7)).'.php';

			if(file_exists($ffnClass = $phpxdir.$rpClass)){

				include($ffnClass);

			}else if(file_exists($ffnClass = $php_dir.$rpClass)){

				include($ffnClass);
			}
		};

		spl_autoload_register($classLoader);

	//---

		libenv::_($Env);

		if($CLI){

			$Env->pwd = $_SERVER['PWD'].'/';
			$Env->xdir = dirname($sn = $_SERVER['SCRIPT_NAME']).'/';
			$Env->xfile = basename($sn);

		}else{//HTTP

			list($Env->svroot, $Env->svdir, $Env->svurl, $Env->navurl) = navigation::_();

			endslash::_($Env->svurl, $Env->navurl);

			if(!$rtaurl) $rtaurl = $Env->svurl.'/@/';

			$Env->rtaurl = $rtaurl;
			$Env->asturl = $rtaurl.'ast/';
			$Env->js_url = $rtaurl.'js_/';
			$Env->jsburl = $rtaurl.'jsb/';
		}

		if($application){

			$nsClassMethod = dntons::_($application);
			$nsClassMethod($Env, $arguments);
		}

		return $Env;
	}
}

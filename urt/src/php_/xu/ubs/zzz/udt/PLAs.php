<?php
namespace Unisrc\xu\ubs\zzz\udt;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\arr\zb\tbl\values;

/*
DESCR:
	PLA means Programming Language Abbreviation / PLatform.

	The initial PLAs in Unisrc are:
	"js_", "jsb", "jsc", "php_", "phpc" and "phph"
	which covers the PLAs Unisrc is implemented in.

	PLAs are used as directory components in "unisrc/urt/src/*".
	e.g.:
		"unisrc/src/jsb" for browser DOM JavaScript code
		"unisrc/src/phph" for HTTPd PHP code

	...to distinguish source code on language and within that on other
	targets and purposes.

*/
class PLAs {
	
	public static function keys(){

		static $keys;

		if($keys) return $keys;

		return $keys = values::_(self::table(), 0);
	}

	public static function table(){

		static $table;

		if($table) return $table;

		return $table = jsunLoad::_(env::_('astwww').'xu/ubs/zzz/udt/PLAs.jsun');
	}
}

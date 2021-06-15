<?php
namespace Unisrc\xu\ubs\zzz\udt;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\enc\jsunLoad;

/*
DESCR:
	Read interface to file:
		urt/ast/www/xu/ubs/zzz/udt/possiblePaths.jsun

	It contains a list of all UBS UDT's possible entries.

RETURNS:
	return value of jsunLoad;
	boolean false
		failure
	mixed
		1D zb array (list)

NOTES:

*/
class possiblePaths {

	public static function _(){

		$unisrc = env::_('unisrc');
		$ffn = $unisrc.'urt/ast/www/xu/ubs/zzz/udt/possiblePaths.jsun';

		return jsunLoad::_($ffn);
	}
}

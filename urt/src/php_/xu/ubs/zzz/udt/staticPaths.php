<?php
namespace Unisrc\xu\ubs\zzz\udt;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\enc\jsunLoad;

/*
DESCR:
	Read interface to file:
		urt/ast/www/xu/ubs/zzz/udt/staticPaths.jsun

	It contains a list of all UBS UDT's static entries.

RETURNS:
	return value of jsunLoad;
	boolean false
		failure
	mixed
		1D zb array (list)

NOTES:

*/
class staticPaths {

	public static function _(){

		$unisrc = env::_('unisrc');
		$ffn = $unisrc.'urt/ast/www/xu/ubs/zzz/udt/staticPaths.jsun';

		return jsunLoad::_($ffn);
	}
}

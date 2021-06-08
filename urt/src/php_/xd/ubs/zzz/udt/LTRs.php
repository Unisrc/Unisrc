<?php
namespace Unisrc\xd\ubs\zzz\udt;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\arr\zb\tbl\values;


/*
DESCR:
	LTRs == LaTeraL Sources 

	### Public Sources ###
	The bulk of the sources inside Unisrc Base Server is generic and meant to
	run in public centralized space. Paths will have the following pattern:

		UDT_static_node/dev_TLD/dev_SLD/cat/repo/*

	These sources are allowed/meant to be accessed by other domains.


	### LaTeraL Sources ###
	An LTR path component is used early in the UDT path like this:

		UDT_static_node/LTR/dev_TLD/dev_SLD/cat/repo/*

	LTRs allows the developer to classify various types of sources that come
	with a repository, but does not belong in the UBS public source tree.
	Examples are demos, tests, setup, install and remote sources.

*/
class LTRs {
	
	public static function keys(){

		static $keys;

		if($keys) return $keys;

		return $keys = values::_(self::table(), 0);
	}

	public static function table(){

		static $table;

		if($table) return $table;

		return $table = jsunLoad::_(env::_('astwww').'xd/ubs/zzz/udt/LTRs.jsun');
	}
}

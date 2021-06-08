<?php
namespace Unisrc\xu\lib\i18n;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\arr\zb\tbl\values;

/*
DESCR:
	Language Code Definitions.

	Represents 184, iso639-1, 2 character language codes.

	These language codes will be used:
	● To distinguish languages in Unisrc documentation, source code logs and
	  feedback, and gui and config texts.
	● As a source for language selection GUI components.

NOTES:
• https://www.loc.gov/standards/iso639-2/php/code_list.php
• https://github.com/unicode-cldr/cldr-localenames-full

*/
class LCDs {

	public static function keys(){

		static $keys;

		if($keys) return $keys;

		return $keys = values::_(self::table(), 0);
	}

	public static function table(){

		static $table;

		if($table) return $table;

		return $table = jsunLoad::_(env::_('astwww').'xu/lib/zzz/i18n/LCDs.jsun');
	}
}

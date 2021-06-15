<?php
namespace Unisrc\xu\lib\str;

use Unisrc\xu\lib\str\contains;

/*
DESCR:
	String flags scans a flags field for optional flags,
	and returns a boolean for each of those options.

PARAM:
	$field		string
		The string to investigate.

	$options	string
		The string containing the flags to look for in $string.
	
	$sep		string
		Separator used in $options.
		If none is given, options is considered to be
		a string of flag chars and is split in chars.

RETURNS:
	zb array with booleans
		Having same length and order of $options,
		telling wether the flag was set or not.

NOTES:
• 
*/
class flags {

	public static function _($field, $options, $sep='|'){
		
		$bools = [];

		$options = ($sep) ? explode($sep, $options) : str_split($options);
		foreach($options as $opt)
			$bools[] = contains::_($field, $opt);
		
		return $bools;
	}
}

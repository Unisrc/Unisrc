<?php
namespace Unisrc\xu\lib\str;

use Unisrc\xu\lib\str\contains;

/*
DESCR:
	String flags scans a flags field for optional flags,
	and returns a boolean for each of those options.

PARAM:
	$field		string; '|' separated.
		The string to investigate.

	$options	string; '|' separated.
		The string containing the flags to look for in $string.

RETURNS:
	zb array with booleans
		Having same length and order of $options,
		telling wether the flag was set or not.

NOTES:
• 
*/
class flags {

	public static function _($field, $options){
		
		$bools = [];

		$options = explode('|', $options);
		foreach($options as $opt)
			$bools[] = contains::_($field, $opt);
		
		return $bools;
	}
}

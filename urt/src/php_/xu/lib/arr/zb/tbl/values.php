<?php
namespace Unisrc\xu\lib\arr\zb\tbl;

/*
DESCR:
	Collects the values of a table column in a list.

PARAM:
	$table
		The subject table.

	$ci
		The table column which values are to be collected.

RETURNS:
	list
		that is a single dimensional array.
*/
class values {

	public static function _($table, $ci){

		$values = [];

		foreach($table as $row)
			$values[] = $row[$ci];

		return $values;
	}
}

<?php
namespace Unisrc\xu\lib\arr\zb\tbl;

/*
DESCR:
	Creates a (associative) lookup table from a given zero based 2D table, so
	records in that 2D table can be indexed on a particular unique distinct
	column value.

	This is kind-a-line creating and index for database tables; it enables fast
	searches on the index column(s) that would otherwise be slow to search on;
	that is a brute force top down linear search.

PARAM:
	$table
		The subject table.

	$ci
		The table column which values are to become keys in the lookup table.

RETURNS:
	An associative lookup table.

NOTES:
• assert: $ci column values are unique in the table.
*/
class toLookup {

	public static function _($table, $ci=0){

		$lookup = [];

		foreach($table as $row){

			$key = $row[$ci];

			$lookup[$key] = $row;
		}

		return $lookup;
	}
}

<?php
namespace Unisrc\xu\lib\arr\zb\tbl;

/*
DESCR:
	Select a row set by column value.

PARAM:
	$tbl		table
		The table to select from.

	$ci			integer
		The column index to search for a value.

	$value		string|numeric
		The value that is considered a match.

RETURNS:
	table
		● A subset of $tbl.
		● Empty if $value was not found in $ci.

NOTES:

*/
class select {

	public static function _($tbl, $ci, $value){

		$rows = [];

		foreach($tbl as $row)
			if($row[$ci] == $value)
				$rows[] = $row;

		return $rows;
	}
}

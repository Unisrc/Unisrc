<?php
namespace Unisrc\xu\lib\arr\zb\tbl;

/*
DESCR:
	Sort a table on a particular column.

PARAM:
	$tbl		table
		The table to sort.

	$ci			integer
		The column index to sort on.

	$nors		boolean
		Nummeric or String
		Specify the basic type of $ci in order to sort the right way.
		true	Numeric
		false	String

	$aord		boolean
		Ascending or Descending
		true	Ascending
		false	Descending

RETURNS:
	null

NOTES:

*/
class sort {

	public static function _(&$tbl, $ci, $nors, $aord){
	
		// First select appropriate sort function.
	
		if($nors){//numeric
			if($aord){//ascending
				$fnc = function ($rA, $rB) use($ci){
					if($rA[$ci] == $rB[$ci]) return 0;
					return ($rA[$ci] < $rB[$ci]) ? -1 : 1;
				};
			}else{//descending
				$fnc = function ($rA, $rB) use($ci){
					if($rA[$ci] == $rB[$ci]) return 0;
					return ($rB[$ci] < $rA[$ci]) ? -1 : 1;
				};
			}
		}else{//string
			if($aord){//ascending
				$fnc = function ($rA, $rB) use($ci){
					if($rA[$ci] == $rB[$ci]) return 0;
					return strcmp($rA[$ci], $rB[$ci]);
				};
			}else{//descending
				$fnc = function ($rA, $rB) use($ci){
					if($rA[$ci] == $rB[$ci]) return 0;
					return strcmp($rB[$ci], $rA[$ci]);
				};
			}
		}

		usort($tbl, $fnc);
	}
}

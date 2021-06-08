<?php
namespace Unisrc\xu\lib\arr\trtb;

use Unisrc\xu\lib\arr\zb\tbl\select;
use Unisrc\xu\lib\arr\zb\tbl\sort;
/*
DESCR:
	Traverse Outward

	Recursively passes each node by callback,
	followed by getting into that node.

PARAM:
	$ttbl			treetable
		The tree table created by ttbl

	$callback		callable
		The function on the caller's side
		that is to receive each row in the tree.

RETURNS:
	null

NOTES:

*/
class trtbTout {

	const CI_ID = 0;
	const CI_PID = 1;
	const CI_IDX = 2;

	public static function _($ttbl, $callback){
		
		self::tt($ttbl['data'], $callback);
	}

// / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / /  P R I V A T E
	private static function tt($ttbl, $callback, $pid=0, $z=0){

		if($rows = select::_($ttbl, self::CI_PID, $pid)){

			sort::_($rows, self::CI_IDX, true, true);

			foreach($rows as $row){

				list($id, $pid, $idx) = $row;

				$callback($id, $pid, $idx, $z, array_slice($row, 3));

				self::tt($ttbl, $callback, $id, $z + 1);
			}
		}
	}
}

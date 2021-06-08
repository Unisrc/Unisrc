<?php
namespace Unisrc\xu\lib\arr\trtb;

/*
DESCR:
	Create a new tree table.

PARAM:
	$name		string
		The name or title of the tree table.

	$cols		list of strings
		The column names for the tree table.
		The first three will always be 'id', 'pid' and 'idx',
		while the remainder is for app side of any length.
		e.g: [  'id', 'pid', 'idx', 'as1', 'as2', 'as3', ... ]

RETURNS:
	A tree table.

NOTES:

*/
class trtbCreate {

	public static function _($name, $cols){

		return [
			'name'=>$name,
			'cols'=>$cols,
			'idc'=>1,
			'data'=>[
			]
		];
	}
}

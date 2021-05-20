<?php
namespace Unisrc\xu\lib\ht\rq;

use Unisrc\xu\lib\ht\rq\navigation;


/*
DESCR:
	Selects adjacent nodes from current navigation url path.

	PARAMS:
	offset
		zero based node number in navurl to start with.

	$trsl
		trim slashes
			INT	TRIM
			-1	left
			0	none; default
			1	right
			2	both

	length
		maximum number of nodes to return.

RETURNS:
	Root node
		(!$trsl) ? '/' : ''

	Path
		'/n0/n1/n.../'
			One or more adjacent nodes,
			depending on available and or requested length
			See $trsl also.

NOTES:
• return value always starts and ends with '/', or is a single '/'.
*/
class nodes {

	public static function _($offset, $trsl=0, $length=1){

		static $nodes;

		if(!$nodes){
			list(,,,$navurl) = navigation::_();
			$nodes = ($v = trim($navurl, '/')) ? explode('/', $v) : [];
		}

		if($array = array_slice($nodes, $offset, $length)){

			$path = join('/', $array);

			switch($trsl){
			case -1: return $path.'/';
			case 0: return '/'.$path.'/';
			case 1: return '/'.$path;
			case 2: return $path;
			}
		}

		return (!$trsl) ? '/' : '';
	}
}

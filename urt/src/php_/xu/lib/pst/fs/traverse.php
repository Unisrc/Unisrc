<?php
namespace Unisrc\xu\lib\pst\fs;

use Unisrc\xu\lib\pst\fs\dirs;
use Unisrc\xu\lib\pst\fs\files;


/*
DESCR:
	Traverses a directory tree, passing dir names and optionally files names
	to the caller.

PARAMS:
		$dir
			Top of the directory tree to traverse.
			Will not be returned in the results.
		$preott
			true		Pre Order Tree Traversal
				Display purposes.
				Inner leaves are passed immediately as soon as cursor arrives.
				Exactly in the order of how a dirtree should be displayed.
			false		Post Order Tree Traversal
				Removal purposes.
				Outer leaf files and dirs are passed first,
				going inward to the root of the tree.
				Exactly in the order of how a dirtree should be removed.
		$fnstoo
			true
				Also pass file names on every node
			false
				Only pass subdirs names
		$callback
			function($node, $fn, $isd, $z){
				$node		full path or node; always ends with /
				$fn			current file or dir name at node; never ends with /
				$isd		$fn is a directory
				$z			depth of node in the tree (0...n)
			}

		$precheck
			$ret
				-1	terminate traversal
				0	continue
				1	skip current node


		$sub	Don't touch!
		$z		Don't touch!

RETURNS:
	integer
		A traversal control integer; not important for the caller.

NOTES:
•
*/
class traverse {

	public static function _($dir, $preott, $fnstoo, $callback, $precheck=null, $sub='', $z=0){

		$node = $dir.$sub;

		$dns = dirs::_($node);

		if($preott){

			foreach($dns as $dn){

				$i = ($precheck) ? $precheck($node, $dn, $z) : 0;

				if($i >= 0){

					if(!$i){

						$callback($node, $dn, true, $z);

						$i = traverse::_($dir, $preott, $fnstoo, $callback, $precheck, $sub.$dn.'/', $z + 1);

						if($i < 0) return $i;

					}//else skipped

					continue;
				}

				return $i;
			}

		}else{

			foreach($dns as $dn){

				$i = ($precheck) ? $precheck($node, $dn, $z) : 0;

				if($i >= 0){

					if(!$i){

						$i = traverse::_($dir, $preott, $fnstoo, $callback, $precheck, $sub.$dn.'/', $z + 1);

						if($i < 0) return $i;

						$callback($node, $dn, true, $z);
					}

					continue;
				}
				
				return $i; 
			}
		}

		if($fnstoo){

			$fns = files::_($node);

			foreach($fns as $fn){

				$callback($node, $fn, false, $z);
			}
		}
	}
}

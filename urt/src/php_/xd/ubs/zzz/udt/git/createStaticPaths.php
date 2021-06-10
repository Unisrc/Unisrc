<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\fs\path;
use Unisrc\xd\ubs\zzz\udt\Nodes;

/*
DESCR:
	Create UBS static paths as fundaments of UDT.
*/
class createStaticPaths {
	
	public static function _($doit, $listfunc){

		$unisrc = env::_('unisrc');
		$paths = Nodes::staticPaths();
		$fb = [];

		foreach($paths as $path){

			$relpath = $path.'/';
			$abspath = $unisrc.$relpath;

			if(!file_exists($abspath)){
				if($doit)
					path::_($abspath);
				$fb[] = $relpath;
			}
		}

		return $listfunc($fb);
	}
}

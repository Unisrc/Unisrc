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
		$paths = Nodes::staticPaths(true);
		$list = [];

		foreach($paths as $path){
			if(!file_exists($fdn = $unisrc.$path.'/')){
				if($doit)
					path::_($fdn);
				$list[] = $fdn;
			}
		}

		return $listfunc($list);
	}
}

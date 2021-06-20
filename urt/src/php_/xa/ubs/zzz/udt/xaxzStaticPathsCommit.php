<?php
namespace Unisrc\xa\ubs\zzz\udt;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\txt\Fb;
use Unisrc\xu\lib\pst\fs\path;
use Unisrc\xu\ubs\zzz\udt\staticPaths;



/*
DESCR:
	Create UBS static paths as fundaments of UDT.

PARAM:
	$doit		booleand
		true
			do create dirs

		false
			dry run

RETURNS:
	array
		A list of created dirs

NOTES:
• Logical order of actions: 
	+ Edit one of these:
		table: urt/ast/www/xa/ubs/zzz/udt/Nodes.jsun
		table: urt/ast/www/xa/ubs/zzz/udt/PLA.jsun
	$ git checkout -b 'NEW_ubsdir-dn'
	$ xaxzact execute udt.xaxzStaticPathsExport
	$ xaxzact execute udt.possiblePaths
	$ xaxzact execute udt.xaxzStaticPathsCommit		<-- Uses this function.
	$ gpmlcf
	+ Merge and push 'NEW_ubsdir-dn'
*/
class xaxzStaticPathsCommit {
	
	public static function _($doit){

		$unisrc = env::_('unisrc');
		$paths = staticPaths::_();
		$list = [];

		foreach($paths as $path){

			$relpath = $path.'/';
			$abspath = $unisrc.$relpath;

			if(!file_exists($abspath)){
				if($doit)
					path::_($abspath);
				$list[] = $relpath;
			}
		}

		$MODE = ($doit) ? 'DO-IT!' : 'DRY-RUN';
		$list = ($c = count($list)) ? ($c."\n".join("\n", $list)) : '0';

		Fb::message(__CLASS__, 'report', [
			$MODE, $list
		]);
	}
}

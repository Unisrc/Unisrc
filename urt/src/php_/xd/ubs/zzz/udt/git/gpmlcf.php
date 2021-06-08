<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\txt\Fb;

use Unisrc\xd\ubs\zzz\udt\git\createIgnoreFile;
use Unisrc\xd\ubs\zzz\udt\git\createStaticPaths;
use Unisrc\xd\ubs\zzz\udt\git\createDirPersistFiles;

/*
DESCR:
	Git Pre Merge Last Commit Files

PARAM:
	$doit		boolean
		true
			do-it! mode; execute all

		false	(default)
			run-dry mode; execute none;
			show what would happen

	$rmdp		boolean
		true
			set $doit false
			remove all DPFs files
		false	(default)
			do nothing
RETURNS:
	null

NOTES:
 
*/
class gpmlcf {

	public static function _($doit=false, $rmdp=false){

		if($rmdp){ $doit=false; }

		$MODE = ($doit) ? 'DO-IT!' : (($rmdp) ? 'RM-DP' : 'DRY-RUN');

		$listfunc = function($list){
			return ($c = count($list)) ? ($c."\n".join("\n", $list)) : '0';
		};

		$dpfn = createDirPersistFiles::FN;

		$gi_created = createIgnoreFile::_($doit, $dpfn);
		$sp_created = createStaticPaths::_($doit, $listfunc);
		$dp_actions = createDirPersistFiles::_($doit, $listfunc, $rmdp);

		list($dp_created, $dp_removed) = $dp_actions;

		Fb::message(__CLASS__, 'report', [
			$MODE,
			$gi_created, $sp_created,
			$dp_created, $dp_removed
		]);
	}
}

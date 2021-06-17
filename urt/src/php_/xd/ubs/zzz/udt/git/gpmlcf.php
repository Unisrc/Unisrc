<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\txt\Fb;

use Unisrc\xd\ubs\zzz\udt\git\createIgnoreFile;
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

RETURNS:
	null

NOTES:
 
*/
class gpmlcf {

	public static function _($doit){

		$MODE = ($doit) ? 'DO-IT!' : 'DRY-RUN';

		$dpfn = createDirPersistFiles::FN;

		$gi_created = createIgnoreFile::_($doit, $dpfn);
		$dp_actions = createDirPersistFiles::_($doit);

		list($dp_created, $dp_removed) = $dp_actions;

		Fb::message(__CLASS__, 'report', [
			$MODE,
			$gi_created,
			$dp_created, $dp_removed
		]);
	}
}

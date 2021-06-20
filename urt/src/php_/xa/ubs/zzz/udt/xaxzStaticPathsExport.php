<?php
namespace Unisrc\xa\ubs\zzz\udt;

use Unisrc\xu\lib\arr\trtb\trtbTout;
use Unisrc\xu\lib\str\contains;

use Unisrc\xu\ubs\zzz\udt\PLAs;
use Unisrc\xa\ubs\zzz\udt\Nodes;

use Unisrc\xa\lib\pst\xaxz\exportJsun;

/*
DESCR:
	Reads the UDT nodes tree table and
	generates and exports 'staticPaths' list
	to 'xu' domain.

PARAM:
	$doit		boolean
		Operation mode
		false	DRY-RUN
		true	DO-IT

RETURNS:
	null

NOTES:
*/
class xaxzStaticPathsExport {

	public static function _($doit){

		$relpath = 'urt/ast/www/xu/ubs/zzz/udt/';
		$fn = 'staticPaths.jsun';
		$dnReader = 'xu.ubs.zzz.udt.staticPaths::_';

		//Generate static paths from Nodes tree table.
		$paths=[];
		$stack=[];

		$PLAs = PLAs::keys();
		

		$trtb = Nodes::treetable();

		$callback = function($id, $pid, $idx, $z, $udata)
					use(&$paths, &$stack, $PLAs){

			list($node, $flags, $description) = $udata;

			$stack[$z] = $node;

			$path = join('/', array_slice($stack, 0, $z + 1));
		
			$paths[] = $path;

			if($PLAs && contains::_($flags, 'PLA')){
				foreach($PLAs as $pla)
					$paths[] = $path.'/'.$pla;
			}
		};

		trtbTout::_($trtb, $callback);

		//Format into JSUN content
		$content = "[\n\t\"".join("\",\n\t\"", $paths)."\"\n]";

		//Export JSUN content
		exportJsun::_($relpath, $fn, $content, $dnReader, $doit);
	}
}

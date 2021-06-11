<?php
namespace Unisrc\xa\ubs\zzz\udt;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\txt\Fb;

use Unisrc\xu\lib\pst\fs\path;
use Unisrc\xu\lib\pst\enc\jsunSave;
use Unisrc\xu\ubs\zzz\udt\staticPaths;

use Unisrc\xd\ubs\zzz\udt\Nodes;
/*
DESCR:
	Create Static Path List, at:

		urt/ast/www/xu/ubs/zzz/udt/staticPaths.jsun

	to be picked up by:

		urt/src/php_/xu/ubs/zzz/udt/staticPaths.php

	as read interface and entry point
	inside user domain 'xu-ubs'.

PARAM:
	$doit		booleand
		true
			execute
		false
			run dry

RETURNS:
	null

NOTES:
*/
class xacsplxu {

	public static function _($doit){

		//Addressing
		$unisrc = env::_('unisrc');
		$relpath = 'urt/ast/www/xu/ubs/zzz/udt/';
		$abspath = $unisrc.$relpath;
		$fn = 'staticPaths.jsun';
		$ffn = $abspath.$fn;

		//Feedback collect
		$fb = [
			'fd'=>'', 'di'=>'',
			'pc'=>'false', 'fx'=>'false', 'fc'=>'false'
		];

		//Create JSUN file data
		$staticPaths = Nodes::staticPaths(true);
		$lines = join("/\",\n\t\"", $staticPaths);
		$jsun = <<< EOT
		/*
		!!! DO NOT MODIFY !!!
		This file is generated at architecture level (xa).
		*/
		[
			"$lines"
		]

		EOT;

		$fb['fd'] = "\n".$jsun;
		$fb['di'] = 'generated';

		//Ensure path
		if(!file_exists($abspath)){
			if($doit){
				path::_($abspath);
			}
			$fb['pc'] = 'true';
		}

		//Ensure file
		$exists = false;
		$create = false;
		if(file_exists($ffn)){
			$exists = true;
			$fb['fx'] = 'true';
			$data = file_get_contents($ffn);
			if($jsun != $data){
				$create = true;
				$fb['fc'] = 'true';
			}
		}else{
			$create = true;
			$fb['fc'] = 'true';
		}

		if($create){
			if($doit){
				file_put_contents($ffn, $jsun);
				$exists = true;
			}
		}

		if($exists){
			if(($SPs = staticPaths::_()) && is_array($SPs)){
				$fb['fd'] = "\n".file_get_contents($ffn);;
				$fb['di'] = 'read file';
			}
		}

		$MODE = ($doit) ? 'DO-IT!' : 'DRY-RUN';

		Fb::message(__CLASS__, 'report', [
			$fb['fd'], $fb['di'], $MODE,
			$fb['pc'], $fb['fx'], $fb['fc']
		]);
	}
}

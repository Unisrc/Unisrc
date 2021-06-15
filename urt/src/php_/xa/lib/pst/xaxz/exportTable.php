<?php
namespace Unisrc\xa\lib\pst\xaxz;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\txt\Fb;
use Unisrc\xu\lib\cls\dntons;
use Unisrc\xu\lib\pst\fs\path;
/*
DESCR:
	Generate and store a table,
	outside 'xa' domain,
	inside 'xb...xz' damain.

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
class exportTable {

	public static function _($relpath, $fn, $dnGenerator, $dnReader, $doit){

		//Addressing
		$unisrc = env::_('unisrc');
		$abspath = $unisrc.$relpath;
		$ffn = $abspath.$fn;

		//Feedback collect
		$fb = [
			//file data, data is
			'fd'=>'', 'di'=>'',
			//path create, file exists, file create
			'pc'=>'false', 'fx'=>'false', 'fc'=>'false'
		];

		//Create JSUN file data
		$nsGenerator = dntons::_($dnGenerator);
		$table = $nsGenerator();
		$lines = join("/\",\n\t\"", $table);
		$jsun = <<< EOT
		/*
		!!! DO NOT MODIFY !!!
		This file is generated at architecture level (xa).
		*/
		[
			"$lines"
		]

		EOT;

		$fb['fd'] = $jsun;
		$fb['di'] = 'generated but not written yet';

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
			$_jsun = file_get_contents($ffn);
			if($jsun != $_jsun){
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
			//Read table back to know job is complete
			$nsReader = dntons::_($dnReader);
			if(($table = $nsReader()) && is_array($table)){
				$fb['fd'] = $_jsun = file_get_contents($ffn);
				$result = ($jsun == $_jsun) ? 'OK' : 'FAILURE';
				$fb['di'] = "readback with integrity check: [ $result ]";
				
			}
		}

		$MODE = ($doit) ? 'DO-IT!' : 'DRY-RUN';

		Fb::message(__CLASS__, 'report', [
			"\n".$fb['fd'], $MODE, $fb['di'],
			$fb['pc'], $fb['fx'], $fb['fc'],
			$relpath.$fn
		]);
	}
}

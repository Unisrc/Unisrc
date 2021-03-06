<?php
namespace Unisrc\xa\lib\pst\xaxz;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\txt\Fb;
use Unisrc\xu\lib\cls\dntons;
use Unisrc\xu\lib\pst\fs\path;
/*
DESCR:
	Generate and store JSUN,


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
class exportJsun {

	public static function _($relpath, $fn, $content, $dnReader, $doit){

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

		//Complete JSUN file data
		$jsun = <<< EOT
		/*
		!!! DO NOT MODIFY !!!
		This file is generated at architecture level (xa).
		*/
		$content

		EOT;

		$fb['fd'] = $jsun;
		$fb['di'] = 'Generated, but not written yet.';

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
				$result = ($jsun == $_jsun) ? 'YES' : 'NO';
				$fb['di'] = "Read back file. Is same?: [ $result ]";
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

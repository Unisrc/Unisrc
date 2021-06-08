<?php
namespace Unisrc\xd\ubs\zzz\udt;

use Unisrc\xu\lib\env;


use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\arr\trtb\trtbTout;
use Unisrc\xu\lib\str\flags;
use Unisrc\xu\lib\str\contains;

use Unisrc\xu\lib\i18n\LCDs;
use Unisrc\xd\ubs\zzz\udt\PLAs;
use Unisrc\xd\ubs\zzz\udt\LTRs;
use Unisrc\xd\ubs\zzz\udt\XNSs;

/*
DESCR:
	Read access to Unisrc Directory Tree definition.
*/
class Nodes {

	/*
	DESCR:
		The static defined tree of UDT.
	*/
	public static function staticPaths($bPLAs=false){

		static $paths=[];

		if($paths) return $paths;

		$PLAs = ($bPLAs) ? PLAs::keys() : false;
		
		$stack=[];

		$trtb = self::trtb();

		trtbTout::_($trtb, function($id, $pid, $idx, $z, $udata)
		use(&$paths, &$stack, $PLAs){

			list($node, $flags, $description) = $udata;

			$stack[$z] = $node;

			$path = join('/', array_slice($stack, 0, $z + 1));
		
			$paths[] = $path;

			if($PLAs && contains::_($flags, 'PLA')){
				foreach($PLAs as $pla)
					$paths[] = $path.'/'.$pla;
			}
		});

		return $paths;
	}

	/*
	DESCR:
		The potential possible UBS UDT containing it all.
	*/
	public static function possiblePaths(){

		static $paths=[];

		if($paths) return $paths;
		
		$stack=[];

		$LCDs = LCDs::keys();
		$PLAs = PLAs::keys();
		$LTRs = LTRs::keys();
		$XNSs = XNSs::keys('UBS');

		$trtb = self::trtb();

		$callback = function($id, $pid, $idx, $z, $udata)
					use(&$paths, &$stack, $LCDs, $PLAs, $LTRs, $XNSs){

			list($node, $flags, $description) = $udata;

			$stack[$z] = $node;

			$path = join('/', array_slice($stack, 0, $z + 1));

			$paths[] = $path;

			list($bLCD, $bPLA, $bLTR, $bXNS) = flags::_($flags, 'LCD|PLA|LTR|XNS');

			//auto include: XNSs.
			if($bLCD){

				foreach($LCDs as $lcd){
					$_path = $path.'/'.$lcd;
					$paths[] = $_path;
					foreach($XNSs as $xns){
						$paths[] = $_path.'/'.$xns;
					}
				}

			//auto include: LTRs, XNSs.
			}else if($bPLA){

				//On each PLA
				foreach($PLAs as $pla){
					$_path = $path.'/'.$pla;
					$paths[] = $_path;

					//add all XNSs
					foreach($XNSs as $xns){
						$paths[] = $_path.'/'.$xns;
					}

					//add all LTRs
					foreach($LTRs as $ltr){
						$__path = $_path.'/'.$ltr;
						$paths[] = $__path;

						//add again all XNSs on each LTR
						foreach($XNSs as $xns){
							$paths[] = $__path.'/'.$xns;
						}
					}
				}

			//auto include: XNSs.
			}else if($bLTR){

				foreach($XNSs as $xns){
					$paths[] = $path.'/'.$xns;
				}

				foreach($LTRs as $ltr){
					$_path = $path.'/'.$ltr;
					$paths[] = $_path;
					foreach($XNSs as $xns){
						$paths[] = $_path.'/'.$xns;
					}
				}

			//auto include: nothing.
			}else if($bXNS){

				foreach($XNSs as $xns){
					$paths[] = $path.'/'.$xns;
				}
			}
		};

		trtbTout::_($trtb, $callback);

		return $paths;
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	private static function trtb(){

		static $trtb;

		if($trtb) return $trtb;

		return $trtb = jsunLoad::_(env::_('astwww').'xd/ubs/zzz/udt/Nodes.jsun');
	}
}


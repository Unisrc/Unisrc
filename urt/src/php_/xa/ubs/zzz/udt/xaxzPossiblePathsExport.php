<?php
namespace Unisrc\xa\ubs\zzz\udt;

use Unisrc\xu\lib\str\flags;
use Unisrc\xu\lib\arr\trtb\trtbTout;

use Unisrc\xu\lib\i18n\LCDs;

use Unisrc\xu\ubs\zzz\udt\PLAs;
use Unisrc\xu\ubs\zzz\udt\LTRs;
use Unisrc\xu\ubs\zzz\udt\XNSs;

use Unisrc\xa\lib\pst\xaxz\exportJsun;

/*
DESCR:
	Reads the UDT nodes tree table and
	generates and exports 'possiblePaths' list
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
class xaxzPossiblePathsExport {

	public static function _($doit){

		$relpath = 'urt/ast/www/xu/ubs/zzz/udt/';
		$fn = 'possiblePaths.jsun';
		$dnReader = 'xu.ubs.zzz.udt.possiblePaths::_';

		//Generate possible paths from Nodes tree table.
		$paths=[];
		$stack=[];

		$LCDs = LCDs::keys();
		$PLAs = PLAs::keys();
		$LTRs = LTRs::keys();
		$XNSs = XNSs::keys('UBS');

		$trtb = Nodes::treetable();

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

		//Format into JSUN content
		$content = "[\n\t\"".join("\",\n\t\"", $paths)."\"\n]";

		//Export JSUN content
		exportJsun::_($relpath, $fn, $content, $dnReader, $doit);
	}
}

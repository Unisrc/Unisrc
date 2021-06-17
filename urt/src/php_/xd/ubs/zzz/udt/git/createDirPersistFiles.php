<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\fs\files;
use Unisrc\xu\lib\pst\fs\traverse;

use Unisrc\xu\ubs\zzz\udt\XNSs;
use Unisrc\xu\ubs\zzz\udt\staticPaths;
use Unisrc\xu\ubs\zzz\udt\possiblePaths;

class createDirPersistFiles {
	
	//The DPF file name.
	public const FN = '.udt';

	/*
	DESCR:
		Traverses the UBS UDT possible and existing paths,
		and manages DPFs.
	*/
	public static function _($doit){

		$fb = [ [], [] ];
		$unisrc = env::_('unisrc');
		$dpfn = self::FN;

		$ttcb_setDPF = self::ttcb_setDPF($doit, $unisrc, $dpfn, $fb);
		
		$XNSs = XNSs::keys('UBS');

		$staticPaths = staticPaths::_();
		$lookupStatic = array_fill_keys($staticPaths, 0);

		$possiblePaths = possiblePaths::_();
		foreach($possiblePaths as $path){

			$abspath = $unisrc.$path.'/';

			if(file_exists($abspath)){

				$bStatic = isset($lookupStatic[$path]);

				$ttcb_setDPF($abspath, '', $bStatic, -1);

				foreach($XNSs as $xns){
					if(preg_match("/$xns$/", $path)){
						traverse::_($abspath, true, false, $ttcb_setDPF);
					}
				}
			}
		}

		$listfunc = function($list){
			return ($c = count($list)) ? ($c."\n".join("\n", $list)) : '0';
		};

		$created = $listfunc($fb[0]);
		$removed = $listfunc($fb[1]);

		return [ $created, $removed ];
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	/*
	DESCR:
		Returns an anonymous function for tree traversal.
		It focusses on current node + dn to see if a DPF
		needs creation or removal.
	*/
	private static function ttcb_setDPF($doit, $unisrc, $dpfn, &$fb){

		return function($node, $dn, $isd, $z) use($doit, $unisrc, $dpfn, &$fb){

			$bStatic = ($z == -1) ? $isd : false;

			$relpath = str_replace($unisrc, '', $node.(($dn) ? $dn.'/' : ''));
			$abspath = $unisrc.$relpath;
			$absDPF = $abspath.$dpfn;
			$relDPF = $relpath.$dpfn;

			$exists = file_exists($absDPF);
			$length = count(files::_($abspath, null, true, 2));

			if(!$length || (!$exists && $bStatic)){

				if($doit){
					list($mcs, $uts) = explode(' ', microtime());
					$unique = date('YmdHis', $uts).substr($mcs, 1);
					file_put_contents($absDPF, $unique);
				}
				$fb[0][] = $relDPF;

			}else if($length > 1){

				if($exists && !$bStatic){
					if($doit)
						unlink($absDPF);
					$fb[1][] = $relDPF;
				}
			}
		};
	}
}

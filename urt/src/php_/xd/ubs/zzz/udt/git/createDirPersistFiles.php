<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\fs\files;
use Unisrc\xu\lib\pst\fs\traverse;

use Unisrc\xd\ubs\zzz\udt\XNSs;
use Unisrc\xd\ubs\zzz\udt\Nodes;

class createDirPersistFiles {
	
	//The DPF file name.
	public const FN = '.udt';

	/*
	DESCR:
		Traverses the UBS UDT possible and existing paths,
		and manages DPFs.
	*/
	public static function _($doit, $listfunc, $rm){

		$fb = [ [], [] ];
		$unisrc = env::_('unisrc');
		$dpfn = self::FN;

		$ttcb_setDPF = self::ttcb_setDPF($doit, $unisrc, $dpfn, $fb, $rm);
		$ttcb_setDPF($unisrc, '');
		
		$XNSs = XNSs::keys('UBS');
		$paths = Nodes::possiblePaths();
		foreach($paths as $path){

			$abspath = $unisrc.$path.'/';

			if(file_exists($abspath)){

				$ttcb_setDPF($abspath, '');

				foreach($XNSs as $xns){
					if(preg_match("/$xns$/", $path)){
						traverse::_($abspath, true, false, $ttcb_setDPF);
					}
				}
			}
		}

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
	private static function ttcb_setDPF($doit, $unisrc, $dpfn, &$fb, $rm){

		return function($node, $dn) use($doit, $unisrc, $dpfn, &$fb, $rm){

			$relpath = str_replace($unisrc, '', $node.(($dn) ? $dn.'/' : ''));
			$abspath = $unisrc.$relpath;
			$absDPF = $abspath.$dpfn;
			$relDPF = $relpath.$dpfn;

			$len = count(files::_($abspath, null, true, 2));

			if(!$rm){
				if(!$len){

					if($doit){
						list($mcs, $uts) = explode(' ', microtime());
						$unique = date('YmdHis', $uts).substr($mcs, 1);
						file_put_contents($absDPF, $unique);
					}
					$fb[0][] = $relDPF;

				}else if($len > 1){

					if(file_exists($absDPF)){
						if($doit)
							unlink($absDPF);
						$fb[1][] = $relDPF;
					}
				}
			}else{
				if(file_exists($absDPF)){
					unlink($absDPF);
					$fb[1][] = $relDPF;
				}
			}
		};
	}
}

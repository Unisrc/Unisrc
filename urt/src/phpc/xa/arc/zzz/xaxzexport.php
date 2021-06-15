<?php
namespace Unisrc\xa\arc\zzz;

use Unisrc\xu\lib\txt\Fb;
use Unisrc\xu\lib\cli\Args;
use Unisrc\xa\arc\zzz\_xaxzexport;

/*
DESCR:

	CLI interface to _xaxzexport;

		Domain 'xa' to 'xb...xz' resource export.

PARAM:
	none

RETURNS:
	null

NOTES:
*/
class xaxzexport {

	public static function _(){

		Fb::setGenericOutputHandler();

		$args = new Args();
		
		if(!$args->isfm('cm sv sv? fl?')){
			self::help();
			return;
		}

		switch($cmd = $args->sv(0)){
		
		case 'select':
			if(($id = $args->sv(1)) && self::isid($id)){
				$fms = "%15s: %s\n";
				printf($fms, 'id', $id);
				list($cns, $row) = _xaxzexport::_($cmd, $id);
				foreach($cns as $i => $cn)
					printf($fms, $cn, $row[$i]);
			}else{
				$ids = _xaxzexport::_($cmd);
				echo join("\n", $ids), "\n";
			}
		break;

		case 'make':
			if(($id = $args->sv(1)) && self::isid($id)){
				$doit = $args->fl('d');
				_xaxzexport::_($cmd, $id, $doit);
				if(!$doit) Fb::message(__CLASS__, 'doit');
			}else{
				self::help();
			}
		break;

		default:
		case 'help':
			self::help();
		break;
		}
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	private static function isid($id){
		
		$ids = _xaxzexport::_('select');
		return in_array($id, $ids);
	}

	private static function help(){

		Fb::message(__CLASS__, 'help');
	}
}

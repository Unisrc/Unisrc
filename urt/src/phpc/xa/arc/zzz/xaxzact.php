<?php
namespace Unisrc\xa\arc\zzz;

use Unisrc\xu\lib\txt\Fb;
use Unisrc\xu\lib\cli\Args;
use Unisrc\xa\arc\zzz\_xaxzact;

/*
DESCR:

	CLI interface to _xaxzact;

		Domain 'xa' -> 'xb...xz' actions.

PARAM:
	none

RETURNS:
	null

NOTES:
*/
class xaxzact {

	public static function _(){

		Fb::setGenericOutputHandler();

		$args = new Args();
		
		if(!$args->isfm('cm sv sv? fl?')){
			self::help();
			return;
		}

		switch($cmd = $args->sv(0)){
		
		case 'list':
			$actions = _xaxzact::_($cmd);
			foreach($actions as $index => $dnAction){
				printf("[%2u] %s\n", $index, $dnAction);
			}
		break;
		case 'execute':
			$index = $args->sv(1);
			if(($index !== false) && self::isindex((int)$index)){
				$doit = $args->fl('d');
				_xaxzact::_($cmd, $index, $doit);
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

	private static function isindex($index){
		
		$length = count(_xaxzact::_('list'));

		return !!((0 <= $index) && ($index < $length));
	}

	private static function help(){

		Fb::message(__CLASS__, 'help');
	}
}

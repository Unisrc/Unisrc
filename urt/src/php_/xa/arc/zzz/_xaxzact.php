<?php
namespace Unisrc\xa\arc\zzz;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\cls\dntons;
use Unisrc\xu\lib\pst\enc\jsunLoad;

/*
DESCR:
	Centralizes actions at 'xa' architecture level
	on any downstream 'xb...xz' level.

PARAM:
	$cmd		string
		'list'
			Returns the available actions list.

		'execute'
			Executes an action from the action list
			using $index.

	$index		integer
		An index in the actions list.

	$doit		boolean
		Operation mode

		false
				DRY-RUN
		true
				DO-IT

RETURNS:
	null

NOTES:
*/
class _xaxzact {

	public static function _($cmd, $index=-1, $doit=false){

		switch($cmd){
		case 'list':
			return self::actions();
		break;
		case 'execute':
			$dnAction = self::actions($index);
			$nsAction = dntons::_($dnAction);
			$nsAction($doit);
		break;
		}
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	private static function actions($index=-1){

		static $list;

		if(!$list){
			$ffn = env::_('astwww').'xa/arc/zzz/_xaxzact.jsun';
			$list = jsunLoad::_($ffn);
		}

		return ($index < 0) ? $list : $list[$index];
	}
}

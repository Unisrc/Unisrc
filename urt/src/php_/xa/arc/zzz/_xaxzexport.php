<?php
namespace Unisrc\xa\arc\zzz;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xa\lib\pst\xaxz\exportTable;

/*
DESCR:
	Exports resources maintained here in xa,
	to downstream xb...xz domains.

PARAM:
	$cmd		string
		'select'
			Selects ids or a record from the export table.
			Without $id, a list of all ids is returned.
			With $id, the record with that id is returned.
		'make'
			Creates a resource from the resource table,
			and stores it according to record inside one
			of xb...xz.
			Expects $id.

	$id			string
		A key to a record in the export table.

	$doit		boolean
		false		default
			Dry run; only shows what the result would be.
		true
			Perform the actions shown in dry run.

RETURNS:
	null

NOTES:
*/
class _xaxzexport {

	public static function _($cmd, $id='', $doit=false){

		switch($cmd){
		case 'select':
			if($id){
				$cns = [
					'target path', 'target basename',
					'type', 'generator', 'reader'
				];
				$row = self::table($id);
				return [ $cns, $row ];
			}else{
				return array_keys(self::table());
			}
		break;
		case 'make':
			$row = self::table($id);
			list($relpath, $fn, $type, $dnGenerator, $dnReader) = $row;

			switch($type){
			case 'table':
				exportTable::_($relpath, $fn, $dnGenerator, $dnReader, $doit);
			break;
			}
		break;
		}
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	private static function table($id=''){

		$ffn = env::_('astwww').'xa/arc/zzz/_xaxzexport.jsun';
		$table = jsunLoad::_($ffn);

		return (!$id) ? $table : $table[$id];
	}
}

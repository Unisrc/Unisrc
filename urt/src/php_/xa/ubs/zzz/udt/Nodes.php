<?php
namespace Unisrc\xa\ubs\zzz\udt;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\enc\jsunLoad;

/*
DESCR:
	UDT Nodes (Unisrc Directory Tree - Nodes)

	This is the tree table manager of tree table:

		"urt/ast/www/xa/ubs/zzz/udt/Nodes.jsun"

	It is decided here, and recordded in this tree table,

	what UDT looks like.
*/
class Nodes {

	/*
	DESCR:
		Load the tree table.
		Cache it locally
		Return it

	PARAM:
		none

	RETURNS:
		array, in trtb (treetable format)

	NOTES:
	*/
	public static function treetable(){

		static $trtb;

		if($trtb) return $trtb;

		return $trtb = jsunLoad::_(env::_('astwww').'xa/ubs/zzz/udt/Nodes.jsun');
	}
}


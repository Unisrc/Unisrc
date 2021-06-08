<?php
namespace Unisrc\xd\ubs\zzz\udt;

use Unisrc\xu\lib\env;

use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\arr\zb\tbl\values;
use Unisrc\xu\lib\str\flags;

/*
DESCR:
	Unisrc developers making UCRs (Unisrc Compliant Repositories), are expected
	to place it under their generic developer namespace (DEVNS) consisting of

		topleveldomain.secondleveldomain	(Java like namespaces)

	e.g.: com.devman, net.awesome, org.wizkids
	They should own or have owned this domain, to avoid collisions.


	Unisrc will claim the short and sweet xa...xz range of codes as namespace.

	https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Decoding_table
	Tells about XA-XZ range of "Country Codes" that these are:
	"User-assigned: free for assignment at the disposal of users ".

	This also implies that these will never be used for top level domains, and
	so these are truly free user space top level domains.

	So actually, within the scope of Unisrc, only using the TLD range xa...xz is
	sufficient for Unisrc to stay isolated from any generic developer domain.
	And because Unisrc is delivering the big infrastructure, it is kind of
	appropriate to claim these namespaces with its simpler addressing.

	XNSs represents the x[a-z] namespaces, that are currently taken for their
	purposes.
*/
class XNSs {
	
	/*
	DESCR:
		Get the keys, that is x[a-z] domains that are currently used/assigned.

	PARAM:
		$filter		string; '|' separated flags.
			UBS		Get Unisrc domains that are integral part of UBS.
			UCR		Get Unisrc domains that are used for external installable
					repositories.

	RETURNS:
		array
			keys	according to filter

	NOTES:
	*/
	public static function keys($filter){

		static $cache=[], $options = 'UBS|UCR';

		if(isset($cache[$filter])) return $cache[$filter];

		//---
		$bFilters = flags::_($filter, $options);

		$keys = [];
		$table = self::table();
		foreach($table as list($key, $flags)){

			$bCurrent = flags::_($flags, $options);

			foreach($bFilters as $i => $bF){
				if($bF && $bCurrent[$i]){
					$keys[] = $key;
					break;
				}
			}
		}

		return $cache[$filter] = $keys;
	}

	public static function table(){

		static $table;

		if($table) return $table;

		return $table = jsunLoad::_(env::_('astwww').'xd/ubs/zzz/udt/XNSs.jsun');
	}
}

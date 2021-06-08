<?php
namespace Unisrc\xu\lib\str;


class contains {

	public static function _($string, $search){

		return (strpos($string, $search) !== false);
	}
}

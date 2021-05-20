<?php
namespace Unisrc\xu\lib\cls;

/*
DESCR
	Converts a Class dot notation to namespace.
PARAM
	$dnClass	string; dot notated class.
		A file in the Unisrc tree, universal expressed in dot notation;
		starting with 'tld.sldomain' having '.' as path separators.
		e.g.:	'tld.sldomain.path.to.Class[::method]'
		
RETURNS
	e.g.: 'Unisrc\tld\sldomain\path\to\Class[::method]'.
NOTES
• assert: $dnClass is expressed in dot notation;
	starting with 'tld.dom' having '.' as path separators
*/
class dntons {

	public static function _($dnClass){

		return 'Unisrc\\'.str_replace('.', '\\', $dnClass);
	}
}

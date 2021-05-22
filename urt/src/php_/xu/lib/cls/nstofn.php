<?php
namespace Unisrc\xu\lib\cls;

/*
DESCR
    Class namespace to file system path.

PARAM
    $nsClass	string;
        Unisrc namespaced class with backslashes.

    $pfx
        optional prefix

    $sfx
        optional suffix
        
RETURNS
    e.g.: 'tld/sldomain/path/to/Class[::method]'.

NOTES
• 
*/
class nstofn {

    public static function _($nsClass, $pfx='', $sfx=''){

        return $pfx.str_replace('\\', '/', substr($nsClass, 7)).$sfx;
    }
}

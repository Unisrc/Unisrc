<?php
namespace Unisrc\xu\lib\str\c;

use Unisrc\xu\lib\rgx\sfQTS;

/*
DESC:
    Removes comments from c-style source text.

PARAMS:
    $source
        Text to scan and remove comments from.

RETURNS:

NOTES:
*/
class rmcmnts {

    public static function _($source){

        //skipfail comment-out-chars between quotes
        $sfQTS = sfQTS::_();

        //remove block comments
        $source = preg_replace("#$sfQTS|/\*.*?\*/#s", "", $source);

        //remove line comments
        $source = preg_replace("#$sfQTS|\h*(?<!\\\\)//[^\n]*#", "", $source);


        return $source;
    }
}

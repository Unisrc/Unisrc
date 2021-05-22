<?php
namespace Unisrc\xu\lib\str\json;

/*
DESC:
    Escapes backward and forward slashes in json text.

PARAMS:
    $source
        Text to process

RETURNS:

NOTES:
*/
class slashescape {

    public static function _($json){

        return str_replace(['\\','/' ], ['\\\\','\/' ], $json);
    }
}

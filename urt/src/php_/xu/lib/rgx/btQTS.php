<?php
namespace Unisrc\xu\lib\rgx;

use Unisrc\xu\lib\rgx\between;

/*
Returns a matching regular expression string
for content between quotes; single and double.
*/
class btQTS {

    public static function _(){

        static $QTS = null;

        if(!$QTS){
            $SQ = between::_("'", "'");
            $DQ = between::_('"', '"');
            $QTS = "$SQ|$DQ";
        }

        return $QTS;
    }
}

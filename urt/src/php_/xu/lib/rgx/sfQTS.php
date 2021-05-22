<?php
namespace Unisrc\xu\lib\rgx;

use Unisrc\xu\lib\rgx\skipfail;
use Unisrc\xu\lib\rgx\btQTS;

/*
Returns a skip-fail regular expression string to prevent matches
between single or double quotes.
*/
class sfQTS {

    public static function _(){

        static $RGX;

        if(!$RGX){

            $RGX = skipfail::_(	//SKIP FAIL when...

                btQTS::_()//between quotes
            );
        }

        return $RGX;
    }
}

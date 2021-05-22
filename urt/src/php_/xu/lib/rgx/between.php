<?php
namespace Unisrc\xu\lib\rgx;

/*
Generates a matching regular expression string
for content between characters in $A and in $B.

As a convention to make it clearer at first glance what type of rgx function we
look at, functions in/down this namespace that use it start with 'bt' for
between.
*/
class between {

    public static function _($A, $B){

        static $acs = "\t\r\n";

        $chars = str_split($B);
        $length = count($chars);

        $i = 0;
        while($i < $length){

            $chars[$i] = addcslashes(preg_quote($chars[$i], '/'), $acs);
            $i++;
        }


        $G = [];
        $i = 0;
        while($i < $length){

            $s = "";
            $j = 0;
            while($j < $i){
                $s .= $chars[$j++];
            }

            $c = $chars[$j];

            $G[] = $s.(($s)?'+':'').'[^'.$c.']';

            $i++;
        }

        $G = join('|', $G);

        $A = addcslashes(preg_quote($A, '/'), $acs);
        $B = addcslashes(preg_quote($B, '/'), $acs);

        return "$A(?>$G)*$B";
    }
}

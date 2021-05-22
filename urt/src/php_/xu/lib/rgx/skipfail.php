<?php
namespace Unisrc\xu\lib\rgx;

/*
Creates a skip-fail regular expression string.

It is generally used to express conditions that needs to be avoided.
If such condition is found, the search for a match with the rest of the rgx
pattern is skipped and the string cursor advances to the next char.

What we don't want is the first part of a complete expression. followed by what
we do want:

    "/rgx_skipfail|(rgx_domatch)/"

The occassion for adding this to xu.lib is building the js compiler. Lots of
JS code need parsing identifyers, provided that they are not between quotes or 
comments characters. Also see the between function and js/sfNASC.php.

As a convention to make it clearer at first glance what type of rgx function we
look at, functions in/down this namespace that use it start with 'sf' for
skipfail.
*/
class skipfail {

    public static function _(/*...*/){

        $conditions = join('|', func_get_args());

        return "(?:$conditions)(*SKIP)(*FAIL)";
    }
}

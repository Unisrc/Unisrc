<?php
namespace Unisrc\xu\lib\txt;

use Unisrc\xu\lib\txt\sys\Table;
use Unisrc\xu\lib\cls\nstofn;

/*
Class Gtx

Provides GUI Text tables from text base 'txt/gtx/*';

GUI text are often short strings for use on buttons, column headers, radio
and check boxes, menu items, etc. But is also usefull inside programmatic
configurations that contain pieces of text that are open for translations.

These are often needed for gui and cli apps that each may require dozens of
strings, that therefor need to load as fast as possible.

The format of gtx tables is the same as fb tables; a simple linear associative
array with name-value-pairs, where the value is indexed by name.
*/
class Gtx {

    public static function Load($__CLASS__){

        return Table::Load('gtx', nstofn::_($__CLASS__), false);
    }
}

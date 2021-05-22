<?php
namespace Unisrc\xu\lib\txt;

use Unisrc\xu\lib\txt\sys\Table;
use Unisrc\xu\lib\cls\nstofn;

/*
Class Cfg

Provides Cfg Text tables from text base 'txt/cfg/*';

+ CfgSpec files stored in 'unisrc/ust/cfg/*' often have references inside to multilingual help text for most of the define config nodes.

These are stored in this text base.
*/
class Cfg {

    public static function Load($__CLASS__){

        return Table::Load('cfg', nstofn::_($__CLASS__), false);
    }
}

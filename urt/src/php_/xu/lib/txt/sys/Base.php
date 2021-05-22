<?php
namespace Unisrc\xu\lib\txt\sys;

use Unisrc\xu\lib\txt\sys\Table;

/*
Class Base

Represents cached (text) Table objects,
of a common base, having common jsun flag bits.
*/
class Base {

    private $base;
    private $tables;

    public function __construct($base){

        $this->base = $base;
        $this->tables = [];
    }

    public function getText($rpClass, $code){

        if($table = $this->loadTable($rpClass))

            return $table->getText($code);
    }

///////////////////////////////////////////////////////////////  P R I V A T E

    private function loadTable($rpClass){

        $uid = Table::makeUID($this->base, $rpClass);

        if(isset($this->tables[$uid])) return $this->tables[$uid];

        if($table = Table::Load($this->base, $rpClass, true))

            return $this->tables[$uid] = $table;
    }
}

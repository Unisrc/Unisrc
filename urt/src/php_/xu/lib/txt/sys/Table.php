<?php
namespace Unisrc\xu\lib\txt\sys;

use Unisrc\xu\lib\env;
use Unisrc\xu\lib\pst\enc\jsunLoad;
use Unisrc\xu\lib\txt\Fb;

/*
Class Table

Is the assign loader for any text table inside dir "ust/txt/{base}/*".
Aside from "ust/doc/*", all sources are to deposit their possibly
multilingual textual assets inside "ust/txt/*".

A basic text table is at the base an associative array of which the elements
can be a string or a zero based array. The latter, is a multi-line string of
which the elements will be joined with a new line separator.

Method Table::Load can return the text table as is or a Table instance that
centers around the table and provides object method ->getText();
Only instanciate and use method ->getText for basic text tables.

Text tables are stored in jsun files with the *.jsun extension. Each text table
holds text in one particular language, and the language code is present in the
filename like so:
    ClassName-en.jsun
    ClassName-cn.jsun
    ClassName-es.jsun
    ClassName-jp.jsun
    ...
*/
class Table {

/////////////////////////////////////////////////  S T A T I C   /   S E T U P

    /*
    Load a text table from "ust/txt/{$base}/*,
    and return the raw table or a class Table instance.

    PARAMS:
    $base		string
        The subdir in "ust/txt/" that sets the type of tables stored in it.
        "ust/txt/{$base}" will make the base dir for the text tables.
    $rpClass	string
        Relative path of the class with forward slashes;
        "ust/txt/{base}/{$rpClass}" will make the base file path of the
        text table.
    $instanciate	bool
        true
            return a Table object;
            only for basic text tables; see class Table description.
        false
            return the text array as is;
            usefull for text tables with a custom format.

    NOTES:
    • Will automatically select the language of the table,
    according to 'lcd' inside the env vars.
    • If a text table is not available in current (env var 'lcd') language,
    the english will be loaded automatically.
    */
    public static function Load($base, $rpClass, $instanciate){

        static $lcd, $txtdir;

        if(!$lcd){
            $lcd = env::_('lcd');
            $txtdir = env::_('urtree').'txt/';
        }

        $rpBase = $base.'/'.$rpClass;
        $rpTable = self::makeUID($base, $rpClass);
        $fnTable = $txtdir.$rpTable;

        if($data = jsunLoad::_($fnTable)){

            return ($instanciate) ? new Table($data, $rpTable) : [ $data, $rpTable ];

        }else if($lcd != 'en'){

            $rpTable = self::makeUID($base, $rpClass, 'en');
            $fnTable = $txtdir.$rpTable;

            if($data = jsunLoad::_($fnTable)){

                Fb::warning(__CLASS__, 'ttflb', $rpTable);

                return ($instanciate) ? new Table($data, $rpTable) : [ $data, $rpTable ];
        
            }else{
                Fb::error(__CLASS__, 'ttbad2', [ $rpBase, $lcd ]);
            }
        }else{
            Fb::error(__CLASS__, 'ttbad', [ $rpBase, $lcd ]);
        }
    }

    /*
    Create a UID for a text table from on its text base and class path;
    this is the relative path of the text table inside "ust/txt/...".
    */
    public static function makeUID($base, $rpClass, $_lcd=''){

        static $lcd;

        if(!$lcd) $lcd = env::_('lcd');

        return $base.'/'.$rpClass.'-'.(($_lcd) ? $_lcd : $lcd).'.jsun';
    }

/////////////////////////////////////////////////  O B J E C T   M E T H O D S

    private $data;
    private $rpath;

    public function __construct($data, $rpath){

        $this->data = $data;
        $this->rpath = $rpath;
    }

    /*
    Only for basic text tables.
    */
    public function getText($code){

        if(isset($this->data[$code])){

            $text = $this->data[$code];

            if(is_array($text)) $text = join("\n", $text);

            return $text;

        }else{

            Fb::error(__CLASS__, 'ttkey', [ $code, $this->rpath ]);
            return false;
        }
    }
}

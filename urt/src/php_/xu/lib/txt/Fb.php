<?php
namespace Unisrc\xu\lib\txt;

use Unisrc\xu\lib\txt\sys\Base;
use Unisrc\xu\lib\cls\nstofn;

/*
--------------------------------------------------------------------------------
class Fb - Feedback

Central node for source code to communicate to devs and users in the form of:
    message | warning | error
The top level application can wire into this stream and arrange output.

--------------------------------------------------------------------------------
S E N D I N G   F E E D B A C K
-------------------------------
    Fb::message(__CLASS__, $code, $arguments)
    Fb::warning(__CLASS__, $code, $arguments)
    Fb::error(__CLASS__, $code, $arguments)

DESCR:
    These functions are to be used at the critical places in source code
    where sending feedback is important.

    If this is done consistently through out the code, it can save a lot of
    time in the future; whenever something unexpected happens or breaks,
    its much faster to isolate the where and why guided by the feedback,
    than if you haven't got a single clue due to the lack of feedback.

PARAMS:
    $__CLASS__
        Always!! use the __CLASS__ magical constant;
        Storing one class per file, it is also convenient to have one
        feedback text table per class, which is addressed by this argument.

    $code	string; message code
        Little symbolic string used as key/index into the class its
        feedback text table, to get the message text.

    $arguments
        Optional data items that apply on current event and that go with the
        message	text.
        If there are arguments, the message text MUST BE a format string
        that's going to be passed to printf() with these arguments.
        Else, message text is displayed as is.

NOTES:
▲ This setup makes sending messages human language independent.
▲ Feedback tables are expected to be uJSON files that allows
unescaped forward and backward slashes and tabs.

○ json file location/name format:

    txt/fbt/{devns}/{nspath}/{clsn}-{lcd}.json

    where:
        {devns}		developer namespace
        {nspath}	path on top of own developer namespace
        {clsn}		The name of the class the language table is for.
        {lcd}		2 letter language code.

○ json file content format:
    ---
    {
        "{code}": "{printf-format -string}"
    }
    ---

○ Examples:

    file: 'MyClass-en.json':
    ---
    { "fopen": "Could not open file '%s'." }
    ---

    file: 'MyClass-de.json':
    ---
    { "fopen": "File '%s' kann nicht eröffnet werden." }
    ---

    file: 'MyClass-nl.json':
    ---
    { "fopen": "Bestand '%s' kan niet geopend worden." }
    ---

--------------------------------------------------------------------------------
*/
class Fb {

    public static function message($__CLASS__, $code, $arguments=null){

        self::send($__CLASS__, $code, 'MSG', $arguments);
    }

    public static function warning($__CLASS__, $code, $arguments=null){

        self::send($__CLASS__, $code, 'WRN', $arguments);
    }

    public static function error($__CLASS__, $code, $arguments=null){

        self::send($__CLASS__, $code, 'ERR', $arguments);
    }

    public static function fbtfms($__CLASS__, $code){

        $rpClass = nstofn::_($__CLASS__);

        return self::getText($rpClass, $code);
    }


/////////////////////////////////////////////////////////  O S / M A N A G E R

    public static function onreceive($callback){

        self::$onrecvcb = $callback;

        if(self::$queue){

            foreach(self::$queue as $recv){

                list($rpClass, $code, $type, $arguments) = $recv;

                $callback($rpClass, $code, $type, $arguments);
            }

            self::$queue=null;
        }
    }

    public static function setGenericOutputHandler($cbGetOutput=null){

        self::onreceive(function($rpClass, $code, $type, $arguments) use($cbGetOutput){

            $head = (($type=='WRN')?'[WARNING':(($type=='ERR')?'[ERROR':''));
            $text = ($head) ? " $rpClass] " : '';

            if($fms = self::getText($rpClass, $code)){

                $text .= vsprintf($fms, $arguments);

                if($cbGetOutput){
                    $cbGetOutput($head.$text);
                }else{
                    echo $head, $text, "\n";
                }
            }
        });
    }

///////////////////////////////////////////////////////////////  P R I V A T E

    private static $queue = [];
    private static $onrecvcb = null;

    private static function send($__CLASS__, $code, $type, $arguments){

        $rpClass = nstofn::_($__CLASS__);

        if($arguments === null){
            $arguments = [];
        }else if(!is_array($arguments)){
            $arguments = [ $arguments ];
        }

        foreach($arguments as &$arg)
            if(!(is_string($arg) || is_numeric($arg)))
                $arg = var_export($arg, true);

        if($callback = self::$onrecvcb){
            $callback($rpClass, $code, $type, $arguments);
        }else{
            self::$queue[] = [ $rpClass, $code, $type, $arguments ];
        }
    }

    private static function getText($rpClass, $code){

        static $base;

        if(!$base) $base = new Base('fb');

        return $base->getText($rpClass, $code);
    }
}

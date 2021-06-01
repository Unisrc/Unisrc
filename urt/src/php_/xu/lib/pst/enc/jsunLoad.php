<?php
namespace Unisrc\xu\lib\pst\enc;

use Unisrc\xu\lib\txt\Fb;

use Unisrc\xu\lib\str\c\rmcmnts;
use Unisrc\xu\lib\str\json\slashescape;
use Unisrc\xu\lib\str\tabtospc;


/*
ABOUT:
	JSUN is JSON text plus possibly:
	• C-style line and block comments.
	• Forward slashes inside keys and strings.
	• Tab chars inside the text.
	• Maybe more to come in the future...

	JSUN is Unisrc its variant on JSON;
	It is used a lot and makes coding a JSON more user friendly and forgiving.
	JSUN is converted to valid JSON before JSON decoding by function load.

DESCR:
    Reads a JSUN file from disk and decodes it.

PARAMS:
	$fn					string
			The JSUN file path

	$operation
		null			defautl
			No operation.
		callable
			Hook into the JSUN text conversion to valid JSON
            right after removing the comments
            but before rest of conversion
			This allows for app|mod side custom conversions.

	$fbe				boolean
        true			default
            Generate errors if any.
        false
            Suppress errors if any.

        For example, class Fb that relies on JSUN load,
		suppresses errors, to prevent an endless recursion.
*/
class jsun_load {

    public static function _($fn, $operation=null, $fb=true){

        if($text = @file_get_contents($fn)){

            $text = rmcmnts::_($text);

            if($operation) $text = $operation($text);

            $text = slashescape::_($text);
            $text = tabtospc::_($text);

            if($mixed = @json_decode($text, true)){

                return $mixed;

            }else if($fb){

                Fb::error(__CLASS__, 'json', $fn);
            }
        }else if($fb){

            Fb::error(__CLASS__, 'fget', $fn);
        }

        return false;
    }
}

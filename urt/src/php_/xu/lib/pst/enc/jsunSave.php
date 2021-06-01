<?php
namespace Unisrc\xu\lib\pst\enc;

use Unisrc\xu\lib\txt\Fb;

/*
DESCR:
    JSUN encode data and write it to a file on disk.

PARAMS:
	$fn					string
			The JSUN file path

    $mixed				assoc array
        Data to be encoded.

    $operation
        null		default
            no operation; no call.
        callable
			Hook into the JSON text conversion to valid JSUN
            right after encoding to JSON,
            just before writing to disk.

NOTES:
+ At this point this is a stub for completeness in having a save function next to load.
There is no standard handling (yet?) to convert from JSON text to original JSUN text.
It is expected that this function will not be used a lot if at all;
JSUN files are written/maintained by hand.


+ See jsunLoad.php for more comments.
*/
class jsunSave {

    public static function _($fn, $mixed, $operation=null){

        if($data = @json_encode($mixed, JSON_UNESCAPED_SLASHES)){

            if($operation) $data = $operation($data);

            if(@file_put_contents($fn, $data)){

                return true;

            }else{

                Fb::error(__CLASS__, 'fput', $fn);
            }
        }else{

            Fb::error(__CLASS__, 'json', $fn);
        }

        return false;
    }
}

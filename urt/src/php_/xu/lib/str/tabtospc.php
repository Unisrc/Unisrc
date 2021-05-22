<?php
namespace Unisrc\xu\lib\str;

/*
DESC:
    Replaces tabs with spaces inside given text.

PARAMS:
    $text
        Text to scan and replace all tabs with spaces in.
    $ts
        The size of the tabs.
        That is the tab size used in the editor, at which the text looks right.
        If this is not the correct number, the result will look different.

RETURNS:

NOTES:
• Tabs have there fixed column positions inside the editor, that are clean
multiples of the tab size settings. This function is awear of that, and
implements it; so its not just simply replacing each tab with tab-size spaces.
• The result may be unexpected when combining this transformation with other
transformations that insert new chars for escaping for example; following text
may snap to the nexxt tab anchor positions.
*/
class tabtospc {

    public static function _($text, $ts=4){

        $lines = explode("\n", $text);

        foreach($lines as &$str){

            $string = '';

            $length = strlen($str);
            $i = 0; $j = 0;
            while($i < $length){

                $c = $str[$i];

                if($c == "\t"){
                    /*
                    Calc the number of spaces to insert for a tab character;
                    its about getting to the nearest tab anchor position,
                    which is alsways a clean multiple of tab size (ts).
                    */
                    $l = $ts - ($j % $ts);
                    $string .= str_repeat(' ', $l);
                    $j += $l;
                }else{
                    $string .= $c;
                    $j++;
                }

                $i++;
            }

            $str = $string;
        }

        return join("\n", $lines);
    }
}

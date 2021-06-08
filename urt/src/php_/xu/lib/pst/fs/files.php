<?php
namespace Unisrc\xu\lib\pst\fs;


/*
DESCR:
	Creates a list or file names that are found inside a given directory.

PARAMS:
	$dir
		The subject directory to get a file-list of.

	$match
		Optional (preg) regular expression.
		Only names that match this pattern will pass.

	$ltod		list links to dirs as files		default=true
		true
			This will handle links to dirs as files;
			it also means that a link to dir as input will not be used and
			results in an empty dir list.
		false
			This will allow to use a link to a dir as a dir and get a list from
			it; use only when making a file browser or something, but no deltree
			like operations.
	$max
		null
			neutral; disables this option; default.
		integer
			Limit the number of entries returned.
			For nowing in the context of the previous arguments
			if there are any files..

RETURNS:
	[]
		A list of file names.

NOTES:
• The returned list is sorted.
*/
class files {

	public static function _($dir, $match=null, $ltod=true, $max=null){

		$fns = [];

		if($ltod || !is_link(rtrim($dir,'/'))){

			if(is_dir($dir) && $dp = opendir($dir)){

				while(($fn = readdir($dp)) !== false){

					$ffn = $dir.$fn;

					if(is_file($ffn) || (is_link($ffn) && $ltod)){

						if(!$match || preg_match($match, $fn)){

							$fns[] = $fn;

							if($max === null || --$max) continue;

							break;
						}
					}
				}

				closedir($dp);

				sort($fns, SORT_STRING | SORT_FLAG_CASE);
			}
		}

		return $fns;
	}
}

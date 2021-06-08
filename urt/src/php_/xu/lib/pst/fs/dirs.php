<?php
namespace Unisrc\xu\lib\pst\fs;


/*
DESCR:
	Creates a list of directory names that are found inside a given directory.

PARAMS:
	$dir
		The subject directory to get a dir-list of.

	$match
		Optional (preg) regular expression.
		Only names that match this pattern will pass.

	$ltod		list links to dirs as files		default=false
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
			For knowing in the context of the previous arguments
			if there are any directories.

RETURNS:
	[]
		A list of directory names.

NOTES:
• assert: if($ltod == false), that a linked dir does not contain a link to
	one of its parent dirs. The result would be endless recursion.
*/
class dirs {

	public static function _($dir, $match=null, $ltod=false, $max=null){

		$dns = [];

		if($ltod || !is_link(rtrim($dir,'/'))){

			if(is_dir($dir) && $dp = opendir($dir)){

				while(($dn = readdir($dp)) !== false){
					
					if(($dn != '.') && ($dn != '..')){

						$fdn = $dir.$dn;

						if($ltod || !is_link($fdn)){

							if(is_dir($fdn)){

								if(!$match || preg_match($match, $dn)){

									$dns[ ] = $dn;

									if($max === null || --$max) continue;

									break;
								}
							}
						}
					}
				}

				closedir($dp);

				sort($dns, SORT_STRING | SORT_FLAG_CASE);
			}
		}

		return $dns;
	}
}

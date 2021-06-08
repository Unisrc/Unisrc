<?php
namespace Unisrc\xu\lib\pst\fs;

/*
DESCR:
	Creates a path in the file system,
	if it doesn't already exists.

PARAMS:
	$path		string

		Contains the canonical path to check or create.
		
		$path is considered a directory if it ends with a '/',
		so the path will be created up until the last path component.
		
		$path is considered a file if it does NOT end with a '/',
		so the path will be created up until the second last path component.


RETURNS:

	Nothing.

NOTES:
• assert: path is canonical
• assert: path is writable from the component that does not exist
*/
class path {

	public static function _($path){

		$components = explode('/', trim($path, '/'));

		//It is a path to a file
		if($path[strlen($path) - 1] != '/')
			//remove the filename component
			array_pop($components);

		$path = '/';

		foreach($components as $comp){

			$path .= $comp.'/';

			if(!file_exists($path))

				mkdir($path);
		}
	}
}

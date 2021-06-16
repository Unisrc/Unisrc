<?php
namespace Unisrc\xd\ubs\zzz\udt\git;

use Unisrc\xu\lib\env;

use Unisrc\xu\ubs\zzz\udt\XNSs;
use Unisrc\xu\ubs\zzz\udt\possiblePaths;

class createIgnoreFile {

	/*
	DESCR:
		Generates UBS its one and only .gitignore file.
	*/
	public static function _($doit, $dpfn){

		$ffn = env::_('unisrc').'.gitignore';
		$uts = env::_('uts');

		$YYYYMMDDHHMMSS = date('Ymd His', $uts);

		$hdrlen = 10;
		$gitignore = [
			"###################################################################",
			"### Defines exactly what UBS repository is and what should be   ###",
			"### excluded and included by git, to keep it isolated from any  ###",
			"### hosted, installed and interleaved UCR repository, and any   ###",
			"### user or application data states.                            ###",
			"###                                                             ###",
			"### Generated on $YYYYMMDDHHMMSS by repo 'xd-ubs', utility      ###",
			"### xd/ubs/zzz/udt/git/gpmlcf                                   ###",
			"### !!! DO NOT MODIFY !!!                                       ###",
			"###################################################################",
			'/*',
			'!.gitignore',
			'!.gitattributes',
			'!*.adoc'
		];

		$XNSs = XNSs::keys('UBS');
		$paths = possiblePaths::_();

		foreach($paths as $path){

			$gitignore[] = "!/$path";

			if(self::noXNSpath($path, $XNSs)){
				$gitignore[] = "/$path/*";
				$gitignore[] = "!/$path/$dpfn";
			}
		}
		$gitignore[]="";

		return self::overwriteIfDifferent($doit, $ffn, $gitignore, $hdrlen);
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	/*
	DESCR:
		Writes the .gitignore file, but only if it has changed.

	*/
	private static function overwriteIfDifferent($doit, $ffn, $gitignore, $hdrlen){

		if(file_exists($ffn)){
			$text = file_get_contents($ffn);
			$array = explode("\n", $text);

			$old = join("\n", array_slice($array, $hdrlen));
			$new = join("\n", array_slice($gitignore, $hdrlen));

			if($old == $new) return 'false';
		}

		if($doit)
			file_put_contents($ffn, join("\n", $gitignore));
		return 'true';
	}

	/*
	DESCR:
		Detects is path has an UBS XNS (unisrc namespace) as leaf component.

	*/
	private static function noXNSpath($path, $XNSs){

		foreach($XNSs as $xns)
			if(preg_match("#$xns$#", $path))
				return false;

		return true;
	}
}

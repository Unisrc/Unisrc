<?php
namespace Unisrc\xu\lib\cli;

/*
DESCR:
	Parses a CLI-like arguments list, stores it in convenient structure,
	ready to be queried by the caller.

PARAM:
	$argv		zb list | default=null
		list
			Expected is a list similar as in $_SERVER['argv']
			which is present in CLI mode.
		null
			CLI mode is assumed and $_SERVER['argv'] is used.

RETURNS:
	See methods.

NOTES:
• A dump function is provided to see content after parsing.
*/
class Args {

	private $cmdl;
	private $data;

	public function __construct($argv=null){

		$argv = ($argv !== null) ? $argv : $_SERVER['argv'];

		$this->cmdl = join(' ', $argv);
		$this->data = self::parse($argv);
	}


	/*
	DESCR:
		Read flag.
		Flags are specified on the command line
		like so: '-abc123' or '--abc123'

	PARAM:
		$k		char|int
			char	word character (\w)
				specify a flag to read
			int
				0	return the complete lookup table
				-1	return the chars/keys as string found on
					command line (Without '-' prefix)

	RETURNS:
		boolean | array | string

	NOTES:
	• There is only one block of flags allowed as command line argument;
	follow ups will overwrite the one reserved array for it, loosing all
	data of a previous block.
	*/
	public function fl($k){

		$fl = $this->data['fl'];

		if(!is_int($k))
			return (isset($fl[$k])) ? true : false;

		if($k == 0)return $fl;
		if($k == -1)return join('', array_keys($fl));
	}


	/*
	DESCR:
		Named Value

	PARAM:
		$k		string|int
			string
				The key/name to the value
			int
				0	return the complete lookup table

		$alt	mixed
			Alternative value to return, instead of false,
			if $k does not exist.

	RETURNS:
		string | mixed | array

	NOTES:
	*/
	public function nv($k, $alt=false){

		$nv = $this->data['nv'];

		if(!is_int($k))
			return (isset($nv[$k])) ? $nv[$k] : (($alt!==false)?$alt:false);

		if($k == 0)return $nv;
	}


	/*
	DESCR:
		Single/Standalone Value.

	PARAM:
		$i		int
			>=0		return value at $i
			-1		return the table length
			-2		return the complete table

		$alt	mixed
			Alternative value to return, instead of false,
			if $i>=0 does not exist.

	RETURNS:
		string | int | array

	NOTES:
	*/
	public function sv($i, $alt=false){

		$sv = $this->data['sv'];

		if($i >= 0)
			return (isset($sv[$i])) ? $sv[$i] : (($alt!==false)?$alt:false);

		if($i == -1)return $this->data['sc'];
		if($i == -2)return $sv;
	}


	/*
	DESCR:
		Command Line Format Check

		Are the various inputs in right order, at right place?

	PARAM:
		$format		string
			
			Space separated values that each corresponds to
			the input type expected on the command line
			in that order.

			'cm'	Command
				The full path of the command.
				Only one occurence at the beginning, always.

			'fl'	Flags block
				Only one may exist of these.
				Start with '-' followed by word chars (\w)

			'nv'	Named Value
				Any amount.
				Start with '-' or '--',
				followed by at least one word char (\w),
				followed by any \w or '-', (that's it for the name)
				followed by '=', (now for the value)
				followed by any chars, but not space.

			'sv'	Single Standalone Value

			Each input type specified may be followed by a '?',
			telling the presence on command line is optional.

			e.g.: $format='sv fl? nv? nv? nv? nv? sv'
			The main command is followed by single value (possibly a sub command),
			optional flags block and 4 named values,
			closed by one trailing value.

			By putting return value of $args->sv(0) through a switch,
			the $format belonging to a command can be selected and
			queried here.

	RETURNS:
		int
			1	Passed the format test
			0	Test failed.
		boolean
			false	Test not performed; there was an error.

	NOTES:
	*/
	public function isfm($format){

		if(preg_match_all("/(cm|fl|nv|sv)(\?)?/", $format, $matches)){

			list( , $types, $opts) = $matches;

			$xp = [];

			foreach($types as $i => $type){

				$opt = $opts[$i];

				switch($type){
				case 'cm': $xp[$i] = "(?:(?:\/[^\/]+)+)"; break;
				case 'fl': $xp[$i] = "(?:\s-\w+)"; break;
				case 'nv': $xp[$i] = "(?:\s--?\w+[\w-]+=[^\s]+)"; break;
				case 'sv': $xp[$i] = "(?:\s[^-]{1}[^\s]*)"; break;
				}

				if($opt) $xp[$i] .= '?';
			}

			$xp = '/^'.join('', $xp).'$/';

			return preg_match($xp, $this->cmdl);
		}
		return false;
	}

	/*
	DESCR:
		Return or echo a dump of the internal data structure.

	PARAM:
		$ret		boolean
			true	return the data
			false	echo the data

	NOTES:
	*/
	public function dump($ret=false){

		return print_r($this->data, $ret);
	}

///////////////////////////////////////////////////////////////  P R I V A T E

	private static function parse($argv){

		$cm=''; $fl=[]; $nv=[]; $sv=[]; $sc=0;

		foreach($argv as $i => $value){

			if(!$i){
				$cm = $value;
			}else if(preg_match("/^-(\w+)$/", $value, $match)){
				list( , $v) = $match;
				$fl = array_fill_keys(str_split($v), true);
			}else if(preg_match("/^--?(\w[\w-]+)=(.+)$/", $value, $match)){
				list( , $k, $v) = $match;
				$nv[$k] = $v;
			}else{
				$sc++;
				$sv[] = $value;
			}
		}

		return [ 'cm'=>$cm, 'fl'=>$fl, 'nv'=>$nv, 'sv'=>$sv,'sc'=>$sc ];
	}
}

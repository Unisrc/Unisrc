<?php
/*
Entry Point: HTTP, with Env::init(application[, arguments]).
*/
namespace Unisrc\xu\ubs\zzz;

$UNISRC = realpath(__DIR__.'/../../../../').'/';
include	$UNISRC.'urt/src/php_/xu/ubs/zzz/Env.php';

return Env::init(
	$UNISRC, $IN_application,
	(isset($IN_arguments)) ? $IN_arguments : '',
	(isset($IN_rtaurl)) ? $IN_rtaurl : ''
);

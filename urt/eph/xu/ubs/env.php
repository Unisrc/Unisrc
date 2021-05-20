<?php
/*
Entry Point: HTTP, with Env::init() without any arguments.
*/
namespace Unisrc\xu\ubs\zzz;

$UNISRC = realpath(__DIR__.'/../../../../').'/';
include	$UNISRC.'urt/src/php_/xu/ubs/zzz/Env.php';

return Env::init($UNISRC);

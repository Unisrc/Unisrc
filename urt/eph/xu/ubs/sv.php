<?php
/*
Entry Point: HTTP, with Unisrc Base Server (unless alternative is given)
*/
namespace Unisrc\xu\ubs\zzz;

$UNISRC = realpath(__DIR__.'/../../../../').'/';
include	$UNISRC.'urt/src/php_/xu/ubs/zzz/Env.php';

return Env::init($UNISRC, 'xu.ubs.zzz.sv.server::_', [ $IN_altLoginBg, $IN_altClientApp ]);

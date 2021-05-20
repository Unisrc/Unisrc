<?php
namespace Unisrc\xu\ubs\zzz\sv;

use Unisrc\xu\ubs\zzz\sv\Client;

use Unisrc\xu\lib\ht\rq\nodes;
use Unisrc\xu\lib\cls\dntons;

class server {

	public static function _($Env, $arguments){

		list($altLoginBg, $altClientApp) = $arguments;

		$Env->stctxa = 'xu.ubs';

		switch($node = nodes::_(0)){
		case '/':
			if(!$altClientApp){
				//Load default client application
				Client::server($Env);
			}else{
				//Load given alternate client application
				$nsClassMethod = dntons::_($altClientApp);
				return $nsClassMethod($Env);
			}
		break;
		case '/cron/':
		break;
		}
	}
}

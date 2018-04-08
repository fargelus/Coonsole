<?php

namespace App;

define('APP_START', microtime(TRUE));
define('APP_DATE_START', time());

//Адреса
define('APP_DIR', __DIR__);

define('IS_AJAX', !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

define('APP_DOMAIN', ($_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev'))) ? 'http://127.0.0.1:8000/' : 'https://coonsole.ru/');

// TIME
define('MINUTE', 60);
define('HOUR', 60 * MINUTE);
define('DAY', 24 * HOUR);
define('WEEK', 7 * DAY);
define('MONTH', 30 * DAY);

//FORMAT
define('APP_DATE_TIME_MYSQL', 'Y-m-d H:i:s');

define('VK_CLIENT_ID', 6438289);
define('VK_CLIENT_SECRET', 'ejattL3RCBunmbbSKiWY');
define('VK_REDIRECT', APP_DOMAIN.'login/check/?oauth=vk');

define('APP_USER_ADMIN', 1);
define('APP_USER_USER', 3);
define('APP_USER_BAN', 4);
define('APP_USER_DELETE', 5);


function xss_clear($str)
{
	return htmlspecialchars($str, ENT_QUOTES);
}
<?php

namespace App;

define('APP_START', microtime(TRUE));
define('APP_DATE_START', time());

//Адреса
define('APP_DIR', __DIR__);

define('IS_AJAX', !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

// TIME
define('MINUTE', 60);
define('HOUR', 60 * MINUTE);
define('DAY', 24 * HOUR);
define('WEEK', 7 * DAY);
define('MONTH', 30 * DAY);

//FORMAT
define('APP_DATE_TIME_MYSQL', 'Y-m-d H:i:s');

define('APP_USER_ADMIN', 1);
define('APP_USER_USER', 3);
define('APP_USER_BAN', 4);
define('APP_USER_DELETE', 5);


function xss_clear($str)
{
	return htmlspecialchars($str, ENT_QUOTES);
}
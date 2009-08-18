<?php

/**
 * Settings, contains constants etc
 *
 * Currently supports both Linux and Windows
 *
 * TODO test on mac
 *
 * @author Gareth Stones <gareth@rezolabs.com>
 */

// boolean, disable or enable memcache
define ('ENABLE_MEMCACHE', true);

// database connection
//require_once '../../database.php';

// directory seperator
define ('DS', (PHP_OS == 'Linux') ? '/' : '\\');

// dir locations
define ('DIR_ROOT', (PHP_OS === 'Windows') ? 'E:\Program Files\Apache Software Foundation\Apache2.2\htdocs\tiger\important\\' : '/var/www/hosting/tiger/important/');

define ('DIR_CORE', DIR_ROOT . 'core');
define ('DIR_STARTUP', DIR_ROOT . 'startup');
define ('DIR_EXTERNAL', DIR_ROOT . 'external');
define ('DIR_THEME', DIR_ROOT . 'theme');
define ('DIR_PLUGIN', DIR_ROOT . 'plugins');

?>

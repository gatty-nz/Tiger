<?php

// TODO has MySQLnd replaced pdo_mysql etc?

/**
 * Boot process
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU Lesser General Public License (version 3)
 */

define ('BOOT_STARTUP', 0);
define ('BOOT_ERROR', 1);
define ('BOOT_HTTP_SECURITY', 2);
define ('BOOT_CONSTANTS', 3);
define ('BOOT_DISPLAY', 4);
define ('BOOT_PLUGIN', 5);
define ('BOOT_FULL', 6);

function boot ($phase) {
   
   $order = array (BOOT_STARTUP, BOOT_ERROR, BOOT_HTTP_SECURITY, BOOT_CONSTANTS, BOOT_DISPLAY, BOOT_PLUGIN, BOOT_FULL);
   $position = 0;
   
   for ($position = $order[0]; $position <= $phase; $position++) {
      switch ($position) {
         case BOOT_STARTUP:
            // load various constants, and singleton function (design pattern)
            require_once 'settings.php';
            require_once DIR_STARTUP . DS . 'singleton.php';
         break;
         case BOOT_ERROR:
            // error and exception handlers
            require_once DIR_STARTUP . DS . 'error.php';
            require_once DIR_STARTUP . DS . 'exception.php';
            set_exception_handler('exception_handler');
            set_error_handler('error_handler');
         break;
         case BOOT_HTTP_SECURITY:
            // security data class, and http request handling
            require_once DIR_CORE . DS . 'class.securedata.php';

            require_once DIR_CORE . DS . 'class.http.request.php';
            singleton('HTTPRequest')->setHeader($_GET, $_POST, $_COOKIE, $_SERVER);
            require_once DIR_STARTUP . DS . 'http.methods.php';
         break;
         case BOOT_CONSTANTS:
            // more various constants, requires HTTPRequest class
            require_once DIR_STARTUP . DS . 'constants.php';
         break;
         case BOOT_DISPLAY:
            // load smarty for templating
            ob_start();
            require_once DIR_EXTERNAL . DS . 'Smarty-2.6.19' . DS . 'libs' . DS . 'Smarty.class.php';
            singleton('Smarty')->compile_check = true;
            singleton('Smarty')->debugging = false;
            singleton('Smarty')->template_dir = DIR_EXTERNAL . DS . 'Smarty-2.6.19' . DS . 'templates';
            singleton('Smarty')->compile_dir = DIR_EXTERNAL . DS . 'Smarty-2.6.19' . DS . 'templates_c';
            singleton('Smarty')->cache_dir = DIR_EXTERNAL . DS . 'Smarty-2.6.19' . DS . 'cache';
            singleton('Smarty')->config_dir = DIR_EXTERNAL . DS . 'Smarty-2.6.19' . DS . 'configs';
         break;
         case BOOT_PLUGIN:
            // main plugin handling
            require_once DIR_CORE . DS . 'class.plugin.php';
            require_once DIR_CORE . DS . 'class.plugin.manager.php';
            singleton('PluginManager')->boot();
         break;
         case BOOT_FULL:
            // display website
            // prehaps cleanups?
            // TODO update below to get user theme
            singleton('Smarty')->display(DIR_THEME . DS . 'default' . DS . 'default.tpl');
            ob_end_flush();
         break;
      }
   }
}

?>

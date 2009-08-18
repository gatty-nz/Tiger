<?php

/**
 * __autoload any class given as param $className
 *
 * This function will work in conjunction with load.php
 * Load any extended class that hasn't been loaded yet
 *
 * @author    Gareth Stones <gareth@rezolabs.com>
 * @copyright 6th December 2007
 */

function __autoload ($className) {
	
   if (substr($className, strlen($className) - strlen("Exception"), strlen($className))  == "Exception")
      require_once DIR_CORE . '/exception/' . $className . '.php';
   
   else {
      $location = scanForClass($className);
      require_once constant('DIR_' . strtoupper($location[0])) . $location[1] . $className . '.php';
   }
}

?>

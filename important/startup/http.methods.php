<?php

/**
 * Various functions to interact with HTTPRequest object
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License (version 3)
 */

/**
 * Return GET, POST, FILE etc HTTP key values
 *
 * @return string
 */

function method ($method, $key) {
   
   $method = 'method' . ucfirst(strtolower($method));
   
   try {
      return singleton('HTTPRequest')->$method($key);
   }
   
   catch (Exception $e) {
      return null;
   }
}

?>

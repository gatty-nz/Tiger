<?php

/**
 * Plugin system
 *
 * Abstract class required to be extended for each plugin created.
 * Handles essential information for generic plugins.
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License
 */

abstract class Plugin {
	
   protected $name = null;
   protected $description = null;
   protected $version = 0;
   
   // set name, description and version values
   public function construct () {}
   
   // get name, description and version values
   public function details () {
      
      return array ('name'        => null,
                    'description' => null,
                    'version'     => null);
   }
   
   // check values within get and post http methods
   public function get () {}
   public function post () {}
}

?>

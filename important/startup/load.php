<?php

/**
 * Small class used for loading the core and plugins
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License
 */

class Load {
   
   /**
    * Node to store directory listings within
    */
   
   private $node = null;
   
   /**
    * Files to exclude from loading
    */
   
   private $exclude = array();
   
   /**
    * Files to load
    */
   
   private $include = array();
   
   public function load (SecureData $expression, SecureData $type) {
      
      $this->expression = $expression;
      $this->type = $type;
      
      if ($this->validate() == false) {
         throw new StartupException (EXCEPTION_STARTUP_LOAD_VALDIATION);
         return false;
      }
      
      $this->parse();
      
      return true;
   }
   
   public function parse () {
      
      $list = split(' ', $expression);
      
      foreach ($list as $value) {
         if ($value[0] == '~')
            $exclude[] = substr($value, 1, strlen($value)) . '.php';
         else if ($value[0] == '*')
            $include[] = listDir($this->path);
      }
   }
}

?>
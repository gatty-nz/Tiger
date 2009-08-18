<?php

/**
 * Plugin Manager
 *
 * Interact with plugin loading
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License
 */

class PluginManager {
   
   private $request = null;
   private $db = null;
   private $section = null;
   
   public function __construct () { }
   
   public function __clone () { }
   
   public function boot () {
      
      //$this->request = singleton('HTTPRequest');
      //$this->db = singleton('DB');
      
      try {
         if (($this->section = method('GET', 'plugin')) === false) {
            $this->section = new SecureData('home');
         }
      }
      
      catch (Exception $e) {
         $this->section = new SecureData('home');
      }
      
      //var_dump($this->section);
      require_once DIR_PLUGIN . DS . $this->section->toXHTML() . DS . $this->section->toXHTML() . '.php';
      
      //echo '<p>' . $this->section->toXHTML() . '</p>';
      
      // what was i doing here?
      //singleton($this->section->toXHTML())->get();
      //singleton($this->section->toXHTML())->post();
   }
}

?>

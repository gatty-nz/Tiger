<?php

class Blog extends Plugin {
   
   public function __construct () {
      
      $this->name = 'Blog';
      $this->description = 'Simple lightweight Blogging software.';
      $this->version = 0.1;
   }
   
   public function details () {
      
      return array('name'        => $this->name,
                   'description' => $this->description,
                   'version'     => $this->version);
   }
   
   public function post () {
      
      $allow = array ('username', 'url', 'comments', 'submit');
      // FIXME doing this wrong, should be done within blog post logic... not
      // parse of POST
      /*foreach ($allow as $key) {
         if (!(method('POST', $key) instanceof SecureData))
            return false;
      }*/
      
      echo '<p>blog post method success</p>';
   }
   
   public function get () {
      
      $allow = array ('view');
      
      // TODO plan!
      // here i'm trying to detect which method('GET', 'x') isset, from there, act upon it
      
      foreach ($allow as $key) {
         if (method('GET', $key) instanceof SecureData) {
            switch ($key) {
               case 'view':
                  echo '<p>viewing blog entry ' . method('GET', $key)->toInteger() . '</p>';
               break;
            }
         }
      }
   }
}

?>

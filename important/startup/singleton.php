<?php

/**
 * Singleton Design Pattern impelementation
 *
 * Uses Memcache were avaliable, otherwise creates a new singleton object for each page load
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License
 */

function singleton ($class) {
	
	static $objects = array();
	
	// create new memcache object
	/*if ($memcache[DOMAIN] !== false && !is_object($objects['Memcache'])) {
      echo '<p>Memcache is not an object, creating.</p>';
		$objects['Memcache'] = new Memcache;
      $objects['Memcache']->connect($memcache['localhost']['hostname'],
      $memcache['localhost']['port']) or die ('<p>Failed to create Memcache
      object.</p><p>' . $memcache['localhost']['hostname'] . '</p>');
   }
	
	// use memcache if enabled
	if ($memcache[DOMAIN] !== false && !is_object($class)) {
		if (($object[$class] = unserialize($objects['Memcache']->get($class))) === false)
			$object[$class] = $objects['Memcache']->set($class, serialize(new $class));
	}*/
	
	// use static objects if memcache disabled
	if (!is_object($objects[$class]) && class_exists($class))
		$objects[$class] = new $class;
   
	return ($objects[$class] === null) ? false : $objects[$class];
}

?>

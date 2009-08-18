<?php

/**
 * MySQL connection handler
 *
 * @author Gareth Stones <gareth@rezolabs.com>
 * @copyright GNU lisence
 */

function getMySQL () {
	static $db = null;
	
	if ($db === null)
		$db = new MySQLi('10.1.1.3', 'rezolabs', 'rezolabs', 'rezolabs');
	
	return $db;
}

?>

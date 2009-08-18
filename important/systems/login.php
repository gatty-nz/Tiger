<?php

/**
 * Login System
 *
 * Allows a user to access there account
 *
 * @author    Gareth Stones <gareth@rezolabs.com>
 * @copyright 5th December 2007
 */

$continue = true;

if (methodCheck(FILE) == true) {
	$clean = array();
	
	foreach ($_POST as $key => $value) {
		if (in_array($key, $allow[FILE]) == false || ($clean[$key] = new SecureData($value)) == false || $clean[$key]->isValid == false) {
			unset($clean);
			require_once DIR_COMPONENT . FILE . '/error.php';
			break 2;
		}
	}
	
	$query = null;
	$query = vprintf('CALL login_user ("%s", "%s")', $clean);
	unset($clean);
	
	$result = null;
	
	try {
		$result = $mysql->query($query);
		unset($query);
		
		if ($result->num_rows == 1 && ($row = $result->fetch_assoc()) == true && $row['success'] == 1) {
			$continue = false;
			require_once DIR_COMPONENT . FILE . '/success.php';
		}
	}
	
	catch (MySQLException $e) {
		require_once DIR_COMPONENT . FILE . '/error.php';
	}
}

if ($continue == true) {
	$content->display(FILE);
	require_once DIR_COMPONENT . FILE . '.php';
}

?>

<?php

/**
 * User registeration system
 *
 * Allows a visitor to become a member, by registering an account
 * See documentation for user privileges, and how to change user access
 *
 * @author     Gareth Stones <gareth@rezolabs.com>
 * @copyright  July 7th 2007
 */

$continue = true;

if ($security->checkMethod(FILE) == true) {
	$clean = array();
	
	foreach ($_POST as $key => $value) {
		/**
		 * Check if $key is an allowed HTTP POST method key
		 * If so, create a new clean array object key for it
		 * Validate the data, returns true if there is no validation condition for it, and if it's valid, false otherwise
		 */
		
		if (in_array($key, $allow[FILE]) == false || ($clean[$key] = new SecureData($value)) == false || $clean[$key]->isValid == false) {
			unset($clean);
			$content->display(FILE . '_failure');
			break 2;
		}
	}
	
	unset($_POST);
	
	/**
	 * $clean array holds key => value of sanitized $_POST
	 */
	
	/**
	 * Sort a way to adjust how many parameters can be sent to register_user depending on what fields there are within the registeration form.
	 * As different sites will have different purposes for the form
	 */
	
	$query = null;
	$query = vprintf('CALL register_user ("%s", "%s", "%s")', $clean);
	unset($clean);
	
	/**
	 * Place object checking inside the MySQLi class
	 */
	
	$result = null;
	$result = $mysql->query($query);
	unset($query);
	
	if (!is_object($result))
		require_once DIR_COMPONENT . 'error.php';
	
	elseif ($result->num_rows == 1 && ($row = $result->fetch_assoc()) == true && $row['success'] == 1) {
		$continue = false;
		$content->display(FILE . '_success');
	}
	
	else
		require_once DIR_COMPONENT . 'error.php';
}

if ($continue == true) {
	/**
	 * $content->display(FILE) will display the introductions and such ready for AJAX interaction
	 * Next line will display the component
	 */
	
	$content->display(FILE);
	require_once DIR_COMPONENT . FILE . '.php';
}

?>

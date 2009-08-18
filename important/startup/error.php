<?php

/**
 * Error handling
 *
 * TODO add AI for error handling, such as telling the end developer / user etc if they missed validating the SecureData object
 *
 * @author  Gareth Stones <gareth@rezolabs.com>
 * @license GNU General Public License (version 3)
 */

function error_handler ($number, $string, $file, $line) {
	
	switch ($number) {
		case E_ALL:
		case E_CORE_ERROR:
		case E_CORE_WARNING:
		case E_COMPILE_ERROR:
		case E_COMPILE_WARNING:
		case E_ERROR:
			ob_end_clean();
			echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #CC0000;"><h1>Core Error Found</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
			ob_end_flush();
			exit;
		break;
		case E_WARNING:
			ob_end_clean();
			echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #FF6600;"><h1>Warning!</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
			ob_end_flush();
			exit;
		break;
		case E_PARSE:
			echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #CC0000;"><h1>Parse Error</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
			exit;
		break;
		case E_NOTICE:
			//echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #FFFF99;"><h1>Notice</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
		break;
		case E_USER_ERROR:
		case E_USER_WARNING:
		case E_USER_NOTICE:
			ob_end_clean();
			echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #CC0000;"><h1>User Error Found</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
			ob_end_flush();
			exit;
		break;
		case E_STRICT:
			echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #CC0000;"><h1>Strict Error Found</h1><p>' . $string . '</p><p>On line ' . $line . ', in ' . $file . '</div>';
			exit;
		break;
		case E_RECOVERABLE_ERROR:
		   if (strstr($file, 'plugin')) {
			   echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #FFFF99;"><h1>Plugin Hickup!</h1><p>';
			   if (strstr($string, 'SecureData'))
			      echo 'Forget to validate your GET, POST etc data? Hickup was found in, ' . $file . ' on line ' . $line . '.';
			   else
			      echo $string;
			   echo '</p>';
			}
			else {
			   echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #FFFF99;"><h1>Recoverable Sneeze!</h1><p>' . $string . ', in ' . $file . ' on line ' . $line . '</p>';
			}
			exit;
		break;
	}
}

?>

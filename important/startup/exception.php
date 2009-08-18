<?php

/**
 * Friendly exception handler
 *
 * @author Gareth Stones <gareth@rezolabs.com>
 */

function exception_handler ($exception) {
   
   echo '<div style="padding: 5px; margin: 5px; border: 1px #000000 solid; background-color: #CC0000;"><h1>Exception Caught</h1><p>' . $exception->getMessage() . '</p><p>On line ' . $exception->getLine() . ', in ' . $exception->getFile() . '</div>';
}

?>
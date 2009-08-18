<?php

foreach ($_GET as $key => $value) {
	unset($_GET[$key]);
	$_GET[$key] = new SecureData ($value);
}

foreach ($_POST as $key => $value) {
	unset($_POST[$key]);
	$_POST[$key] = new SecureData ($value);
}

?>
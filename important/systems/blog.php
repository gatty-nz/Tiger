<?php

/**
 * Blog System
 *
 * Displays blog entries for the user to view
 *
 * @author     Gareth Stones <gareth@rezolabs.com>
 */

if (($rows = $blog->fetch(BLOG_LIMIT)) != false) {
	foreach ($rows as $key => $value)
		require_once DIR_COMPONENTS . 'blog/entries.php';
}

$blog->pageination('number');

?>

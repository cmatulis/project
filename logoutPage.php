<?php

/**
 * logoutPage.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Log a user out and return to the login page
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

// destroy the session variable to log the user out
session_start();
session_destroy();

$msg = "";
$resultid = 0;

printPageTop('Poster');
printPageHeader();

?>

</body>
</html>


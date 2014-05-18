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

// unset the cookie and set it to a value with a negative timestamp
if(isset($_COOKIE['304bloguserphp'])) {
  	unset($_COOKIE['304bloguserphp']);
  	setcookie('304bloguserphp', '', time() - 3600); // empty value and old timestamp
}

$msg = "";
$resultid = 0;

printPageTop('Poster');
printPageHeader();

?>

</body>
</html>


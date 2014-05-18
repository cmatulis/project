<?php

/**
 * followersPage.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Calls the page that will print when the user wants to view their followers
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

// if the user is not logged in, redirect to the login page
if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}

// get the currently logged-in user
$user = $_COOKIE['304bloguserphp']; 

// display the page with the user's followers
printFollowersPage($dbh, $user);

?>

</body>
</html>
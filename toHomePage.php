<?php

/**
 * toHomePage.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Calls the functions to print the home page of Poster, 
 * which is the page that a user will see when they log in, allowing them
 * to view their own blog or view all posts from other users
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if a user is not currently logged in, redirect to the login page
if(!isset($_SESSION['user'])){
  	header('Location: blog-login.php');
}

$poster = $_SESSION['user'];

printPageTop('Home');
printNext($poster);

?>

</body>
</html>
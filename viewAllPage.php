<?php

/**
 * viewAllPage.php
 * Sojung Lee & Catherine Matulis
 * May 2014 
 * CS304
 *
 * Generates the page that will display the most recent (20) posts from all
 * users of the site
 */
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if there is not a user logged in, redirect to login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

$poster = $_SESSION['user']; 

// if a user is commenting on a post
if (isSet($_POST['blogComment'])){
	// insert comment into the database
	$insert = "insert into comments(entry_id, commenting_user, comment_text) values(?, ?, ?)";
	$rows = prepared_statement($dbh, $insert, array($_POST['entryId'], $poster, $_POST['blogComment']));
}

// if a user is liking a post
if (isSet($_GET['entry_id'])){
	$entry_id = $_GET['entry_id']; // id of the entry that was liked
	$liking_user = $poster; // the user who liked the post
	$posting_user = $_GET['posting_user'];  // the suthor of the post

	// do not allow a user to like their own post
	if (strcmp($liking_user, $posting_user)){
		$preparedquery4 = "select * from likes where entry_id = ? and liking_user = ?";
		$resultset4 = prepared_query($dbh, $preparedquery4, array($entry_id, $liking_user));
		$resultset4check = $resultset4 -> numRows();
		
	// only allow a post to be liked once by each user
		if ($resultset4check == 0){
			$insert = "insert into likes(entry_id, liking_user) values(?,?)";
			$rows = prepared_statement($dbh, $insert, array($entry_id, $liking_user));
		}
	}
	header("Location: viewAllPage.php");
}

printAllPosts($dbh);

?>

</body>
</html>
<?php

/**
 * blog-ex-comment-user.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 * 
 * Controls the interactions that a user can have with their own blog,
 * including commenting on posts and deleting posts
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if a user is not currently logged in, redirect them to the login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

$poster = $_SESSION['user']; 

// allow the user to comment on their own post
if (isSet($_POST['blogComment'])){
	$insert = "insert into comments(entry_id, commenting_user, comment_text) values(?, ?, ?)";
	$rows = prepared_statement($dbh, $insert, array($_POST['entryId'], $poster, htmlspecialchars($_POST['blogComment'])));
	header("Location: blog-ex-comment-user.php");
}

// if the user wants to delete a post
else if (isSet($_GET['entry_id'])){
	$entry_id = $_GET['entry_id']; //id of the entry that was liked
	$posting_user = $_GET['posting_user']; // the author of the post
	
	// delete the post, as well as any comments and likes that have been made on that post
	// to make sure that no one can alter the GET values to delete someone else's post,
       // make sure that the supposed author of the post matches the logged-in user
	if (!strcmp($posting_user, $poster)){
		$preparedquery = "delete from likes where entry_id = ?";
		$resultset = prepared_query($dbh, $preparedquery, array($entry_id));
		$preparedquery2 = "delete from comments where entry_id = ?";
		$resultset2 = prepared_query($dbh, $preparedquery2, array($entry_id));
		$preparedquery3 = "delete from blog_entry where entry_id = ?";
		$resultset3 = prepared_query($dbh, $preparedquery3, array($entry_id));
	}
	header("Location: blog-ex-comment-user.php");
	
}

printBlog($dbh, $poster);

?>

</body>
</html>



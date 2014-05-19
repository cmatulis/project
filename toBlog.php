<?php

/**
 * toBlog.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Redirects to other users' blogs, and allows for interactions with other blogs,
 * including following, unfollowing, liking, and commenting. 
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();
$loggedInUser = $_SESSION['user'];

// if no one is logged in, redirect to login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

// if someone has clicked the unfollow button
if (isSet($_POST['unfollowfollowing'])){
	$user1 = $_POST['unfollowfollowing'];
	$user2 = $_POST['unfollowfollower'];

	// update the database
	$delete = "delete from follows where (user, following) = (?, ?)";
  	$rows = prepared_statement($dbh, $delete, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

// if someone has clicked the follow button
else if (isSet($_POST['followfollowing'])){
	$user1 = $_POST['followfollowing']; // the user who is now being followed
	$user2 = $_POST['followfollower']; // the user who is now following user1

	// update the database
	$insert = "insert into follows(user, following) values(?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

// if someone has liked a post
else if (isSet($_GET['entry_id'])){
	$entry_id = $_GET['entry_id']; //id of the entry that was liked
	$liking_user = $loggedInUser;		// the user who liked the post
	$posting_user = $_GET['posting_user']; // the author of the post
	
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
	header("Location: toBlog.php?user=$posting_user");
}

// if a user is inserting a comment into a blog
else if (isSet($_POST['blogComment'])){
	$insert = "insert into comments(entry_id, commenting_user, comment_text) values(?, ?, ?)";

	// the current user should remain on the blog page of the user who created the post, which must be determined
	$rows = prepared_statement($dbh, $insert, array($_POST['entryId'], $loggedInUser, $_POST['blogComment']));
	$preparedquery = "SELECT user FROM blog_entry where entry_id = ?";
	$resultset = prepared_query($dbh, $preparedquery, $_POST['entryId']);
	$row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC);
  	$posting_user = $row['user'];

	header("Location: toBlog.php?user=$posting_user");
}

// otherwise display the blog requested
else{
	$user = $_GET['user'];
	$result = ($user == $loggedInUser);
	if ($result == 1){
  		printBlog($dbh, $user);
	}
	else{
		showBlog($dbh, $user, $loggedInUser);
	}
}

?>

</body>
</html>
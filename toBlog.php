<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
$thecookie = $_COOKIE['304bloguserphp'];

if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}

if (isSet($_POST['unfollowfollowing'])){
	$user1 = $_POST['unfollowfollowing'];
	$user2 = $_POST['unfollowfollower'];
	$delete = "delete from follows where (user, following) = (?, ?)";
  	$rows = prepared_statement($dbh, $delete, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

else if (isSet($_GET['entry_id'])){
	$entry_id = $_GET['entry_id'];
	$liking_user = $thecookie;
	$posting_user = $_GET['posting_user'];
	if (strcmp($liking_user, $posting_user)){
	$preparedquery4 = "select * from likes where entry_id = ? and liking_user = ?";
			$resultset4 = prepared_query($dbh, $preparedquery4, array($entry_id, $liking_user));
			$resultset4check = $resultset4 -> numRows();
			if ($resultset4check == 0){
	$insert = "insert into likes(entry_id, liking_user) values(?,?)";
	$rows = prepared_statement($dbh, $insert, array($entry_id, $liking_user));
	}
	}
	showBlog($dbh, $posting_user, $liking_user);
}

else if (isSet($_POST['followfollowing'])){
	$user1 = $_POST['followfollowing'];
	$user2 = $_POST['followfollower'];
	$insert = "insert into follows(user, following) values(?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}
else{
	$user = $_GET['user'];
	$result = ($user == $thecookie);
	if ($result == 1){
  		printBlog($dbh, $user);
	}
	else{
		showBlog($dbh, $user, $thecookie);
	}
}

?>

</body>
</html>
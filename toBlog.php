<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
$thecookie = $_COOKIE['304bloguserphp'];

if (isSet($_POST['unfollowfollowing'])){
	$user1 = $_POST['unfollowfollowing'];
	$user2 = $_POST['unfollowfollower'];
	$delete = "delete from follows where (user, following) = (?, ?)";
  	$rows = prepared_statement($dbh, $delete, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

if (isSet($_POST['followfollowing'])){
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
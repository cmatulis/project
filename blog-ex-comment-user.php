<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

// Here is where the change is:
if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}
$poster = $_COOKIE['304bloguserphp']; 
//if(isset($_POST['new_entry'])) {
  //  insertPost($dbh,$poster,$_POST['new_entry']);
//}

if (isSet($_POST['blogComment'])){
	$insert = "insert into comments(entry_id, commenting_user, comment_text) values(?, ?, ?)";
	$rows = prepared_statement($dbh, $insert, array($_POST['entryId'], $poster, htmlspecialchars($_POST['blogComment'])));
	$result = ($_POST['postAuthor'] == $poster);
	if ($result == 1){
  		printBlog($dbh, $poster);
	}
	else{
		showBlog($dbh, $_POST['postAuthor'], $poster);
	}

}
printBlog($dbh, $poster);
//printPostings($dbh);

//print "<hr>\n";

//print "<p>Hello, $poster\n";

// drop the unneeded box
?>

</body>
</html>



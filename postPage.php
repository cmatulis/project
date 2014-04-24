<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();
if (isset($_SESSION['postNum'])){
	$postNum = $_SESSION['postNum'];
}
else{
	$_SESSION['postNum'] = 0;
}

if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}
$poster = $_COOKIE['304bloguserphp'];
printPostPage();



$postType = $_GET['type'];
if ($postType == 'text'){
printCommentForm1();
}
if ($postType == 'upload'){
printUploadForm();
}

if(isset($_POST['new_entry'])) {
    insertPost($dbh,$poster,$_POST['new_entry'], $_POST['postTitle']);
}

if(isset($_POST['uploadTitle'])){
	$tmp = $_FILES['fileInput']['tmp_name'];
	$destdir = '/students/cmatulis/public_html/project/images/';
	$resultset = $dbh->query("select entry_id from blog_entry order by entry_id desc limit 1");
	while ($row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC)){
	$postNum = $row['entry_id'] + 1;
	}
	$destfilename = "$postNum";
	//$destfilename = $tmp;
	$destfile = $destdir . $destfilename;
	$url = 'http://cs.wellesley.edu/~cmatulis/project/images/' . $postNum;
	if (move_uploaded_file($tmp, $destfile)){
	insertUpload($dbh, $poster, $url, $_POST['uploadTitle'], $_POST['image_caption']);
	$_SESSION['postNum'] = $_SESSION['postNum'] + 1;
	
	}
	else {
	$cwd = getcwd();
	print "<p> cwd is $cwd";
	}
}


?>
</body>
</html>
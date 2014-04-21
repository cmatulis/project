<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
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

if(isset($_POST['fileInput'])){
	insertUpload($dbh, $poster, $_POST['fileInput'], $_POST['uploadTitle'], $_POST['image_caption']);
}

?>
</body>
</html>
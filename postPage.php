<?php
/*
 * This file contains the code that will execute when the user wants to upload a post.
 * It will print forms to allow users to upload text or image posts, and will call the functions
 * that insert these posts into the database.
**/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

// if the user is not logged in, direct them to the login page
if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}


$poster = $_COOKIE['304bloguserphp'];
printPostPage();

// the user can choose to insert a text post or image post
$postType = $_GET['type'];

// print a form to upload a text post
if ($postType == 'text'){
	printCommentForm1();
}

// print a form to upload an image post
if ($postType == 'upload'){
	printUploadForm();
}

// call the function to upload a text post
if(isset($_POST['new_entry'])) {
    insertPost($dbh,$poster,$_POST['new_entry'], $_POST['postTitle']);
}

// determine the new filename for image post that will be stored and call the
// function to insert it into the database

if(isset($_POST['uploadTitle'])){
	// the image files are stored in a folder 
	$tmp = $_FILES['fileInput']['tmp_name'];
	$destdir = '/students/cmatulis/public_html/project/images/';

	// store the image with a filename based on the entryid that it will correspond to in the database
	$resultset = $dbh->query("select entry_id from blog_entry order by entry_id desc limit 1");
	while ($row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$postNum = $row['entry_id'] + 1;
	}
	$destfilename = "$postNum";
	$destfile = $destdir . $destfilename;

	// the url where the image can be located
	$url = 'images/' . $postNum;

	// move the uploaded file into the images folder and
	// insert the image post into the database
	if (move_uploaded_file($tmp, $destfile)){
		insertUpload($dbh, $poster, $url, $_POST['uploadTitle'], $_POST['image_caption']);
	
	}
	else {
		$cwd = getcwd();
	}
}


?>
</body>
</html>
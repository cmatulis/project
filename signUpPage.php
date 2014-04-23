<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

printSignupPage();

if (isset ($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email']; 

	$user_check = query($dbh,"SELECT user FROM blog_user WHERE user='$username'"); 
	$do_usercheck = $user_check -> numRows();

	$email_check = query($dbh,"SELECT email from blog_user WHERE email='$email'");
	$do_emailcheck = $email_check -> numRows();

	if ($do_usercheck > 0) {
		echo "<p> Username is already in use!"; 
	} if ($do_emailcheck > 1) {
		echo "<p> Email is already in use!"; 
	} if (($do_usercheck == 0) && ($do_emailcheck ==0)) {
		$query = "INSERT into blog_user VALUES ('$username','$password',password('$password'),'$email')";
		$resultset = query($dbh,$query);
		if ($resultset) {
			echo "<p> You are now registered";
		}
	}

}
?>
</body>
</html>
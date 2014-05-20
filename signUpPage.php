<?php

/**
 * signUpPage.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Creates the page that will allow users to sign up for an account on our site
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    		<meta name="viewport" content="width=device-width, initial-scale=1">
    		<meta name="description" content="">
    		<meta name="author" content="">
    		<link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    		<title>Sign Up</title>

    		<!-- Bootstrap core CSS -->
    		<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

    		<!-- Custom styles for this template -->
    		<link href="bootstrap-3.1.1-dist/css/signin.css" rel="stylesheet"> 
  	</head>

  	<body>

    		<div class="container">
      			<form class="form-signin" role="form" method ="post" action = "signUpPage.php" method>
        			<h2 class="form-signin-heading">Sign Up</h2>
        				<input type="username" name="username" class="form-control" placeholder="Username" required autofocus>
        				<input type="email" name="email" class="form-control" placeholder="Email address" required>
        				<input type="password" name="password" class="form-control" placeholder="Password" required>
        				<p><button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign up</button><p>     
      			</form>
    		</div> <!-- /container -->
 

 		<?php
      	signUp($dbh);
		?>
	</body>
</html>
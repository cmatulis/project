<?php

/**
 * myprofile.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Creates a page that displays the profile of the user who is currently logged in
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if there is not a user currently logged in, redirect to the login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

$user = $_SESSION['user'];

// if the user has arrived at this page after updating their profile, update the database
	saveInfo($dbh,$user)
?> 

<!DOCTYPE html>
<html lang="en">

<?php
	printPageTop('Profile');
?>

	<div class="blog-masthead">
      		<div class="container">
        		<nav class="blog-nav">
          			<ul class="nav navbar-nav">
            				<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
            				<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
            				<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
            				<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
            				<li><a class="blog-nav-item active" href ="#">Profile</a></li>
            				<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
            				<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
          			</ul>
				<?php
					printSearchForm();
				?>
        		</nav>
      		</div>
    	</div>

    	<div class="container">
      		<div class="blog-header">
        		<?php echo "<h1 class='blog-title'>$user's Profile</h1>";
           	?>
		<p></p>
		<a href="myprofileUpdate.php" class="btn btn-primary btn-med" role="button">Change Settings</a>

      	</div>
      	<br>
      	<div class="row">
      		<div class="col-md-3"><h4><strong>Full Name</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"fullname"); ?>
      		</div>  
      	<div class="row">
      		<div class="col-md-3"><h4><strong>Birthdate</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"birthdate"); ?>
      		</div>
      <div class="row">
      		<div class="col-md-3"><h4><strong>City</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"city"); ?>
      		</div>
      <div class="row">
      		<div class="col-md-3"><h4><strong>State</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"state"); ?>
      		</div>
      <div class="row">
      		<div class="col-md-3"><h4><strong>Country</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"country"); ?>
      		</div>
      <div class="row">
      		<div class="col-md-3"><h4><strong>Interests</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"interests"); ?>
      		</div>
      <div class="row">
      		<div class="col-md-3"><h4><strong>About Me</strong></h4></div>
      			<?php echo findProfile($dbh,$user,"profile"); ?>
      		</div>  
    	</div> <!-- container -->

    	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0-rc2/js/bootstrap.min.js"></script>

</body>
</html>
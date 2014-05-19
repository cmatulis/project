<?php

/**
 * searchResults.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Creates the page that will display the results of a user's search query
 * Search results are organized by username and post content
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if the user is not logged in, redirect to the login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

$query = mysql_real_escape_string($_REQUEST['searchentry']);
?>

<!DOCTYPE html>
<html lang="en">

<?php
	printPageTop("Search Results");
?>

	<div class="blog-masthead">
      		<div class="container">
        		<nav class="blog-nav">
          			<ul class="nav navbar-nav">
            				<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
            				<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
            				<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
            				<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
            				<li><a class="blog-nav-item" href ="myprofile.php">Profile</a></li>
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
        		<h1 class="blog-title">Search Results</h1>
      		</div>
    	</div> <!-- container -->

    	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>

    	<div class="container">
      		<ul class="nav nav-pills nav-stacked col-md-2">
        		<li class="active"><a href="#posts" data-toggle="pill">Posts</a></li>
        		<li><a href="#users" data-toggle="pill">Users</a></li>
      		</ul>
      		<div class="tab-content col-md-10">
        		<div class="tab-pane active" id="posts">
          			<?php post($query,$dbh); ?> 
        		</div> <!-- tab-pane-->
        		<div class="tab-pane" id="users"> 
          			<?php user($query,$dbh); ?>
        		</div> <!-- tab-pane -->
      		</div> <!-- tab-content -->
    	</div> <!-- container --> 
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    	<!-- Include all compiled plugins (below), or include individual files as needed -->
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0-rc2/js/bootstrap.min.js"></script>

</body>
</html>
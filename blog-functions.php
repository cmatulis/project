<?php

/**
 * blog-functions.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 * 
 * Contains many of the functions that are used to update the database and generate web pages
 * associated with the site
*/

// inserts a text post into the database
function insertPost($dbh, $poster, $entry, $title){
	$insert = "INSERT INTO blog_entry(user, caption, title) VALUES (?, ?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($poster, htmlspecialchars($entry), htmlspecialchars($title)));	
}

// inserts an image upload post into the database
function insertUpload($dbh, $poster, $upload, $title, $caption){
  	$insert = "INSERT INTO blog_entry(user, entry, title, caption) VALUES (?, ?, ?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($poster, $upload, htmlspecialchars($title), htmlspecialchars($caption)));
}

// check to see if the username and password match something in the database
function loginCredentialsAreOkay($dbh, $username, $password){
  	$check = "SELECT count(*) AS n FROM blog_user WHERE binary user = ? AND binary pass=?";
    	$resultset = prepared_query($dbh, $check, array($username,$password));
    	$row = $resultset->fetchRow();
    	return( $row[0] == 1 );
}

// print the profile of a blog user (displayed in the sidebar on a user's blog)
function printUserProfile($dbh, $user){
	$profile = '';
	$profileQuery = "SELECT profile FROM profile where user = ?";
	$profileResults = prepared_query($dbh, $profileQuery, $user);
	$row = $profileResults -> fetchRow(MDB2_FETCHMODE_ASSOC);
  	$profile = $row['profile'];

	print <<<EOT
		</div><!-- /.blog-main -->  
        	<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          		<div class="sidebar-module sidebar-module-inset">
            			<h4>About</h4>
            			<p>$profile</p>
          		</div>  
        	</div><!-- /.blog-sidebar -->
      		</div><!-- /.row -->
    		</div><!-- /.container -->
EOT;
}   

// prints a form for uploading text posts
function printTextPostForm(){
print <<<EOT
		<form class="form-horizontal" method="post" action = "postPage.php?type=">  
        		<fieldset>  
          			<div class="control-group">  
            				<label class="control-label" for="input01">Title</label>  
            				<div class="controls">  
              				<input type="text" class="input-xlarge" name="postTitle" id="postTitle">   
            				</div>  
          			</div>  
          			<div class="control-group">  
            				<label class="control-label" for="textarea">Text Contents</label>  
            				<div class="controls">  
              				<textarea class="input-xlarge" name="new_entry" id="new_entry" rows="5" cols="60"></textarea>  
            				</div>  
          			</div>  
          			<div class="form-actions">  
            				<button type="submit" class="btn btn-primary">Post</button>  
          			</div>  
        		</fieldset>  
		</form>  
EOT;
}

// prints a form for uploading image files
function printUploadForm(){
print <<<EOT
		<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "postPage.php?type=">  
        	<fieldset>  
          		<div class="control-group">  
            			<label class="control-label" for="input01">Title</label>  
            				<div class="controls">  
              				<input type="text" class="input-xlarge" name = "uploadTitle" id="uploadTitle">  
            				</div>  
          		</div>  
          		<div class="control-group">  
            			<label class="control-label" for="fileInput">Select file to Upload</label> 
				<p> Files must be in gif, png, jpg, or jpeg format. </p> 
            				<div class="controls">  
              				<input class="input-file" name = "fileInput" id="fileInput" type="file">  
            				</div>  
          		</div>  
          		<div class="control-group">  
            			<label class="control-label" for="textarea">Caption</label>  
            				<div class="controls">  
              				<textarea class="input-xlarge" name = "image_caption" id="image_caption" rows="3" cols = "60"></textarea>  
            				</div>  
          		</div>  
          		<div class="form-actions">  
            			<button type="submit" class="btn btn-primary">Post</button>  
          		</div>  
        	</fieldset>  
		</form>  
EOT;
}

// determines if a like button should be displayed, and prints a comment button and like button (if necessary)
function printLikeButton($dbh, $id, $modalhrefid, $ref, $postAuthor, $value){
	error_reporting(0);
	session_start();
	$currentuser = $_SESSION['user'];

			// check to see if the current user has already liked this post
			$likedCheck = "select * from likes where entry_id = ? and liking_user = ?";
			$likedResults = prepared_query($dbh, $likedCheck, array($id, $currentuser));
			$likeResultsCheck = $likedResults -> numRows();

			// if the post belongs to the current user, do not supply a like button
			if ($likeResultsCheck == 0 & !strcmp($postAuthor, $currentuser) & $value == 1){
				print <<<EOT
					<a data-toggle="modal" href=$modalhrefid>Comment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href = "$ref">Delete</a>

EOT;
}
			else if ($likeResultsCheck == 0 & !strcmp($postAuthor, $currentuser) & $value != 1){
				print <<<EOT
					<a data-toggle="modal" href=$modalhrefid>Comment</a>
EOT;
}

			// if the post belongs to someone else and the user has not liked it, provide a like button
			else if ($likeResultsCheck == 0){
				print <<<EOT
					<p><a data-toggle="modal" href=$modalhrefid>Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <a href = "$ref">Like</a>   </p>
EOT;
			}
			
			// otherwise, the user has already liked it
			else{
				print <<<EOT
					<p><a data-toggle="modal" href=$modalhrefid>Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Liked   </p>				
EOT;
			}
}

// prints the login page
function printPageHeader() {
	printLoginForm();

	print <<<EOT
    		<div class="jumbotron">
      			<div class="container">
				<p></p>
        			<h1>Welcome!</h1>
        			<p>Poster is a blogging website.  Click below to sign up.</p>
        			<p><a href="signUpPage.php" class="btn btn-primary btn-lg" role="button">Sign Up</a>
      			</div>
    		</div>
EOT;
}

// prints the username/password form that appears at the top of the login page
function printLoginForm(){
print <<<EOT
    		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      			<div class="container">
        			<div class="navbar-header">
          				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            					<span class="sr-only">Toggle navigation</span>
            					<span class="icon-bar"></span>
            					<span class="icon-bar"></span>
            					<span class="icon-bar"></span>
          				</button>
          				<a class="navbar-brand" href="#">Poster</a>
        			</div>
      				<div class="navbar-collapse collapse">
          				<form class="navbar-form navbar-right" method = 'post' action = "blog-login.php" role="form">
            					<div class="form-group">
              					<input type="text" placeholder="Username" name = "user" id = "user" class="form-control">
            					</div>
            					<div class="form-group">
              					<input type="password" placeholder="Password" name = "pass" id="pass" class="form-control">
            					</div>
            					<button type="submit" class="btn btn-success">Sign in</button>
          				</form>
        			</div><!--/.navbar-collapse -->
      			</div>
    		</div>
EOT;
}

// prints the search form that appears in the navigation bar at the top of most pages
function printSearchForm(){
print <<<EOT
	<form class="navbar-form navbar-right" role="search" action=searchResults.php>
             	<div class="form-group">
               	<input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             	</div>
            	<button type="submit" class="btn btn-default">Submit</button>
        </form>
EOT;
}

// prints the page that appears if the user enters an incorrect username/password combination
function printIncorrectLoginPage() {
	printLoginForm();

	print <<<EOT
    		<div class="jumbotron">
      			<div class="container">
        			<h1></h1>
        				<p>Sorry, username and/or password was not correct.  Try again or click below to sign up.</p>
        				<p><a href="signUpPage.php" class="btn btn-primary btn-lg" role="button">Sign Up</a>
      			</div>
    		</div>
EOT;
}

// prints the page that appears if the user has not yet activated their account by using the link that was emailed to them
function printActivationNeeded() {
  printLoginForm();
  print <<<EOT
        <div class="jumbotron">
            <div class="container">
              <h1></h1>
                <p>You have not yet activated your account. Please check your email for an authentication link.</p>             
            </div>
        </div>
EOT;
}

// checks to see if the user has activated their email
function checkActivated($dbh, $username, $password){
	$activationQuery = "select * from blog_user where user = ? and pass = ?";
	$resultset = prepared_query($dbh, $activationQuery, array($username, $password));
	$row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC);
	$user = $row['user'];
	$activation = $row['activation'];

	// if "activation" is NULL, the user's account has been activated
	$result = ($activation == NULL);
	return $result;
}

// prints the page that appears once the user has successfully logged in
function printNext($user){
print <<<EOT
  		<div class = "jumbotron">
  			<div class = "container">
  				<h1> Welcome, $user! </h1>
  				<p> Click below to view and update your blog, or to see posts from other users </p>
			</div>
		</div>

    		<div class="container">
      			<div class="row">
        			<div class="col-md-4">
          				<h2>Your Blog</h2>
          				<p>View your blog and add new posts</p>
          				<p><a class="btn btn-default" href="blog-ex-comment-user.php" role="button">View Blog &raquo;</a></p>
        			</div>
        			<div class="col-md-4">
          				<h2>Recent Posts</h2>
          				<p>View the most recent posts from all users</p>
       				<p><a class="btn btn-default" href="viewAllPage.php" role="button">View Recent &raquo;</a></p>
       			  </div>
      			</div>

      		<hr>

      		<footer>
        		<p><a class = "blog-nav-item" href = "logoutPage.php">Logout</a></p>
      			</footer>
    		</div> <!-- /container -->
EOT;
}

// gets the necessary information about posts from the database and prints the blog entries
function displayBlog($dbh, $queryResults, $ref, $value){
 	while ($row = $queryResults -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$user = $row['user'];
		$time = $row['entered'];
		$image = $row['entry'];
		$entry = $row['caption'];
		$title = $row['title'];
		$id = $row['entry_id'];
		$hrefid = "#"."div".$id;
		$divid = "div".$id;
		$modalhrefid = "#"."modaldiv".$id;
		$modaldivid = "modaldiv".$id;
		$commentshrefid = "#"."commentsdiv".$id;
		$commentsdivid = "commentsdiv".$id;
		
		$refid = $ref."?entry_id=$id&posting_user=$user";

		printPost($title, $time, "toBlog.php?user=$user", $user, $image, $entry);
		printLikeButton($dbh, $id, $modalhrefid, $refid, $user, $value);
		printCommentModal($modaldivid, $ref, $id, $user);
		printViewComments($commentshrefid, $commentsdivid, $dbh, $id);
		printViewLikes($hrefid, $divid, $dbh, $id);
}
}

// includes the CSS and js files that are necessary for each page 
function printPageTop($title) {
print <<<EOT
		<!DOCTYPE html>
		<html lang="en">
  		<head>
    			<meta charset="utf-8">
    			<meta http-equiv="X-UA-Compatible" content="IE=edge">
    			<meta name="viewport" content="width=device-width, initial-scale=1">
    			<meta name="description" content="">
    			<meta name="author" content="">
    			<link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    			<title>$title</title>

    			<!-- Bootstrap core CSS -->
    			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

    			<!-- Custom styles for this template -->
    			<link href="jumbotron.css" rel="stylesheet">

			<!-- Custom styles for this template -->
    			<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
			<script src="bootstrap-3.1.1-dist/js/bootstrap-modal.js"></script>
  		</head>
		<body>
EOT;
}

// creates the box that appears for the users to insert comments in
function printCommentModal($modaldivid, $action, $id, $usercol){
	print <<<EOT
		<!-- Modal -->
  			<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    				<div class="modal-dialog">
      					<div class="modal-content">
        					<div class="modal-header">
          						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          						<h4 class="modal-title">Comment</h4>
        					</div>
        					<div class="modal-body">
							<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = $action>  
          							<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
								<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
        					</div>
        					<div class="modal-footer">
          						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          						<button type="submit" class="btn btn-primary">Submit Comment</button>
        					</div>
							</form>
      					</div><!-- /.modal-content -->
    				</div><!-- /.modal-dialog -->
  			</div><!-- /.modal -->
EOT;
}

// displays comments that users have made on a post
function printViewComments($commentshrefid, $commentsdivid, $dbh, $id){
print <<<EOT
	<div class="panel-group" id="accordion">
  		<div class="panel panel-default">
    			<div class="panel-heading">
      				<h4 class="panel-title">
        				<a data-toggle="collapse" data-parent="#accordion" href=$commentshrefid>
          					View Comments
        				</a>
      				</h4>
    			</div>
    		<div id=$commentsdivid class="panel-collapse collapse">
      	<div class="panel-body">
EOT;
	// get the comments that correspond to a particular post
	$getComments = "select * from comments where entry_id = ? order by date(comment_time) desc, time(comment_time) desc";
	$commentsResults = prepared_query($dbh, $getComments, $id);
	while ($row = $commentsResults -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$comment_text = $row['comment_text'];
		$commenting_user = $row['commenting_user'];
		print <<<EOT
       		<p><a href="toBlog.php?user=$commenting_user">$commenting_user</a> said: $comment_text </p>
EOT;
}
print <<<EOT
      							</div>
    						</div>
  					</div>
				</div>
EOT;
}

// displays a blog post
function printPost($title, $time, $ref, $usercol, $image, $entry){
print <<<EOT
          		<div class="blog-post">
            			<h2 class="blog-post-title">$title</h2>
            			<p class="blog-post-meta">$time by <a href="$ref">$usercol</a></p>
  				<p> <img class = 'img-responsive' src = '$image'> </p>
            			<p> $entry </p> 
EOT;


}
// prints the top of each user's blog, which simply displays the user's username
function printBlogTop($user){
print <<<EOT
        			</nav>
      			</div>
    		</div>
    		<div class="container">
      			<div class="blog-header">
        			<h1 class="blog-title">$user</h1>
      			</div>
      			<div class="row">
      			<div class="col-sm-8 blog-main">
EOT;
}

// display the users that have liked a post
function printViewLikes($hrefid, $divid, $dbh, $id){
	print <<<EOT
  		<div class="panel-group" id="accordion2">
			<div class="panel panel-default">
    				<div class="panel-heading">
      					<h4 class="panel-title">
        					<a data-toggle="collapse" data-parent="#accordion2" href=$hrefid>
          						View Likes
        					</a>
      					</h4>
    				</div>
    			<div id=$divid class="panel-collapse collapse">
      		<div class="panel-body">
EOT;
	// get the names of the users who have liked the post
	$getLikes = "select * from likes where entry_id = ? order by date(like_time) desc, time(like_time) desc";
	$likesResults = prepared_query($dbh, $getLikes, $id);
	while ($row = $likesResults -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$likinguser = $row['liking_user'];
		print <<<EOT
			<p><a href="toBlog.php?user=$likinguser">$likinguser</a> liked this </p>
EOT;
	}
print <<<EOT
      							</div>
    						</div>
  					</div>
				</div>		
            			<hr>
				</div>
EOT;
}

// prints the blog of the user who is currently logged in
function printBlog($dbh, $user){
	printPageTop('Blog');
	print <<<EOT
    		<div class="blog-masthead">
       		<div class="container">
         			<nav class="blog-nav">
           				<ul class="nav navbar-nav">
             					<li><a class="blog-nav-item active" href="#">Blog</a></li>
             					<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
             					<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
             					<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
             					<li><a class="blog-nav-item" href ="myprofile.php">Profile</a></li>
             					<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
             					<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
           				</ul>
EOT;
printSearchForm();
printBlogTop($user);

	// get all of the posts that were created by the currently logged-in user and display their blog
  	$preparedquery = "SELECT * from blog_entry where user = ? order by date(entered) desc, time(entered) desc";
	$resultset = prepared_query($dbh, $preparedquery, $user);

	displayBlog($dbh, $resultset, "blog-ex-comment-user.php", 1);
	printUserProfile($dbh, $user);
	printBlogFooter();
}

// print the page where the user can choose whether the type of post they will upload
function printPostPage(){
	printPageTop('Post');
	print <<<EOT
    		<div class="blog-masthead">
       		<div class="container">
         			<nav class="blog-nav">
           				<ul class="nav navbar-nav">
             					<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
             					<li><a class="blog-nav-item active" href = "postPage.php?type=">Post</a></li>
             					<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
             					<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
             					<li><a class="blog-nav-item" href ="myprofile.php">Profile</a></li>
             					<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
             					<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
           				</ul>
EOT;
					printSearchForm();
print <<<EOT
        			</nav>
      			</div>
    		</div>

EOT;
	print <<<EOT
    		<div class="container">
			<div class="blog-header">
        			<p class="lead blog-description">Select the type of post, and then submit your new post to your blog.</p>
      			</div>
			<a href="postPage.php?type=text" class="btn btn-default btn-med" role="button"><span class="glyphicon glyphicon-font"></span> Text</a>
			<a href="postPage.php?type=upload" class="btn btn-default btn-med" role="button"><span class="glyphicon glyphicon-upload"></span> Upload</a>
EOT;
}

// print the page that displays recent posts from all users
function printAllPosts($dbh){
	printPageTop('Recent');
	print <<<EOT
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
EOT;
					printSearchForm();
print <<<EOT
        			</nav>
      			</div>
    		</div>

		<div class="container">
      			<div class="row">
				<div class="col-sm-8 blog-main">
 					<div class="blog-header">
        					<p class="lead blog-description">The most recent posts from all users.</p>
      					</div>
EOT;


	// get the most recent 20 blog posts from all users to display
  	$preparedquery = "SELECT * from blog_entry ORDER BY entered DESC LIMIT 20";
	$allPosts = query($dbh, $preparedquery);

	displayBlog($dbh, $allPosts, "viewAllPage.php", 0);
print <<<EOT
		</div><!-- /.blog-main -->  
      		</div><!-- /.row -->
    		</div><!-- /.container -->
EOT;
printBlogFooter();
}

// prints the blog of a user who is not the currently-logged-in user
function showBlog($dbh, $user, $user2){
	printPageTop('Blog');
	print <<<EOT
		<div class="blog-masthead">
       		<div class="container">
         			<nav class="blog-nav">
           				<ul class="nav navbar-nav">
             					<li><a class="blog-nav-item active" href="toBlog.php?user=$user">Blog</a></li>
                  				<li><a class="blog-nav-item" href ="userprofile.php?user=$user">Profile</a></li>
             					<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
             					<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
           				</ul>
EOT;
printSearchForm();
print <<<EOT
      			</div>
    		</div>

EOT;
	$result = 0;
	
	// get all of the users the currently logged-in user is following, to print the 
	// follow/un-follow buttons on the page
	$preparedquery = "SELECT following FROM follows where user = ?";
	$resultset = prepared_query($dbh, $preparedquery, $user2);

	// the current user may be following many users; go through them and if you find that they are following the one that
	// corresponds to this blog, break from the loop
 	while ($row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$following = $row['following'];
		$result = ($following == $user);
		if ($result == 1){
			break;
		}
	}

	if ($result == 1){
	// the user is currently following this blog; print an un-follow button
print <<<EOT
	<div class="container">
      				<div class="blog-header">
      				</div>

				<form class="navbar-form navbar-left" method = 'post' action = "toBlog.php" role="form">
            				<div class="form-group">
              				<a href="" class="btn btn-default btn-med disabled" role="button"><span class="glyphicon glyphicon-ok"></span> Following</a>
            				</div>
            				<div class="form-group">
						<input type="hidden" value=$user name = "unfollowfollowing" id="unfollowfollowing" class="form-control">
						<input type="hidden" value=$user2 name = "unfollowfollower" id="unfollowfollower" class="form-control">
            				</div>
            				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Un-Follow</button>
          			</form>
EOT;
	}
	else{
	// the user is not currently following this blog; print a follow button
print <<<EOT
	<div class="container">
				<div class="blog-header">
      				</div>
			<form class="navbar-form navbar-left" method = 'post' action = "toBlog.php" role="form">
            			<div class="form-group">
              			<a href="" class="btn btn-default btn-med disabled" role="button"><span class="glyphicon glyphicon-minus"></span> Not Following</a>
            			</div>
            			<div class="form-group">
					<input type="hidden" value=$user name = "followfollowing" id="followfollowing" class="form-control">
					<input type="hidden" value=$user2 name = "followfollower" id="followfollower" class="form-control">
            			</div>
            			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Follow</button>
          		</form>
EOT;
	}
	printBlogTop($user);

	// get all of the blog posts from this user
  	$postsQuery = "SELECT * from blog_entry where user = ?  order by date(entered) desc, time(entered) desc";
	$postsResults = prepared_query($dbh, $postsQuery, $user);

	displayBlog($dbh, $postsResults, "toBlog.php", 0);
	printUserProfile($dbh, $user);
	printBlogFooter();
}


// prints a page showing the users that are currently following you
function printFollowersPage($dbh, $user){
	printPageTop('Followers');
print <<<EOT
	<div class="blog-masthead">
       	<div class="container">
         		<nav class="blog-nav">
           			<ul class="nav navbar-nav">
             				<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
             				<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
             				<li><a class="blog-nav-item active" href="#">Followers</a></li>
             				<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
             				<li><a class="blog-nav-item" href ="myprofile.php">Profile</a></li>
             				<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
             				<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
           			</ul>
EOT;
				printSearchForm();
print <<<EOT
        		</nav>
      		</div>
    	</div>
EOT;
print <<<EOT
    	<div class="container">
      		<div class="blog-header">
        		<h1 class="blog-title">$user</h1>
        		<p class="lead blog-description">Here are the users that are following you.</p>
      		</div>
      		<div class="row">
			<div class="col-sm-8 blog-main">
EOT;

	// get and display the users who are following this user
  	$getFollowers = "SELECT user FROM follows where following = ?";
	$followersResults = prepared_query($dbh, $getFollowers, $user);
 	while ($row = $followersResults -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$follower = $row['user'];
print <<<EOT
		<div class="blog-post">
            		<p class="blog-post-meta"><a href="toBlog.php?user=$follower">$follower</a></p>
            		<hr>
 		</div>   
EOT;
	 }
print <<<EOT
		</div><!-- /.blog-main -->  
    		</div><!-- /.container -->
EOT;
printBlogFooter();
}

// prints the page footer that gives credit to Bootstrap for the templates
function printBlogFooter(){
print <<<EOT
	<div class="blog-footer">
      		<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      		<p>
        		<a href="#">Back to top</a>
      		</p>
    	</div>
EOT;
}

// prints the page displaying the users that you are currently following
function printFollowingPage($dbh, $user){
	printPageTop('Following');
print <<<EOT
	<div class="blog-masthead">
       	<div class="container">
         		<nav class="blog-nav">
           			<ul class="nav navbar-nav">
             				<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
             				<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
             				<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
             				<li><a class="blog-nav-item active" href="#">Following</a></li>
             				<li><a class="blog-nav-item" href ="myprofile.php">Profile</a></li>
             				<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
             				<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
           			</ul>
EOT;
				printSearchForm();
print <<<EOT
        		</nav>
      		</div>
    </div>

EOT;
print <<<EOT
    	<div class="container">
      		<div class="blog-header">
        		<h1 class="blog-title">$user</h1>
        		<p class="lead blog-description">Here are the users that you are following.</p>
      		</div>

      		<div class="row">
			<div class="col-sm-8 blog-main">
EOT;

	// Get a list of users that you are currently following and display on page
  	$getFollowing = "SELECT following FROM follows where user = ?";
	$followingResults = prepared_query($dbh, $getFollowing, $user);
 	while ($row = $followingResults -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$following = $row['following'];	
print <<<EOT
        
          	<div class="blog-post">
            		<p class="blog-post-meta"><a href="toBlog.php?user=$following">$following</a></p>
            		<hr>
		</div>    
EOT;
	 }

print <<<EOT
		</div><!-- /.blog-main -->  
    		</div><!-- /.container -->
EOT;

printBlogFooter();
}

// print the sign up page and add new users to the database
function signUp($dbh){
	if (isset ($_POST['username']) && isset($_POST['password'])) {
    		$username = htmlspecialchars($_POST['username']);
    		$password = htmlspecialchars($_POST['password']);
    		$email = $_POST['email']; 

		// users are not allowed to have the same username or email as another user
    		$user_check = query($dbh,"SELECT user FROM blog_user WHERE user='$username'"); 
    		$do_usercheck = $user_check -> numRows();

    		$email_check = query($dbh,"SELECT email from blog_user WHERE email='$email'");
    		$do_emailcheck = $email_check -> numRows();

    		echo '<div class="container"><center>';
     
		// inform the user if they need to use a different email or password
		// otherwise, insert the user into the database
    		if ($do_usercheck > 0) {
      			echo "<h4> Username is already in use!</h4>"; 
    		} if ($do_emailcheck > 0) {
      			echo "<h4> Email is already in use!</h4>"; 
    		} if (($do_usercheck == 0) && ($do_emailcheck ==0)) {
      			//unique activation code
      			$activation = md5(uniqid(rand(),true)); 

      			//password crypt
      			$crypt = crypt($password);

      			$preparedquery = "INSERT into blog_user VALUES (?,?,?,?,?)";
      			$resultset = prepared_query($dbh,$preparedquery,array($username,$password,$crypt,$email,$activation)); 

      			$profilequery = "INSERT into profile VALUES (?,?,?,?,?,?,?,?)";
      			$resultset2 = prepared_query($dbh,$profilequery,array($username,NULL,NULL,NULL,NULL,NULL,NULL,NULL));

			// send the user an email that will allow them to activate their account
      			if ($resultset) {
        			//mail message
        			$message = " To activate your account, please click on this link:\n\n";
        			$message .= 'cs.wellesley.edu/~cmatulis/project/activate.php?email=' . urlencode($email) . "&key=$activation";
	 			error_reporting(E_ERROR | E_PARSE);
        			mail($email, 'Registration Confirmation', $message, 'From: slee14@wellesley.edu');
        			echo "<h4> You are now registered. Go to your email and click on the activation link to start blogging.</h4>";
      			}
    		}
    echo "</center></div>";
  }
}

// search for posts
function post($query,$dbh) {
  	$self = $_SERVER['PHP_SELF']; 

	// search for posts that match the user's query
  	$preparedquery = "SELECT * FROM blog_entry WHERE caption LIKE ? OR title LIKE ?"; 
  	$resultset = prepared_query($dbh,$preparedquery,array("%$query%","%$query%")); 
  	$size = $resultset -> numRows();
  	if ($size === 0) {
    		echo "<h2>No Posts Found</h2>";
  	} else {
      		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        		$user = $row['user'];
        		$title = $row['title'];
        		$time = $row['entered'];
        		$image = $row['entry'];
        		$entry = $row['caption'];

			// display matching posts, if any
        		echo "
        			<div class='blog-post'>
                			<h2 class='blog-post-title'>$title</h2>
                			<p class='blog-post-meta'>$time by <a href='toBlog.php?user=$user'>$user</a></p>
          				<p> <img class = 'img-responsive' src='$image'> </p>
                			<p> $entry </p> 
                			<hr>
         			</div> <!-- blog-post> 
    
      			";
      		}
  	}
}

// search for users
function user($query,$dbh) {
  	$self = $_SERVER['PHP_SELF'];
  	$preparedquery = "SELECT user from blog_user WHERE user LIKE ?"; 
  	$resultset = prepared_query($dbh,$preparedquery,"%$query%");

  	$size = $resultset -> numRows(); 
  	if ($size === 0) {
    		echo "<h2>No Users Found</h2>";
  	} else {
    		echo "
    		<div class='blog-post'>
    		";  
    		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
      			$user = $row['user'];
      			echo "<h2><a href='toBlog.php?user=$user'>$user</a></h2>";   
    		}
    		echo "</div>"; //<!-- blog-post> 
  	}
}

// search by profile
function findProfile($dbh,$user,$query) {
	$preparedquery = "SELECT $query FROM profile WHERE user = ?"; 
  	$resultset = prepared_query($dbh,$preparedquery,$user); 
  	$row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC);
  	$row2 = $row[$query];
  	$size = $resultset -> numRows();
  	if ($size > 0) {
    		echo "
      		<div class='col-md-8'><h4>$row2</h4></div>"; 
  	} else { 
      		echo "";
    }
}

// save the user's updated profile information
function saveInfo($dbh,$user) {
	if (isset($_POST['birthdate'])) {
  		$fullname = htmlspecialchars($_POST['fullname']);
  		$birthdate = htmlspecialchars($_POST['birthdate']);
  		$city = htmlspecialchars($_POST['city']);
  		$state = htmlspecialchars($_POST['state']);
  		$country = htmlspecialchars($_POST['country']);
  		$interests = htmlspecialchars($_POST['interests']);
  		$profile = htmlspecialchars($_POST['aboutme']);

		// update the database
    		prepared_query($dbh,"UPDATE profile SET fullname=? WHERE user= ?", array($fullname, $user)); 
   		prepared_query($dbh,"UPDATE profile SET birthdate=? WHERE user= ?", array($birthdate, $user)); 
    		prepared_query($dbh,"UPDATE profile SET city=? WHERE user= ?", array($city, $user)); 
    		prepared_query($dbh,"UPDATE profile SET state=? WHERE user= ?", array($state, $user)); 
  		prepared_query($dbh,"UPDATE profile SET country=? WHERE user= ?", array($country, $user)); 
  		prepared_query($dbh,"UPDATE profile SET interests=? WHERE user= ?", array($interests, $user)); 
  		prepared_query($dbh,"UPDATE profile SET profile=? WHERE user= ?", array($profile, $user)); 
  	}
}

?>

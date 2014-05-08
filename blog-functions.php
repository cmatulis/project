<?php
  // Database operations


function insertPost($dbh, $poster, $entry, $title){
	$insert = "INSERT INTO blog_entry(user, caption, title) VALUES (?, ?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($poster, $entry, $title));
}

function insertUpload($dbh, $poster, $upload, $title, $caption){
  	$insert = "INSERT INTO blog_entry(user, entry, title, caption) VALUES (?, ?, ?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($poster, $upload, $title, $caption));
}

function printPostings($dbh){
  	echo "<P> Here are the five most recent postings within the last hour:";
  	$resultset = $dbh->query("SELECT time(entered) as time, user, entry FROM blog_entry WHERE timestampdiff(minute, entered, now())<60 ORDER BY entered DESC LIMIT 5");
  	//Get all the blog entries, including, presumably, the one just added, if any
  	echo "<dl>\n";
  	while ($row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC)){
    		echo "<dt>" .$row['user'] . " at " .$row['time'] . "</dt><dd>" . $row['entry'] . "</dd>\n";
  	}
  	echo "</dl>\n";
}

function loginCredentialsAreOkay($dbh, $username, $password){
  	$check = "SELECT count(*) AS n FROM blog_user WHERE user = ? AND pass=?";
    	$resultset = prepared_query($dbh, $check, array($username,$password));
    	$row = $resultset->fetchRow();
    	return( $row[0] == 1 );
}
    
// ================================================================
// printing stuff

// This function prints a one-input form:  just the comment box

function printCommentForm1()
{
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

function printUploadForm()
{
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


// This function prints a two-input form:  the poster box and the comment box


function printPageHeader() {
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
          				<form class="navbar-form navbar-right" method = 'post' action = "blog-ex-login-user.php" role="form">
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
    
		<!-- Main jumbotron for a primary marketing message or call to action -->
    		<div class="jumbotron">
      			<div class="container">
        			<h1>Welcome!</h1>
        			<p>Poster is a blogging website.  Click below to sign up.</p>
        			<p><a href="signUpPage.php" class="btn btn-primary btn-lg" role="button">Sign Up</a>
      			</div>
    		</div>
EOT;
}

function printPageHeader2() {
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
          				<form class="navbar-form navbar-right" method = 'post' action = "blog-ex-login-user.php" role="form">
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
		<!-- Main jumbotron for a primary marketing message or call to action -->
    		<div class="jumbotron">
      			<div class="container">
        			<h1></h1>
        				<p>Sorry, username and/or password was not correct.  Try again or click below to sign up.</p>
        				<p><a href="signUpPage.php" class="btn btn-primary btn-lg" role="button">Sign Up</a>
      			</div>
    		</div>
EOT;
}

function printNext($user){
print <<<EOT
  		<div class = "jumbotron">
  			<div class = "container">
  				<h1> Welcome, $user! </h1>
  				<p> Click below to view and update your blog, or to see posts from other users </p>
			</div>
		</div>

    		<div class="container">
      			<!-- Example row of columns -->
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


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
EOT;
}


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

    			<title>Poster</title>

    			<!-- Bootstrap core CSS -->
    			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

    			<!-- Custom styles for this template -->
    			<link href="jumbotron.css" rel="stylesheet">

    			<!-- Just for debugging purposes. Don''t actually copy this line! -->
    			<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    			<!--[if lt IE 9]>
      				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    			<![endif]-->
  		</head>
		<body>
EOT;
}

function printBlog($dbh, $user){
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

    			<title>Blog</title>

    			<!-- Bootstrap core CSS -->
    			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

			<!-- Custom styles for this template -->
    			<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    			<!-- Just for debugging purposes. Don''t actually copy this line! -->
    			<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    			<!--[if lt IE 9]>
      			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    			<![endif]-->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
			<script src="bootstrap-3.1.1-dist/js/bootstrap-modal.js"></script>
				  
  		</head>

  		<body>

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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title">$user</h1>
        <p class="lead blog-description">Blog description goes here</p>
      </div>
      <div class="row">
      <div class="col-sm-8 blog-main">
EOT;
	$profile = '';
	$preparedquery1 = "SELECT profile FROM profile where user = ?";
	$resultset1 = prepared_query($dbh, $preparedquery1, $user);

	while ($row1 = $resultset1 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
  		$profile = $row1['profile'];
	}

  	$preparedquery2 = "SELECT * from blog_entry where user = ? order by date(entered) desc, time(entered) desc";
  	//Get all the blog entries, including, presumably, the one just added, if any
	$resultset2 = prepared_query($dbh, $preparedquery2, $user);
	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$usercol = $row2['user'];
		$time = $row2['entered'];
		$image = $row2['entry'];
		$entry = $row2['caption'];
		$title = $row2['title'];
		$id = $row2['entry_id'];
		$hrefid = "#"."div".$id;
		$divid = "div".$id;
		$modalhrefid = "#"."modaldiv".$id;
		$modaldivid = "modaldiv".$id;
		$commentshrefid = "#"."commentsdiv".$id;
		$commentsdivid = "commentsdiv".$id;
    		if (!strcmp($usercol, $user)){  
print <<<EOT
          			<div class="blog-post">
            				<h2 class="blog-post-title">$title</h2>
            				<p class="blog-post-meta">$time by <a href="#">$usercol</a></p>
					<p> <img src='$image'> </p>
            				<p> $entry </p> 
					<a data-toggle="modal" href=$modalhrefid>Comment</a>

  					<!-- Modal -->
  					<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    						<div class="modal-dialog">
      							<div class="modal-content">
        							<div class="modal-header">
          								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          								<h4 class="modal-title">Comment</h4>
        							</div>
        							<div class="modal-body">
								<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "blog-ex-comment-user.php">  
          								<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
									<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
								       <input type="hidden" value=$usercol name = "postAuthor" id="postAuthor" class="form-control">
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
$preparedquery3 = "select * from comments where entry_id = ? order by date(comment_time) desc, time(comment_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$comment_text = $row3['comment_text'];
		$commenting_user = $row3['commenting_user'];
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
						$preparedquery3 = "select * from likes where entry_id = ? order by date(like_time) desc, time(like_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$likinguser = $row3['liking_user'];
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
	}
print <<<EOT
		</div><!-- /.blog-main -->  
        	<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          		<div class="sidebar-module sidebar-module-inset">
            			<h4>About</h4>
            			<p>$profile</p>
          		</div>
          		<div class="sidebar-module">
            			<h4>Archives</h4>
            			<ol class="list-unstyled">
              			<li><a href="#">January 2014</a></li>
              			<li><a href="#">December 2013</a></li>
              			<li><a href="#">November 2013</a></li>
              			<li><a href="#">October 2013</a></li>
              			<li><a href="#">September 2013</a></li>
              			<li><a href="#">August 2013</a></li>
              			<li><a href="#">July 2013</a></li>
              			<li><a href="#">June 2013</a></li>
              			<li><a href="#">May 2013</a></li>
              			<li><a href="#">April 2013</a></li>
              			<li><a href="#">March 2013</a></li>
              			<li><a href="#">February 2013</a></li>
            			</ol>
          		</div>
        
        	</div><!-- /.blog-sidebar -->

      		</div><!-- /.row -->

    		</div><!-- /.container -->

    		<div class="blog-footer">
      			<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      			<p>
        			<a href="#">Back to top</a>
      			</p>
    		</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
EOT;
}

function printPostPage(){
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

    			<title>Post</title>

    			<!-- Bootstrap core CSS -->
    			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

			<!-- Custom styles for this template -->
    			<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    			<!-- Just for debugging purposes. Don''t actually copy this line! -->
    			<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    			<!--[if lt IE 9]>
      			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    			<![endif]-->
				  
  		</head>

  		<body>

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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
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


function printAllPosts($dbh){
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

    			<title>Recent</title>

    			<!-- Bootstrap core CSS -->
    			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
			

			<!-- Custom styles for this template -->
    			<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    			<!-- Just for debugging purposes. Don''t actually copy this line! -->
    			<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    			<!--[if lt IE 9]>
      			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    			<![endif]-->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
				  
  		</head>

  		<body>

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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
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

  	$resultset2 = $dbh->query("SELECT * from blog_entry ORDER BY entered DESC LIMIT 20");
  	//Get all the blog entries, including, presumably, the one just added, if any
 	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$user = $row2['user'];
		$time = $row2['entered'];
		$image = $row2['entry'];
		$entry = $row2['caption'];
		$title = $row2['title'];
		$id = $row2['entry_id'];
		$hrefid = "#"."div".$id;
		$divid = "div".$id;
		$modalhrefid = "#"."modaldiv".$id;
		$modaldivid = "modaldiv".$id;
		$commentshrefid = "#"."commentsdiv".$id;
		$commentsdivid = "commentsdiv".$id;
print <<<EOT
          		<div class="blog-post">
            		<h2 class="blog-post-title">$title</h2>
            		<p class="blog-post-meta">$time by <a href="toBlog.php?user=$user">$user</a></p>
  			<p> <img src='$image'></p>
            		<p> $entry </p> 
EOT;
$currentuser = $_COOKIE['304bloguserphp'];
			$preparedquery4 = "select * from likes where entry_id = ? and liking_user = ?";
			$resultset4 = prepared_query($dbh, $preparedquery4, array($id, $currentuser));
			$resultset4check = $resultset4 -> numRows();
			if ($resultset4check == 0 & !strcmp($user, $currentuser)){
	print <<<EOT
				<a data-toggle="modal" href=$modalhrefid>Comment</a>

  					<!-- Modal -->
  					<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    						<div class="modal-dialog">
      							<div class="modal-content">
        							<div class="modal-header">
          								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          								<h4 class="modal-title">Comment</h4>
        							</div>
        							<div class="modal-body">
								<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "viewAllPage.php">  
          								<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
									<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
								       <input type="hidden" value=$user name = "postAuthor" id="postAuthor" class="form-control">
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
else if ($resultset4check == 0){
	print <<<EOT
			<p><a data-toggle="modal" href=$modalhrefid>Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <a href = "toBlog.php?entry_id=$id&posting_user=$user">Like</a>   </p>

  					<!-- Modal -->
  					<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    						<div class="modal-dialog">
      							<div class="modal-content">
        							<div class="modal-header">
          								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          								<h4 class="modal-title">Comment</h4>
        							</div>
        							<div class="modal-body">
								<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "toBlog.php">  
          								<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
									<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
								       <input type="hidden" value=$user name = "postAuthor" id="postAuthor" class="form-control">
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

			else{
print <<<EOT
				<p><a data-toggle="modal" href=$modalhrefid>Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Liked   </p>
				<!-- Modal -->
  					<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    						<div class="modal-dialog">
      							<div class="modal-content">
        							<div class="modal-header">
          								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          								<h4 class="modal-title">Comment</h4>
        							</div>
        							<div class="modal-body">
								<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "toBlog.php">  
          								<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
									<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
								       <input type="hidden" value=$user name = "postAuthor" id="postAuthor" class="form-control">
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
$preparedquery3 = "select * from comments where entry_id = ? order by date(comment_time) desc, time(comment_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$comment_text = $row3['comment_text'];
		$commenting_user = $row3['commenting_user'];
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
print <<<EOT
					<div class="panel-group" id="accordion">

  				<div class="panel panel-default">
    					<div class="panel-heading">
      						<h4 class="panel-title">
        						<a data-toggle="collapse" data-parent="#accordion" href=$hrefid>
          							View Likes
        						</a>
      						</h4>
    					</div>
    					<div id=$divid class="panel-collapse collapse">
      						<div class="panel-body">
EOT;
$preparedquery3 = "select * from likes where entry_id = ? order by date(like_time) desc, time(like_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$likinguser = $row3['liking_user'];
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
	

print <<<EOT
		</div><!-- /.blog-main -->  
      		</div><!-- /.row -->

    		</div><!-- /.container -->

    		<div class="blog-footer">
      			<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      			<p>
        			<a href="#">Back to top</a>
      			</p>
    		</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
EOT;
}

function showBlog($dbh, $user, $user2){
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
    			<title>Blog</title>

    			<!-- Bootstrap core CSS -->
   			<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

			<!-- Custom styles for this template -->
    			<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    			<!-- Just for debugging purposes. Don''t actually copy this line! -->
    			<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    			<!--[if lt IE 9]>
      			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    			<![endif]-->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
				  
  		</head>

  		<body>
			    
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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </nav>
      </div>
    </div>

EOT;
	$result = 0;
	$preparedquery2 = "SELECT following FROM follows where user = ?";
	$msg = "button0";
  	//Get all the blog entries, including, presumably, the one just added, if any
	$resultset2 = prepared_query($dbh, $preparedquery2, $user2);
 	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$following = $row2['following'];
		$result = ($following == $user);
		if ($result == 1){
			break;
		}
	}

	if ($result == 1){
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
print <<<EOT
    		<div class="container">
      			<div class="blog-header">
        			<h1 class="blog-title">$user</h1>
        			<p class="lead blog-description">Blog description goes here</p>
      			</div>
      			<div class="row">
				<div class="col-sm-8 blog-main">
EOT;
	$profile = '';
	$preparedquery1 = "SELECT profile FROM profile where user = ?";
	$resultset1 = prepared_query($dbh, $preparedquery1, $user);
	while ($row1 = $resultset1 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
  		$profile = $row1['profile'];
	}

  	$preparedquery2 = "SELECT * from blog_entry where user = ?  order by date(entered) desc, time(entered) desc";
  	//Get all the blog entries, including, presumably, the one just added, if any
	$resultset2 = prepared_query($dbh, $preparedquery2, $user);
 	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$usercol = $row2['user'];
		$time = $row2['entered'];
		$image = $row2['entry'];
		$entry = $row2['caption'];
		$title = $row2['title'];
		$id = $row2['entry_id'];
		$hrefid = "#"."div".$id;
		$divid = "div".$id; 
		$modalhrefid = "#"."modaldiv".$id;
		$modaldivid = "modaldiv".$id;
		$commentshrefid = "#"."commentsdiv".$id;
		$commentsdivid = "commentsdiv".$id;   
print <<<EOT
          		<div class="blog-post">
            			<h2 class="blog-post-title">$title</h2>
            			<p class="blog-post-meta">$time by <a href="#">$usercol</a></p>
  				<p> <img src = '$image'> </p>
            			<p> $entry </p> 
EOT;
$currentuser = $_COOKIE['304bloguserphp'];
			$preparedquery4 = "select * from likes where entry_id = ? and liking_user = ?";
			$resultset4 = prepared_query($dbh, $preparedquery4, array($id, $currentuser));
			$resultset4check = $resultset4 -> numRows();
			if ($resultset4check == 0){
	print <<<EOT
			<p><a href = "#">Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <a href = "toBlog.php?entry_id=$id&posting_user=$usercol">Like</a>   </p>
EOT;
}
			else{
print <<<EOT
				<p><a data-toggle="modal" href=$modalhrefid>Comment</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Liked   </p>

  					<!-- Modal -->
  					<div class="modal fade" id=$modaldivid tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    						<div class="modal-dialog">
      							<div class="modal-content">
        							<div class="modal-header">
          								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          								<h4 class="modal-title">Comment</h4>
        							</div>
        							<div class="modal-body">
								<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "toBlog.php?user=$usercol">  
          								<textarea name="blogComment" id = "blogComment" class="input-xlarge" rows="5" cols="60"></textarea>
									<input type="hidden" value=$id name = "entryId" id="entryId" class="form-control">
								       <input type="hidden" value=$user name = "postAuthor" id="postAuthor" class="form-control">
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
$preparedquery3 = "select * from comments where entry_id = ? order by date(comment_time) desc, time(comment_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$comment_text = $row3['comment_text'];
		$commenting_user = $row3['commenting_user'];
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
print <<<EOT
				<div class="panel-group" id="accordion">

  					<div class="panel panel-default">
    						<div class="panel-heading">
      							<h4 class="panel-title">
        							<a data-toggle="collapse" data-parent="#accordion" href=$hrefid>
          								View Likes
        							</a>
      							</h4>
    						</div>
    						<div id=$divid class="panel-collapse collapse">
      							<div class="panel-body">
EOT;
$preparedquery3 = "select * from likes where entry_id = ? order by date(like_time) desc, time(like_time) desc";
						$resultset3 = prepared_query($dbh, $preparedquery3, $id);
							while ($row3 = $resultset3 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$likinguser = $row3['liking_user'];
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
print <<<EOT
			</div><!-- /.blog-main -->  
        		<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          			<div class="sidebar-module sidebar-module-inset">
            				<h4>About</h4>
            				<p>$profile</p>
          			</div>
          			<div class="sidebar-module">
            				<h4>Archives</h4>
            				<ol class="list-unstyled">
              				<li><a href="#">January 2014</a></li>
              				<li><a href="#">December 2013</a></li>
              				<li><a href="#">November 2013</a></li>
              				<li><a href="#">October 2013</a></li>
              				<li><a href="#">September 2013</a></li>
              				<li><a href="#">August 2013</a></li>
              				<li><a href="#">July 2013</a></li>
              				<li><a href="#">June 2013</a></li>
              				<li><a href="#">May 2013</a></li>
              				<li><a href="#">April 2013</a></li>
             				 	<li><a href="#">March 2013</a></li>
              				<li><a href="#">February 2013</a></li>
            				</ol>
          			</div>
        
        		</div><!-- /.blog-sidebar -->

      			</div><!-- /.row -->

    			</div><!-- /.container -->

    			<div class="blog-footer">
      				<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      				<p>
        				<a href="#">Back to top</a>
      				</p>
    			</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
EOT;
}

function printFollowersPage($dbh, $user){
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

    		<title>Followers</title>

    		<!-- Bootstrap core CSS -->
    		<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
    		<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    		<!-- Just for debugging purposes. Don''t actually copy this line! -->
    		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->


    		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    		<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    		<![endif]-->
				  
  	</head>

  	<body>
			    
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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
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

	$profile = '';
	$preparedquery1 = "SELECT profile FROM profile where user = ?";
	$resultset1 = prepared_query($dbh, $preparedquery1, $user);
	while ($row1 = $resultset1 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
  		$profile = $row1['profile'];
	}

  	$preparedquery2 = "SELECT user FROM follows where following = ?";
  	//Get all the blog entries, including, presumably, the one just added, if any
	$resultset2 = prepared_query($dbh, $preparedquery2, $user);
 	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$follower = $row2['user'];
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

    		<div class="blog-footer">
      			<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      			<p>
        			<a href="#">Back to top</a>
      			</p>
    		</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>


EOT;
}

function printFollowingPage($dbh, $user){
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

    		<title>Following</title>

    		<!-- Bootstrap core CSS -->
    		<link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom styles for this template -->
    		<link href="bootstrap-3.1.1-dist/css/blog.css" rel="stylesheet"> 
				  
    		<!-- Just for debugging purposes. Don''t actually copy this line! -->
    		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    		<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    		<![endif]-->
				  
  	</head>

  	<body>
			    
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
           <form class="navbar-form navbar-right" role="search" action=searchResults.php>
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Search" name="searchentry" required>
             </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
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
	$profile = '';
	$preparedquery1 = "SELECT profile FROM profile where user = ?";
	$resultset1 = prepared_query($dbh, $preparedquery1, $user);
	while ($row1 = $resultset1 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
  		$profile = $row1['profile'];
	}

  	$preparedquery2 = "SELECT following FROM follows where user = ?";
  	//Get all the blog entries, including, presumably, the one just added, if any
	$resultset2 = prepared_query($dbh, $preparedquery2, $user);
 	while ($row2 = $resultset2 -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		$following = $row2['following'];
    	
	
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

    		<div class="blog-footer">
      			<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      			<p>
        			<a href="#">Back to top</a>
      			</p>
    		</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>


EOT;

}

function signUp($dbh){
  if (isset ($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; 

    $user_check = query($dbh,"SELECT user FROM blog_user WHERE user='$username'"); 
    $do_usercheck = $user_check -> numRows();

    $email_check = query($dbh,"SELECT email from blog_user WHERE email='$email'");
    $do_emailcheck = $email_check -> numRows();

    echo '<div class="container"><center>';
     
    if ($do_usercheck > 0) {
      echo "<h4> Username is already in use!</h4>"; 
    } if ($do_emailcheck > 0) {
      echo "<h4> Email is already in use!</h4>"; 
    } if (($do_usercheck == 0) && ($do_emailcheck ==0)) {
      $query = "INSERT into blog_user VALUES ('$username','$password',password('$password'),'$email')";
      $resultset = query($dbh,$query);
      if ($resultset) {
        echo "<h4> You are now registered. Click <a href=\"blog-ex-login-user.php\">here</a> to return to login page </h4>";
      }
    }
    echo "</center></div>";
  }
}

function post($query,$dbh) {
  $self = $_SERVER['PHP_SELF']; 
  $preparedquery = "SELECT * FROM blog_entry WHERE caption LIKE ? OR title LIKE ?"; 
  $resultset = prepared_query($dbh,$preparedquery,array("%$query%","%$query%")); 

  //$resultset = query($dbh,"SELECT * FROM blog_entry WHERE caption LIKE '%$query%' OR title like '%$query%'
  //                    ORDER BY time(entered) desc"); 
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

        echo "
        <div class='blog-post'>
                <h2 class='blog-post-title'>$title</h2>
                <p class='blog-post-meta'>$time by <a href='toBlog.php?user=$user'>$user</a></p>
          <p> <img src='$image'> </p>
                <p> $entry </p> 
                <hr>
         </div> <!-- blog-post> 

  <!--
                <ul class='pager'>
                  <li><a href='#'>Previous</a></li>
                  <li><a href='#'>Next</a></li>
                </ul>
  --> 
    
      ";
      }
  }
}

function user($query,$dbh) {
  $self = $_SERVER['PHP_SELF'];
  $preparedquery = "SELECT user from blog_user WHERE user LIKE ?"; 
  $resultset = prepared_query($dbh,$preparedquery,"%$query%");

  //$resultset = query($dbh,"SELECT user FROM blog_user WHERE user LIKE '%$query%' 
  //                  ORDER BY user asc"); 
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

function findProfile($dbh,$user,$query) {
  $preparedquery = "SELECT $query FROM profile WHERE user = ?"; 
  $resultset = prepared_query($dbh,$preparedquery,$user); 
  $row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC);
  $size = $resultset -> numRows();
  if ($size > 0) {
    echo "
      <div class='col-md-8'><h4>$row</h4></div>"; 
  } else { 
      echo "";
    }
}


?>

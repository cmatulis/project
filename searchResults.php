<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
$query = mysql_real_escape_string($_REQUEST['searchentry']);
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
            <li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
            <li><a class="blog-nav-item" href ="#">Profile</a></li>
            <li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
            <li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
          </ul>
          <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
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
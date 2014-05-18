<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Activate Your Account</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.1.1-dist/css/signin.css" rel="stylesheet"> 

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <body>
    <div class="container">
    <?php
    require_once("MDB2.php");
    require_once("/home/cs304/public_html/php/MDB2-functions.php");
    require_once("/students/cmatulis/public_html/project/blog-functions.php");
    require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

    $dbh = db_connect($cmatulis_dsn);

    if (isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_GET['email']))
    {
        $email = $_GET['email'];
    }
    if (isset($_GET['key']) && (strlen($_GET['key']) == 32))//The Activation key will always be 32 since it is MD5 Hash
    {
        $key = $_GET['key'];
    }


    if (isset($email) && isset($key))
    {

        // Update the database to set the "activation" field to null

        $query_activate_account = "UPDATE blog_user SET activation=NULL WHERE(email ='$email' AND activation='$key')LIMIT 1";

       
        $result_activate_account = query($dbh, $query_activate_account) ;

        // Print a customized message:
        if ($result_activate_account)//if update query was successfull
        {
        echo '<div class="alert alert-success">
            <p class="text-center">Your account is now active. You may now <a href="blog-ex-login-user.php">Log in</a></p></div>';

        } else
        {
            echo '<div class="alert alert-danger">Oops !Your account could not be activated. Please recheck the link or contact the system administrator.</div>';

        }
    } else {
            echo '<div class="alert alert-danger">Error Occured .</div>';
    }


    ?>
</container>
    </body>
    </html>
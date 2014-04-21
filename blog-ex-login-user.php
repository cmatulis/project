<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

$msg = "";
$resultid = 0;
if(isset($_POST['user'])) {

    $user = $_POST['user'];
	
    if( loginCredentialsAreOkay($dbh,$user,$_POST['pass']) ) {
        if(setCookie('304bloguserphp',$user)) {
        //    $msg = "<p>Welcome, $user!\n" . 
          //      "Click here to get started <a href='blog-ex-comment-user.php'>commenting</a>\n";
		$resultid = 1;
        } else {
            $msg = "<p>Hmm. Something went wrong setting the cookie.";
        }
    } else {
        $msg = "<p>Sorry, that's incorrect.  Please try again\n";
    }
}
else{
printPageTop('Blog 304: Login');
printPageHeader();
}
// Finally, we can print the result of the login attempt.
//print $msg;

//printLoginForm();

if ($resultid == 1){
  printPageTop('Blog 304: Login');
printNext($user);
}
//print $msg;

?>

</body>
</html>

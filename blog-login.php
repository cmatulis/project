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
    $pass = $_POST['pass'];
    
	if( loginCredentialsAreOkay($dbh,$user,$pass) ) {
       	if(setCookie('304bloguserphp',$user)) {
			session_start();
			$_SESSION['user'] = $user;
			if (!checkActivated($dbh,$user,$pass)) {
				printPageTop('Poster');
				printActivationNeeded();			
			} 
			else 
				$resultid = 1;
			}
    		} 	
		else {
    			printPageTop('Poster');
			printIncorrectLoginPage();
    		}
	}

	else{
		printPageTop('Poster');
		printPageHeader();
	}


		
if ($resultid == 1){
  	printPageTop('Poster');
	printNext($user);
}


?>

</body>
</html>

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
			$resultid = 1;
       	} 
    	} 
	else {
        	printPageTop('Poster');
		printPageHeader2();
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

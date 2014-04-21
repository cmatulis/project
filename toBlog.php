<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);


$user = $_GET['user'];
$thecookie = $_COOKIE['304bloguserphp'];
$result = ($user == $thecookie);
if ($result == 1){
  printBlog($dbh, $user);
	
    }
else{
showBlog($dbh, $user);
}

?>

</body>
</html>
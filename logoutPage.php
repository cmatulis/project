<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);


if(isset($_COOKIE['304bloguserphp'])) {
  	unset($_COOKIE['304bloguserphp']);
  	setcookie('304bloguserphp', '', time() - 3600); // empty value and old timestamp
}

$msg = "";
$resultid = 0;

printPageTop('Blog 304: Login');
printPageHeader();

?>

</body>
</html>


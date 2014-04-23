<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

printSearchpage();

if(isset($_REQUEST['tables'])) {
	$q = mysql_real_escape_string($_REQUEST['tables']);
    $sought = mysql_real_escape_string($_REQUEST['sought']);

    if ($q === 'post') {
    	post($sought,$dbh); 
    	echo "<br>";
    } else if ($q === 'user') {
    	user($sought,$dbh);
    } else if ($q === 'both') {
    	//both ($sought, $dbh);
    	post($sought,$dbh);
    	user($sought,$dbh);
    }
}

function post($query,$dbh) {
	$self = $_SERVER['PHP_SELF']; 
	$resultset = query($dbh,"SELECT * FROM blog_entry WHERE entry LIKE '%$query%'"); 
	$size = $resultset -> numRows();
	if ($size === 0) {
		echo "<h2>No Posts Found";
	} else {
		echo "<h2>Posts ($size)</h2>"; 
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$user = $row['user'];
			$entry = $row['entry'];
			$entered = $row['entered'];
			$title = $row['title'];
			echo "<p>Blog Post by $user</p>
					<p>Entry Title: $title</p>
					<p>Entry: $entry</p>
					<Post Date: $entered</p>	";	
		}
	}
}
function user($query,$dbh) {
	$self = $_SERVER['PHP_SELF'];
	$resultset = query($dbh,"SELECT user FROM blog_user WHERE user LIKE '%$query%'"); 
	$size = $resultset -> numRows(); 
	if ($size === 0) {
		echo "<h2>No Users Found";
	} else {
		echo "<h2>Users ($size)</h2>"; 
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$user = $row['user'];
			echo "<p>$user"; 
		}
	}
}

?>
</body>
</html>
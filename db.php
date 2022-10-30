<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'demo_signup';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(!$con)
{
	echo "Database connection failed !";
}
?>
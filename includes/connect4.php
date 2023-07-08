<?php
	$host= 'localhost';
	$username='root';
	$password= '';
	$dbname= 'widgets';
	$con=  mysql_connect($host,$username,$password) or die (mysql_error());
	$db=mysql_select_db($dbname,$con) or die (mysql_error());
?>
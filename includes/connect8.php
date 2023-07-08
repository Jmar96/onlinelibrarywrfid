<?php
//file name: connect.php
//Title:Build your own Forgot Password PHP Script
function connect()
{	
$host="localhost"; //host
$uname="root";  //username
$pass="";      //password
$db= 'olsrfid';  //database name

$con = mysql_connect($host,$uname,$pass);

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($db, $con);}



<?php
session_start();
$login=$_SESSION['username'];
if(!$login){
	$successMSG = "<center>You're not already login! PLease login first! dont do motherfu*king things or else your pc will explode!..";
	header('refresh:10;../index.php');
}
?>
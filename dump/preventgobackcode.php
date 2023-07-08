//session working
<--loginform.php--> 
<?php
	session_start();
?>
<?php
	if ($row['username'] == $username && $row['password'] == $password){
		$_SESSION['userName'] = $username;  // session is put here!
		echo "<script type=\"text/javascript\">";
		echo "alert (\"Login Success!.. Welcome ".$_SESSION['userName']."\");window.location=\"../adminmodule/index.php\";</script>";
	}
	else{
		echo "<script type= \"text/javascript\">";
		echo "alert (\"Failed to Login!..\");window.location=\"../mihr/index.php\";</script>";
	}
?>
<--index.php-->
<?php 
session_start(); //always put this on the top!
if(!$_SESSION['userName']){
	header('refresh:2;../cheatingmsg.php');
}
?>

//session not working
<?php 
session_start();
include('../includes/connect2.php');
if(!isset($_SESSION["username"])){
	header('refresh:.1;../cheatingmsg.php');
}
?>

<?php
session_start();
$session=$_SESSION['username'];
if(!$session){
	$successMSG = "<center>You're not already login! PLease login first! dont do motherfu*king things or else your pc will explode!..";
	header('refresh:5;../index.php');
}
?>

<?php 
session_start();
$session=$_SESSION['username'];
if(!$session)
{
	header('location:index.php');
}
?>

<?php 
session_start();

if(isset($_SESSION["username"])){
    header("Location: index.php");
}

?>


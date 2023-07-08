<?php
session_start();
//require 'connection.php'

if (isset($_POST['recovery'])){
	$dql="SELECT * member WHERE email = '".$_POST['email']."'";
	$dqlq=mysqli_query($connect,$dql);
	if (!empty($_POST['email']) && mysqli_fetch_assoc($dqlq) > 0 && !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == FALSE){
		$_SESSION['info']=$_POST['email'];
		header("location:testinfo.php");
	}
	if (empty($_POST['email'])) {
		$ree = "Enter Email ...";
	}else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)==true){
		$ree = "Invalid Email ...";
	}else if (mysqli_fetch_assoc($dqlq) < 1 ){
		$ree = "Email does not exist";
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>recovery</title>
</head>
<body>
Login
<form action="testforgotpassw.php" method="post">
<table>
	<tr>
		<td><input type="email" name="email" placeholder="Email"></td>
		<td><input type="submit" name="recovery" value="Recover"></td>
	</tr>
</table>
				<?php
				$token=getRandomString(10);
				echo $token;
				function getRandomString($length) {
			    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZabcdefghijklmnopqrstuvwxyz123456789";
			    $validCharNumber = strlen($validCharacters);
			    $result = "";

			    for ($i = 0; $i < $length; $i++) {
			        $index = mt_rand(0, $validCharNumber - 1);
			        $result .= $validCharacters[$index];
			    }
				return $result;
				}
				?>
</form>
</body>
</html>
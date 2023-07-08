<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up Process</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />
	<link rel="shortcut icon" href="design/editingicon.png" />
	<link rel="stylesheet" type="text/css" href="cssjava/style1.css">
<style type="text/css">
div#header{
	border: solid thin black;
	height: 98px;
	background-image: url(design/esquire.jpeg);
	background-size: 100% 100%;
}
p{
	font-family: Arial,Helvetica,Sans-serif;
	font-size: 12px;
	color:#000000;
}
h6{
	font-size:12px;
	color:#000000;
}
</style>
</head>
<body bgcolor="#262626">
<div id="main_container">
<div id="header">
<div class="right_header">SIGN UP<a href="indexlib.php" class="logout" onClick="return confirm('Are you an Librarian?')">  </a></div>	
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="index.php">SIGN IN</a></li>
		<li><a href="olsregistration.php">SIGN UP</a></li>
		<li><a class="current" href="olsregprocess.php">PROCESS</a></li>
		</ul>
	</div>
</div>	
<div>
<!--//Registration process-->
<?php
if (isset($_POST['add'])){
	require('includes/connect7.php');

	session_start();
	$memberId=$_POST['memId'];
	$password=$_POST['passw'];
	$cpassword=$_POST['cpassw'];
	$emailAddress=$_POST['emadd'];
	$retrieve=$_POST['ret'];
	//echo $memberId;

	$verify = mysql_query("SELECT * FROM member WHERE memberId = '$memberId' ");
	$row1 = mysql_fetch_object($verify);
	if (empty($row1)){
		$membId = "69696";
		$passwo = "96969";

	}else{
		$row1->memberId;
		$row1->password;
		$membId = $row1->memberId;
		$passwo = $row1->password;
	}
	
	$aStatus = "active";
	
	//if ($row['memberId'] == $row['memberId']){
	//	echo "true";
	//}else{
	//	echo "false";
	//}

	if ($memberId==''||$password==''||$cpassword==''||$emailAddress==''||$retrieve==''){
		$_SESSION['register']=FALSE;
		$_SESSION['memId']=$memberId;
		$_SESSION['passw']=$password;
		$_SESSION['cpassw']=$cpassword;
		$_SESSION['emadd']=$emailAddress;
		$_SESSION['ret']=$retrieve;
		//echo "<center>You must fill in all the fields.</center>";
		echo '<a href="olsregistration.php">BACK</a>';
		$errMSG = "<center>You must fill in all the fields.</center>";
		echo $errMSG;
		header("refresh:1;olsregistration.php");
	}else if ($password!=$cpassword){
		$_SESSION['register']=FALSE;
		$_SESSION['memId']=$memberId;
		$_SESSION['passw']=$password;
		$_SESSION['cpassw']=$cpassword;
		$_SESSION['emadd']=$emailAddress;
		$_SESSION['ret']=$retrieve;
		echo "<center>Please verify your password.</center>";
		echo '<a href="olsregistration.php">BACK</a>';
	}else if (strlen($password)<=5){
		$_SESSION['register']=FALSE;
		$_SESSION['memId']=$memberId;
		$_SESSION['passw']=$password;
		$_SESSION['cpassw']=$cpassword;
		$_SESSION['emadd']=$emailAddress;
		$_SESSION['ret']=$retrieve;
		echo "<center>Password must be atleast 6 characters.</center>";
		echo '<a href="olsregistration.php">BACK</a>';
	}else if ($membId != $memberId){
		$dStatus = "deactive";
		$noMem = "new";
		$insert=mysql_query("INSERT INTO member VALUES ('','$memberId','$password','$noMem','','','$emailAddress','$dStatus','$retrieve','')");
		if($insert){
			echo '<center>';
			echo "<h1>Register Successfully</h1><br><br>";
			echo "<h4>You are not an student or member of school faculty.</h4><br>";
			echo "<h4>Wait the admin to activate your account after verification.</h4><br>";
			echo "<script language='javascript'>alert('Register Succesfully (nonMember)')</script>";
			$nmSearch = mysql_query("SELECT * FROM member WHERE memberId = '$memberId' ");
			while($row = mysql_fetch_array($nmSearch)){
			echo "<table border='2'>
				<tr><th>MEMBER ID</th><th>EMAIL ADDRESS</th><th>STATUS</th></tr>
				<tr><td>".$row['memberId']."</td><td>".$row['emailAddress']."</td><td>".$row['userStatus']."</td></tr>";
			echo "<br>...";
			echo "</table>";
			echo '</center>';
			}
		}else{
			echo "None Member Registration Error!";
			//echo "<br>from the data table ".$membId." and the data you enter ".$memberId;
			echo '<br><a href="olsregistration.php">BACK</a>';
			header("refresh:2;index.php");
		} 
	}else if ($membId == $memberId){
		if (empty($passwo)){
			$update=mysql_query("UPDATE member SET password='$password',emailAddress='$emailAddress',retrieve='$retrieve',userStatus='$aStatus' WHERE memberId='$memberId'");
			if($update){
				echo '<center>';
				echo "<h1>Register Successfully</h1><br><br>";
				echo "<h4>You can now login.</h4><br>";
				echo "<script language='javascript'>alert('Register Succesfully')</script>";
				header("refresh:2;index.php");
			}else{
				echo "Member Registration Error!";
				echo '<a href="olsregistration.php">BACK</a>';
				header("refresh:2;index.php");
			}
		}else{
			echo "<center>";
			echo "<h2>Warning!</h2>";
			echo "<h2>You are registered already....</h2>";
			echo "</center>";
			header("refresh:10,index.php");
		}
	}else{
		echo "<center>";
		echo "<h2>Warning!</h2>";
		echo "<h2>Your data that you've enter are suspecious!..</h2>";
		echo "</center>";
		header("refresh:2,index.php");
	}

}
?>	

</div>
</div>
</body>
</html>
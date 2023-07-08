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
<div class="right_header">SIGN UP<a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>	
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
//if (isset($_POST['add'])){
	require('includes/connect7.php');

	session_start();
	$memberId="";
	//$password=$_POST['passw'];
	//$cpassword=$_POST['cpassw'];
	//$emailAddress=$_POST['emadd'];
	//$retrieve=$_POST['ret'];
	echo "<h1>this is the orig no. ".$memberId."</h1><br>";


	$vrfy = mysql_query("SELECT * FROM member WHERE memberId = '$memberId'");
	$row1 = mysql_fetch_object($vrfy);
	if (empty($row1)){
		$membId = "ggaaggoo";

	}else{
		$row1->memberId;
		$membId = $row1->memberId;
	}

	echo "<br>hello this is the".$membId."<br>";


	if ($membId == $memberId){
		echo "<br>true";
		echo "<br>".$membId;
		echo " == ".$memberId;
	}else if (empty($memberId)){
		$vrt ="gggg empty";
		echo "<br>".$vrt;
	}else{
		echo "<br>false";
		echo "<br>".$membId;
		echo " != ".$memberId;
	}		





	echo "<br><br><br><br><br>";
	$verify = mysql_query("SELECT * FROM member WHERE memberId = '$memberId' ");
	while($row = mysql_fetch_array($verify)){
		echo $row['memberId'];
		$row['password'];
		$row['fullname'];
		$row['emailAddress'];
	}
	$vmId = $row['memberId'];
	$dStatus = "deactive";
	$aStatus = "active";
	$noMem = "new";
	echo "<br>".$aStatus;
	echo "<br>".$dStatus;
	echo "<br>".$noMem;
	if ("{$row['memberId']}" == $memberId){
		echo "<br>true";
		echo "<br>".$row['memberId'];
		echo "==".$row['memberId'];
	}else{
		echo "<br>false";
		echo "<br>".$row['memberId'];
		echo "!=".$memberId;
	}
	if ($vmId != $memberId){
		echo "<br>true";
		echo "<br>".$vmId;
		echo "==".$row['memberId'];
	}else{
		echo "<br>false";
		echo "<br>".$vmId;
		echo "!=".$memberId;
	}
	

//}
?>	

</div>
</div>
</body>
</html>
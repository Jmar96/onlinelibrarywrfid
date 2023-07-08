<?php
session_start();
include('includes/connect2.php');
if(!isset($_SESSION["username"])){
	$cheatingMSG = "<center>You're not already login! PLease login first! dont do motherfu*king things or else your pc will explode!..";
	header('refresh:1;index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	<title>Returnin Prevention</title>
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
<body>
<div id="main_container">
<div id="header">
<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">SIGN UP<a href="olsregistration.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="index.php">SIGN IN</a></li>
		<li><a class="current" href="olsregistration.php">SIGN UP</a></li>
		</ul>
	</div>
</div>
<div>
<div align="center" style="background-color: #ffffff">
<?php
	if(isset($cheatingMSG)){
			?>
            <div class="alert alert-danger">
				<h1 style="color:#ff0000"><strong><br><br><br><br><br><br><?php echo $cheatingMSG; ?></strong></h1><br><br><br><br><br><br>
            </div>
            <?php
	}
?>
</div>
</div>
</body>
</html>
<?php
session_start();
if (isset($_SESSION['register']) && !empty($_SESSION['register'])) {
	$memId=$_SESSION['memId'];
	$passw=$_SESSION['passw'];
	$cpassw=$_SESSION['cpassw'];
	$emadd=$_SESSION['emadd'];
	$retrieve=$_SESSION['ret'];
}
//if (array_key_exists('register',$_SESSION) && !empty($_SESSION['register'])) {
//	$memId=$_SESSION['memId'];
//	$passw=$_SESSION['passw'];
//	$cpassw=$_SESSION['cpassw'];
//	$emadd=$_SESSION['emadd'];
//	$retrieve=$_SESSION['ret'];
//}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
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
<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">SIGN UP<a href="indexlib.php" class="logout" onClick="return confirm('Are you an Librarian?')">  </a></div>
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
	<!--//REGISTRATION FORM-->	

<fieldset style="background-color: #ffffff"><legend align="center"><b><font color="#262626"><h3>REGISTRATION FORM</h3></font></b></legend></fieldset>
<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
				<strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
?>
<form action="olsregprocess.php" method="post" style="background-color: #ffffff">
	<table width="60%" align="center">
		<tr>
			<td><h4>ID NUMBER : </h4></td>
			<td><input type="text" name="memId" value="<?php if (isset($memId)) {echo $memId;} ?>" placeholder="  Your RFID No."></td>
		</tr>
		<tr>
			<td><h4>PASSWORD : </h4></td>
			<td><input type="password" name="passw" value="<?php if (isset($passw)) {echo $passw;} ?>" placeholder="  Password"></td>
			<td><h4>CONFIRM PASSWORD : </h4></td>
			<td><input type="password" name="cpassw" value="<?php if (isset($cpassw)) {echo $cpassw;} ?>" placeholder="  Retype Password"></td>
		</tr>
		<tr>
			<td><h4>EMAIL ADDRESS : </h4></td>
			<td><input type="email" name="emadd" value="<?php if (isset($emadd)) {echo $emadd;} ?>" placeholder="  Email Address"></td>
		</tr>
		<tr>
			<td><h4>RETRIEVING PHRASE : </h4></td>
			<td><input type="text" name="ret" value="<?php if (isset($ret)) {echo $ret;} ?>" placeholder="  PASS PHRASE!"></td>
		</tr>
		<tr align="center">
		<td></td><td align="center"><input type="submit" value="REGISTER" name="add"></td>
		</tr>
	</table>
</form>
</div>

</div>
<?php
if (isset($_SESSION['register'])){
	unset($_SESSION['memid']);
	unset($_SESSION['passw']);
	unset($_SESSION['cpassw']);
	unset($_SESSION['emadd']);
	unset($_SESSION['ret']);
}
?>
</body>
</html>
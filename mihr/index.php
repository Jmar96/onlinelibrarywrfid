
<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	<title>Admin Login</title>
<link rel="shortcut icon" href="../design/editingicon.png" />
<link rel="stylesheet" type="text/css" href="../cssjava/style1.css">
<style type = "text/css">
div#header{
	border: solid thin black;
	height: 98px;
	background-image: url(../design/esquire.jpeg);
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
<body bgcolor="lightgreen">
<?php  
if (isset ($_POST['submit'])){
	$username=$_POST['username'];
	$password=$_POST['password'];

	$username=stripcslashes($username);
	$password=stripcslashes($password);
	$username=mysql_real_escape_string($username);
	$password=mysql_real_escape_string($password);

	mysql_connect("localhost","root","");
	mysql_select_db("olsrfid");

	$result=mysql_query("SELECT * from admin where username = '$username'") or die ("failed to query database".mysql_error());
	$row=mysql_fetch_array($result);
	if ($row['username'] == $username && $row['password'] == $password){
		$_SESSION['userName'] = $username;
		echo "<script type=\"text/javascript\">";
		echo "alert (\"Login Success!.. Welcome ".$_SESSION['userName']."\");window.location=\"../adminmodule/index.php\";</script>";
	}
	else{
		echo "<script type= \"text/javascript\">";
		echo "alert (\"Failed to Login!..\");window.location=\"../mihr/index.php\";</script>";
	}

}
?>
<div id="main_container">
<div id="header">
<div align="left"><a style="text-decoration: none;" href="../mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">WELCOME ADMIN<a href="../mihr/index.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../indexlib.php">LIBRARIAN</a></li>
		<li><a class="current" href="../index.php">SIGN IN</a></li>
		<li><a href="../olsregistration.php">SIGN UP</a></li>
		</ul>
	</div>
</div>
<div>
<div>
<!--//ADMIN LOGIN-->
<table align="center" border="3" bgcolor="#ffffff">
	<tr>
		<td>
			<div>
			<h3><center>Admin Login</center></h3><br>
			<form class="form-horizontal" action="index.php" method="post">
			<div>
				<label for="name">Username :&nbsp;</label>
				<input type="text" name="username" id="username" value="" placeholder="Username" autofocus required style="height: 30px; width: 250px;" />
			</div>	
			<div>
				<label for="pass">Password : &nbsp;</label>
				<input type="password" name="password" id="password" value="" placeholder="Password" autofocus required style="height: 30px; width: 250px;" />
			</div>
			<div>
				<?php
					if(!empty($message)){
						echo "<p style='color:red; padding:2px; font-size:15px;'>".$message." </p>";
					}
				?>
			<div><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="LOGIN" class="btn btn-primary btn-small"/>
			</div>
			</div>
			</form>	
			</div>
		</td>
	</tr>
</table>
</div>
<!-- <div><a href="../index.php?id=22" class="logout">login as member&nbsp;</a></div> -->
<br>
</div>
</body>
</html>
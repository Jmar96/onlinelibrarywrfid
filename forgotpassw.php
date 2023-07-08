<?php 
	session_start();
	require_once('includes/connect1.php');
?>
<!DOCTYPE.html>
<html>
<head>
<title>Forgot Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="design/editingicon.png" />
<link rel="stylesheet" type="text/css" href="cssjava/style1.css">
<style type = "text/css">
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
<body bgcolor="lightblue">
<?php
	if(isset($_POST['submit'])) {
		$memberId = $_POST['memberId'];
		$email = $_POST['email'];
		
		$result = $dbh->prepare("SELECT * FROM member WHERE memberId= :umid AND emailAddress= :ema");
		$result->bindParam(':umid', $memberId);
		$result->bindParam(':ema', $email);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		if($rows > 0) {
		
			$result=$dbh->prepare("SELECT * FROM member WHERE emailAddress=:emal");
			$result->bindParam(':emal', $email);
			$result->execute();
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				$res_id = $row['id'];
				$mbid = $row['memberId'];
				$passw = $row['password'];
				$fn = $row['fullname'];
				$cnt = $row['contactNo'];
				$emall = $row['emailAddress'];
				$curr_status = $row['userStatus'];
				$retr = $row['retrieve'];
			}
			
			if($curr_status=='deactive') {
				$message = "Sorry <b>$username</b> ganda/pogeh, your account is temporarily deactivated, try contact the admin for activation!..";
			}else if (empty($passw)){
				$message = "You are not yet registered...";
			}else if (empty($emall)){
				$message = "You are not yet registered...";
			}else{
				$_SESSION['memId'] = $mbid;
				$_SESSION['email'] = $emall;
				$_SESSION['psword'] = $passw;
				header("location: resetpassword.php");
			}
			
		}
		else{
			$message = 'ID no. and Email are not exists. <br> <a href="olsregistration.php">SIGN UP NOW</a>';
		}
	}
?>
<div id="main_container">
<div id="header">
<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">WELCOME<a href="indexlib.php" class="logout" onClick="return confirm('Are you an Librarian?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
<!--		<li><a href="indexlib.php">LIBRARIAN</a></li> -->
		<li><a class="current" href="index.php">SIGN IN</a></li> 
		<li><a href="olsregistration.php">SIGN UP</a></li>
		</ul>
	</div>
</div>
<div>
<!--//MEMBER LOGIN-->
<table align="center" border="3" bgcolor="#ffffff">
	<tr>
		<td>
			<div>
			<h3><center>FORGOT PASSWORD</center></h3><br>
			<form class="form-horizontal" action="forgotpassw.php" method="post">
			<table align="center">
				<tr>
					<td><label for="name">ID Number &nbsp;&nbsp;:</label></td>
					<td><input type="text" name="memberId" id="memberId" value="" placeholder="RFID No." autofocus required style="height: 30px; width: 250px;" /></td>
				</tr>
				<tr>
					<td><label for="pass">EMAIL ADD :</label></td>
					<td><input type="email" name="email" id="email" value="" placeholder="Your Email Address" autofocus required style="height: 30px; width: 250px;" /></td>
				</tr>
			</table>
			<div>
				<?php
					if(!empty($message)){
						echo "<center><p style='color:red; padding:2px; font-size:15px;'>".$message." </p></center>";
					}
				?>
			<div><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="RECOVER" class="btn btn-primary btn-small"/>
				

			</div>	
			</div>
			</form>	
			</div>
		</td>
	</tr>
</table>
</div>
</body>
</html>
<?php
//include("includes/connect8.php");
//connect();
//function getRandomString($length) {
//    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
//    $validCharNumber = strlen($validCharacters);
//    $rresult = "";

//  	for ($i = 0; $i < $length; $i++) {
// 	$index = mt_rand(0, $validCharNumber - 1);
//    $rresult .= $validCharacters[$index];
 //   }
//	return $rresult;
//	}
?>
<?php 
	session_start();
	require_once('includes/connect1.php');
?>
<!DOCTYPE.html>
<html>
<head>
<title>OLS Login</title>
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
<body bgcolor="lighblue">
<!--<?php
echo $_SESSION['flName']. $_SESSION['librId']; ?> -->
<?php
	if(isset($_POST['submit'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$result = $dbh->prepare("SELECT * FROM librarian WHERE username= :usna AND password= :pswo");
		$result->bindParam(':usna', $username);
		$result->bindParam(':pswo', $password);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		if($rows > 0) {
		
			$result=$dbh->prepare("SELECT * FROM librarian WHERE username=:usna");
			$result->bindParam(':usna', $username);
			$result->execute();
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				$res_id = $row['id'];
				$curr_status = $row['userStatus'];
				$lbid = $row['libId'];
				$fn = $row['fullname'];
			}
			
				if($curr_status=='deactive') {
					$message = "Sorry <b>$username</b> ganda/pogeh na librarian, your account is temporarily deactivated, try contact the admin for activation!..";
				}else{
					$_SESSION['librId'] = $lbid;
					$_SESSION['flName'] = $fn;
					header("location: librarianmodule/index.php?logid=$res_id");
				}
			
		}
		else{
			$message = 'Username and Password are not exists.';
		}
	}
?>
<div id="main_container">
<div id="header">
<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">WELCOME LIBRARIAN<a href="olsregistration.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
<!--//LIBRARIAN LOGIN-->
<table align="center" border="3" bgcolor="#ffffff">
	<tr>
		<td>
			<div>
			<h3><center>Librarian Login</center></h3><br>
			<form class="form-horizontal" action="indexlib.php" method="post">
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
<!--<div><a href="index.php?id=22" class="logout" >d2 member&nbsp;</a></div> -->
</div>
</body>
</html>
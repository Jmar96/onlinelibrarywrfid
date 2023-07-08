<?php 
session_start();
if(!$_SESSION['memId']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['email']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['psword']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<!DOCTYPE.html>
<html>
<head>
<title>Reset Password</title>
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
<div id="main_container">
<div id="header">
<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a></div>
<div class="right_header">WELCOME<a href="indexlib.php" class="logout" onClick="return confirm('Are you an Librarian?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
<!--		<li><a href="indexlib.php">LIBRARIAN</a></li> -->
		<li><a href="index.php">SIGN IN</a></li> 
		<li><a href="olsregistration.php">SIGN UP</a></li>
		<li><a class="current" href="forgotpassw.php">FORGOT PASSWORD</a></li>
		</ul>
	</div>
</div>
<center><h2>Is this you? </h2></center>
<?php
	echo "<br/><br/>"; //double space
	require_once 'includes/connect5.php';
	$email=$_SESSION['email'];
	$stmt = $DB_con->prepare('SELECT * FROM member where memberId = ? ');
	$stmt->execute(array($_SESSION['memId']));
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div align="center">
				
			&nbsp;<img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
				
			<!--	
			<p class="page-header"><?php echo $memberId."&nbsp;/&nbsp;".$fullname; ?></p> -->
				<tr>
				<td><br><label class="control-label">Member ID : </label></td>
				<td><input type="text" name="" value="<?php echo $memberId; ?>" readonly></td><br/>
				</tr>
				<tr>
				<td><label class="control-label">Fullname : &nbsp;&nbsp;</label></td>
				<td><input type="text" name="" value="<?php echo $fullname; ?>" readonly></td>
				</tr>
				<p class="page-header">
				<span>
				<a href="forgotpassw.php">Not me.</a>
				&nbsp;&nbsp;<a class="btn btn-info" href="change_pass.php?change_pass=<?php echo $row['id']; ?>" title="click for edit" "><span class="glyphicon glyphicon-edit"></span>Continue</a>

				</span>
				</p>

			</div> 
			<br>      
			<?php
		}
	}
	else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; The Session Data Not Found ...
            </div>
        </div>
        <?php
	}
	
?>

</div>
</body>
</html>
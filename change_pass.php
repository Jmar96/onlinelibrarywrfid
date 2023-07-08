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
<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'includes/connect5.php';
	
	if(isset($_GET['change_pass']) && !empty($_GET['change_pass']))
	{
		$id = $_GET['change_pass'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM member WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: forgotpassw.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$memberId = $_POST['user_mid'];
		$password = $_POST['user_pass'];
		$cpassword = $_POST['user_cpass'];
		$fullname = $_POST['user_fnam'];
		$address = $_POST['user_add'];
		$contactNo = $_POST['user_cont'];
		$emailAddress = $_POST['user_ema'];
		$userStatus = $_POST['user_stat'];
		$retrieve = $_POST['user_ret'];
			
		
		
		if ($password != $cpassword){
			$errMSG = "<h4>&nbsp;&nbsp;Please Confirm your New Password.</h4>";
		}	

		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE member 
									     SET memberId=:mid, 
										     password=:lpas,
										     fullname=:lfna,
										     address=:ladd,
										     contactNo=:lcon,
										     emailAddress=:lema,
										     userStatus=:lsta,
										     retrieve=:lret
								       WHERE id=:uid');
			$stmt->bindParam(':mid',$memberId);
			$stmt->bindParam(':lpas',$password);
			$stmt->bindParam(':lfna',$fullname);
			$stmt->bindParam(':ladd',$address);
			$stmt->bindParam(':lcon',$contactNo);
			$stmt->bindParam(':lema',$emailAddress);
			$stmt->bindParam(':lsta',$userStatus);
			$stmt->bindParam(':lret',$retrieve);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated! This is your new password : <?php echo $password?>');
				alert('You can Login Now...');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['memId']?></title>
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
<body bgcolor=#ccd9ff>
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['email']?><a href="../logouts/logoutlib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
<div class="center_content">

<div class="container">


	<div class="page-header">
    	<h1 class="h2">CHANGE PASSWORD</h1>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Member ID : </label></td>
        <td><input class="form-control" type="text" name="user_mid" value="<?php echo $memberId; ?>"  / readonly></td>
    </tr>
    <tr>
    <?php
    	$newpass = getRandomString(10);
    ?>
    	<td><label class="control-label">New Password : </label></td>
        <td><input class="form-control" type="text" name="user_pass" value="<?php echo $newpass; ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">Confirm New Password : </label></td>
        <td><input class="form-control" type="text" name="user_cpass" value="<?php echo $cpassword; ?>" placeholder=" Retype Password" required /></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="text" name="user_fnam" value="<?php echo $fullname; ?>" required / hidden></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="text" name="user_add" value="<?php echo $address; ?>" required / hidden></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="text" name="user_cont" value="<?php echo $contactNo; ?>" required / hidden></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="email" name="user_ema" value="<?php echo $emailAddress; ?>" required / hidden></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="text" name="user_stat" value="<?php echo $userStatus; ?>" readonly / hidden></td>
    </tr>
    <tr>
    	<td></td>
        <td><input class="form-control" type="text" name="user_ret" value="<?php echo $retrieve; ?>" required / hidden></td>
    </tr> 
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Continue
        </button>
        
        </td>
    </tr>
    
    </table>
    
</form>
</div>
</div>
<?php
include("includes/connect8.php");
connect();
function getRandomString($length) {
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZabcdefghijklmnopqrstuvwxyz123456789";
    $validCharNumber = strlen($validCharacters);
    $rresult = "";

  	for ($i = 0; $i < $length; $i++) {
 	$index = mt_rand(0, $validCharNumber - 1);
    $rresult .= $validCharacters[$index];
    }
	return $rresult;
	}
?>
</body>
</html>
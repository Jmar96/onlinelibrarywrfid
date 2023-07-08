<?php 
session_start();
if(!$_SESSION['flName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['librId']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT libId, username, password, fullname, address, contactNo, emailAddress, userStatus, retrieve, userPic FROM librarian WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: ../librarianmodule/libprofile.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$libId = $_POST['user_lid'];
		$username = $_POST['user_name'];// user name
		$password = $_POST['user_pass'];
		$cpassword = $_POST['user_cpass'];//confirm pass
		$fullname = $_POST['user_fnam'];
		$address = $_POST['user_add'];
		$contactNo = $_POST['user_cont'];
		$emailAddress = $_POST['user_ema'];
		$userStatus = $_POST['user_stat'];
		$retrieve = $_POST['user_ret'];
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
			
		if ($password != $cpassword){
			$errMSG = "<h4>&nbsp;&nbsp;Please Confirm your Password.</h4>";
		}
			
		if($imgFile)
		{
			$upload_dir = '../user_images/'; // upload directory	(folder)
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['userPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE librarian 
									     SET libId=:lid, 
										     username=:lusn,
										     password=:lpas,
										     fullname=:lfna,
										     address=:ladd,
										     contactNo=:lcon,
										     emailAddress=:lema,
										     userStatus=:lsta,
										     retrieve=:lret, 
										     userPic=:lpic 
								       WHERE id=:uid');
			$stmt->bindParam(':lid',$libId);
			$stmt->bindParam(':lusn',$username);
			$stmt->bindParam(':lpas',$password);
			$stmt->bindParam(':lfna',$fullname);
			$stmt->bindParam(':ladd',$address);
			$stmt->bindParam(':lcon',$contactNo);
			$stmt->bindParam(':lema',$emailAddress);
			$stmt->bindParam(':lsta',$userStatus);
			$stmt->bindParam(':lret',$retrieve);
			$stmt->bindParam(':lpic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				window.location.href='libprofile.php';
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
<title>Librarian Module</title>
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
<body bgcolor=#ccd9ff>
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['flName']?><a href="../logouts/logoutlib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content">
<div class="left_content">
<div class="container">


	<div class="page-header">
    	<h1 class="h2">UPDATE PROFILE <a class="btn btn-default" href="index.php"> back </a></h1>
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
    	<td><label class="control-label">Librarian ID : </label></td>
        <td><input class="form-control" type="text" name="user_lid" value="<?php echo $libId; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Username : </label></td>
        <td><input class="form-control" type="text" name="user_name" value="<?php echo $username; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Password : </label></td>
        <td><input class="form-control" type="password" name="user_pass" value="<?php echo $password; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Confirm Password : </label></td>
        <td><input class="form-control" type="password" name="user_cpass" value="<?php echo $cpassword; ?>" placeholder=" Retype Password" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Fullname : </label></td>
        <td><input class="form-control" type="text" name="user_fnam" value="<?php echo $fullname; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Address : </label></td>
        <td><input class="form-control" type="text" name="user_add" value="<?php echo $address; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Contact No : </label></td>
        <td><input class="form-control" type="text" name="user_cont" value="<?php echo $contactNo; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Email Address : </label></td>
        <td><input class="form-control" type="email" name="user_ema" value="<?php echo $emailAddress; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">User Status : </label></td>
        <td><input class="form-control" type="text" name="user_stat" value="<?php echo $userStatus; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Retrieving Phrase : </label></td>
        <td><input class="form-control" type="text" name="user_ret" value="<?php echo $retrieve; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Profile Img : </label></td>
        <td>
        	<p><img src="../user_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="libprofile.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
</div>
</div>
<div class="right_content">


</div>
</div>
</body>
</html>
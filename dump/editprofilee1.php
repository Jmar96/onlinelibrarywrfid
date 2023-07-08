<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
	<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM librarian WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$libId = $_POST['libId'];// librarian id
		$username = $_POST['username'];// username
		$password = $_POST['password'];
		$fullname = $_POST['fullname'];
		$address = $_POST['address'];
		$contactNo = $_POST['contactNo'];
		$emailAddress = $_POST['emailAddress'];
		$userStatus = $_POST['userStatus'];
		$retrieve = $_POST['retrieve'];
		//$ = $_POST['']; //reserve
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = '../user_images/'; // upload directory	(folder)
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
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
				$errMSG = "Sorry, only JPG, JPEG & PNG  files are allowed.";		
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
										     userStatus=:luss,
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
			$stmt->bindParam(':luss',$userStatus);
			$stmt->bindParam(':lret',$retrieve);
			$stmt->bindParam(':lpic',$userPic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
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
<title>Admin Module</title>
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
<div class="right_header">Welcome Admin<a href="../logouts/logoutlib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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

<div class="container">


	<div class="page-header">
    	<h1 class="h2">Update Book.&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-default" href="../librarianmodule/index.php"> See all books </a></h1>
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
        <td><input class="form-control" type="text" name="libId" value="<?php echo $libId; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Username : </label></td>
        <td><input class="form-control" type="text" name="username" value="<?php echo $username; ?>" required /></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Password : </label></td>
        <td><input class="form-control" type="text" name="password" value="<?php echo $password; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Fullname : </label></td>
        <td><input class="form-control" type="text" name="fullname" value="<?php echo $fullname; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Address : </label></td>
        <td><input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Contact No : </label></td>
        <td><input class="form-control" type="number" name="contactNo" value="<?php echo $contactNo; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Email Address : </label></td>
        <td><input class="form-control" type="email" name="emailAddress" value="<?php echo $emailAddress; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">User Status : </label></td>
        <td>
        	<input type="radio" name="userStatus" <?php if (isset($userStatus) && $userStatus="active") echo "checked";?> value="active" checked>Active
			<input type="radio" name="userStatus" value="deactive">Deactive
		</td>
    </tr>
    <tr>
    	<td><label class="control-label">Retrieving Phrase : </label></td>
        <td><input class="form-control" type="text" name="retrieve" value="<?php echo $retrieve; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">User Image : </label></td>
        <td>
        	<p><img src="../user_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/libprofile.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
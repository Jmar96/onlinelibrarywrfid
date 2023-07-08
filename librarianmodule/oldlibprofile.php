<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
$userName = $_SESSION['userName'];
?>
<!--<?php 
session_start();

//echo "Welcome ".$_SESSION['userName']; //print welcome(value of session)
$username=$_SESSION['userName'];
?>-->
<br>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	<title>Librarian Module</title>
</head>
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once '../includes/connect5.php';
	
	if(isset($_POST['btnsave']))
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
		
		
		if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = '../user_images/'; // upload directory ( the folder )

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG & PNG files are allowed.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO librarian(userPic) VALUES(:lpic)');
			
			$stmt->bindParam(':lpic',$userpic);
			
			if($stmt->execute())
			{
				$successMSG = "The Profile Pic is successfully updated ...";
				header("refresh:10;libprofile.php"); // redirects image view page after a seconds.
			}
			else
			{
				$errMSG = "error while updating....";
			}
		}
	}
?>
<body bgcolor="lightgreen">
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="../librarianmodule/libprofile.php"><?php echo $userName;?></a> </li>
		<li><a href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../librarianmodule/reserve.php">RESERVATION</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<?php
//	include('../includes/connect2.php');
//	$stmt=mysql_query("SELECT * from librarian where username like '$username' ");
	
//	echo "this is the value of session -> ".$_SESSION['userName'];
	echo "<br/><br/>"; //double space
	require_once '../includes/connect5.php';
	$username=$_SESSION['userName'];
	$stmt = $DB_con->prepare('SELECT * FROM librarian where username = ? ');
	$stmt->execute(array($_SESSION['userName']));
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				
				<img src="../user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
				<form method="post" enctype="multipart/form-data" class="form-horizontal">
					<table class="table table-bordered table-responsive">
					<tr>
			        <td><input class="input-group" type="file" name="user_image" accept="image/*" /></td>
				    </tr>
				    
				    <tr>
				        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
				        <span class="glyphicon glyphicon-save"></span>Save New Profile
				        </button>
				        </td>
				    </tr>
				    </table>
				</form>
				
			<p class="page-header"><?php echo $libId."&nbsp;/&nbsp;".$fullname; ?></p>
				<tr>
				<td><label class="control-label">Librarian ID : </label></td>
				<td><input type="text" name="" value="<?php echo $libId; ?>" readonly></td><br/>
				</tr>
				<tr>
				<td><label class="control-label">Fullname : </label></td>
				<td><input type="text" name="" value="<?php echo $fullname; ?>" readonly></td>
				</tr>
				<p class="page-header">
				<span>
				<a class="btn btn-info" href="editprofile.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Update</a>
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span>Update Profile Picture</a>
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
</div>
</body>
</html>
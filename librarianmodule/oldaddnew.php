<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once '../includes/connect5.php';
	
	if(isset($_POST['btnsave']))
	{
		$isbn = $_POST['isbn'];// isbn
		$bookName = $_POST['bookName'];// book name
		$author = $_POST['author'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$releaseDate = $_POST['releaseDate'];
		$bookStatus = $_POST['bookStatus'];
		
		$imgFile = $_FILES['book_image']['name'];
		$tmp_dir = $_FILES['book_image']['tmp_name'];
		$imgSize = $_FILES['book_image']['size'];
		
		
		if(empty($isbn)){
			$errMSG = "Please Enter ISBN.";
		}
		else if(empty($bookName)){
			$errMSG = "Please Enter the Book Name.";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = '../book_images/'; // upload directory ( the folder )

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
		
			// rename uploading image
			$bookpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$bookpic);
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
			$stmt = $DB_con->prepare('INSERT INTO books(isbn,bookName,author,category,description,bookStatus,bookPic) VALUES(:bno, :bname, :baut, :bcat, :bdes, :bstat, :bpic)');
			$stmt->bindParam(':bno',$isbn);
			$stmt->bindParam(':bname',$bookName);
			$stmt->bindParam(':baut',$author);
			$stmt->bindParam(':bcat',$category);
			$stmt->bindParam(':bdes',$description);
			$stmt->bindParam(':bstat',$bookStatus);
			$stmt->bindParam(':bpic',$bookpic);
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:1;index.php"); // redirects image view page after a seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
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
<div class="right_header">Welcome Admin<a href="../logouts/logoutslib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
    	<h1 class="h2"> &nbsp;Add New Book&nbsp;&nbsp;&nbsp;&nbsp;. <a class="btn btn-default" href="../librarianmodule/index.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View all </a></h1>
    </div>
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">ISBN:</label></td>
        <td><input class="form-control" type="text" name="isbn" placeholder="International Standard Book Number" value="<?php echo $isbn; ?>" /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Book Name(Title):</label></td>
        <td><input class="form-control" type="text" name="bookName" placeholder="Book Name or Title" value="<?php echo $bookName; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Author:</label></td>
        <td><input class="form-control" type="text" name="author" placeholder="Book Author or Editor" value="<?php echo $author; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Category:</label></td>
        <td><input class="form-control" type="text" name="category" placeholder="Category" value="<?php echo $category; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Description:</label></td>
        <td><input class="form-control" type="text" name="description" placeholder="Description" value="<?php echo $description; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Book Status:</label></td>
        <td><input class="form-control" type="text" name="bookStatus" placeholder="Book Name or Title" value="<?php echo $bookStatus; ?>" /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Book Img.</label></td>
        <td><input class="input-group" type="file" name="book_image" accept="image/*" /></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>


</div>



</div>


</body>
</html>
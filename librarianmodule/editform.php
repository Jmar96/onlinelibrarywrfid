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
		$stmt_edit = $DB_con->prepare('SELECT * FROM books WHERE id =:uid');
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
		$isbn = $_POST['isbn'];// isbn
		$bookName = $_POST['bookName'];// name
		$author = $_POST['author'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$bookStatus = $_POST['bookStatus'];
			
		$imgFile = $_FILES['book_image']['name'];
		$tmp_dir = $_FILES['book_image']['tmp_name'];
		$imgSize = $_FILES['book_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = '../book_images/'; // upload directory	(folder)
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
			$bookpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['bookPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$bookpic);
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
			$bookpic = $edit_row['bookPic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE books 
									     SET isbn=:bno, 
										     bookName=:bname, 
										     author=:baut,
										     category=:bcat,
										     description=:bdes,
										     quantity=:bqua,
										     bookStatus=:bstat, 
										     bookPic=:bpic
								       WHERE id=:uid');
			$stmt->bindParam(':bno',$isbn);
			$stmt->bindParam(':bname',$bookName);
			$stmt->bindParam(':baut',$author);
			$stmt->bindParam(':bcat',$category);
			$stmt->bindParam(':bdes',$description);
			$stmt->bindParam(':bqua',$quantity);
			$stmt->bindParam(':bstat',$bookStatus);
			$stmt->bindParam(':bpic',$bookpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
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
<div class="right_header">Welcome <?php echo $_SESSION['flName']?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../librarianmodule/reserve.php">RESERVATION HISTORY</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 

<div class="container">


	<div class="page-header">
    	<h1 class="h2">Update Book <a class="btn btn-default" href="../librarianmodule/index.php"> See all books </a></h1>
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
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="isbn" value="<?php echo $isbn; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Book Title:</label></td>
        <td><input class="form-control" type="text" name="bookName" value="<?php echo $bookName; ?>" required /></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Author:</label></td>
        <td><input class="form-control" type="text" name="author" value="<?php echo $author; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Category:</label></td>
    	<td><select name="category" name="category" value="<?php echo $category; ?>">
    		<option><?php echo $category; ?></option>
    		<option>General</option>
    		<option>Philosophy and Psychology</option>
    		<option>Religion</option>
    		<option>Social Sciences</option>
    		<option>Language</option>
    		<option>Natural Science and Maths</option>
    		<option>Technology</option>
    		<option>Arts</option>
    		<option>Literature</option>
    		<option>Geography and History</option>
    		<option>Adventure</option>
    		<option>Sci-Fi and Fantasy</option>
    		<option>Supernatural</option>
    		<option>Romance</option>
    	</select></td>
 <!--       <td><input class="form-control" type="text" name="category" value="<?php echo $category; ?>" required /></td> -->
    </tr>

    <tr>
    	<td><label class="control-label">Description:</label></td>
        <!-- <td><input class="form-control" type="text" name="description" value="<?php echo $description; ?>" required /></td> -->
        <td><textarea name='description' rows="6" cols="30" placeholder="Input description here..."><?php echo $description ?></textarea></td>
    </tr>
    <tr>
    	<td><label class="control-label">Quantity:</label></td>
        <td><input class="form-control" type="number" name="quantity" placeholder="QUANTITY" value="<?php echo $quantity; ?>" /></td>
    </tr>
	<tr>
    	<td><label class="control-label">Book Status:</label></td>
    	<td><select name="bookStatus" value="<?php echo $bookStatus; ?>">
    		<option><?php echo $bookStatus; ?></option>
    		<option>available</option>
    		<option>unavailable</option>
    	</select></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book Img.</label></td>
        <td>
        	<p><img src="../book_images/<?php echo $bookPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="book_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/index.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
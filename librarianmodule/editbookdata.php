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
		$stmt_edit = $DB_con->prepare('SELECT * FROM bookrecord WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: testindex.php");
	}
	
	if(isset($_POST['btn_save_updates']))
	{
		$bookId = $_SESSION['bookId'];
		$isbn = $_POST['isbn'];// isbn
		$bookTitle = $_SESSION['bookTitle'];// book title
		$author = $_SESSION['author'];
		$category = $_SESSION['category'];
		$bookStatus = $_POST['bookStatus'];	
		
		// if no error occured, continue ....

			$stmt = $DB_con->prepare('UPDATE bookrecord 
									     SET bookId=:bbkid,
									     	 isbn=:bisbn, 
										     bookTitle=:btit, 
										     author=:baut,
										     category=:bcat,
										     bookStatus=:bstat
								       WHERE id=:uid');
			$stmt->bindParam(':bbkid',$bookId);
			$stmt->bindParam(':bisbn',$isbn);
			$stmt->bindParam(':btit',$bookTitle);
			$stmt->bindParam(':baut',$author);
			$stmt->bindParam(':bcat',$category);
			$stmt->bindParam(':bstat',$bookStatus);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='testindex.php';
//				window.location.href='testviewbookrecord.php?edit_brecord=<?php echo $row['bookTitle']; ?>';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
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
<div class="right_header">Welcome <?php echo $_SESSION['edit_brecord']?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
    	<h1 class="h2">Update Book Data. <a class="btn btn-default" href="../librarianmodule/testindex.php"> See all book record </a></h1>
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
    	<td><label class="control-label">Book ID.</label></td>
        <td><input class="form-control" type="text" name="bookId" value="<?php echo $_SESSION['bookId']; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="isbn" value="<?php echo $isbn; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Book Title:</label></td>
        <td><input class="form-control" type="text" name="bookTitle" value="<?php echo $_SESSION['bookTitle']; ?>" required /></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Author:</label></td>
        <td><input class="form-control" type="text" name="author" value="<?php echo $_SESSION['author']; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Category:</label></td>
	    <td><input class="form-control" type="text" name="category" value="<?php echo $_SESSION['category']; ?>" required /></td> 
    </tr>

    <tr>
    	<td><label class="control-label">Book Status:</label></td>
    	<td><select name="bookStatus" value="<?php echo $bookStatus; ?>">
    		<option></option>
    		<option>available</option>
    		<option>unavailable</option>
    	</select></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/testindex.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
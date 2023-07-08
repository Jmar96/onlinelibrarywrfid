<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['issue_id']) && !empty($_GET['issue_id']))
	{
		$id = $_GET['issue_id'];
		$stmt_res = $DB_con->prepare('SELECT * FROM reservation WHERE id =:uid');
		$stmt_res->execute(array(':uid'=>$id));
		$edit_row = $stmt_res->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: reserve.php");
	}
	
	if(isset($_POST['btn_save_updates']))
	{
		$reserveBy = $_SESSION['reserveBy'];
		$bookId = $_SESSION['bookId'];
		$bookTitle = $_SESSION['bookTitle'];// book title
		$dateReserve = $_SESSION['dateReserve'];
		$bookPic = $_SESSION['bookPic'];
		$rfidno = $_POST['rfidno'];	
		

		if(empty($rfidno)){
			$errMSG = "Please Tap the RFID.";
		}
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare("INSERT INTO issuedbook(rfid,reserveBy,isbn,bookTitle,dateReserve,dateIssued,bookPic) VALUES(':rfid, :rrby, :isbn, :btit, :rdre, NOW(), :bpic')");
			$stmt->bindParam(':rfid',$rfidno);
			$stmt->bindParam(':rrby',$reserveBy);
			$stmt->bindParam(':isbn',$isbn);
			$stmt->bindParam(':btit',$bookTitle);
			$stmt->bindParam(':rdre',$dateReserve);
			$stmt->bindParam(':bpic',$bookPic);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='testreserve.php';
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
<div class="right_header">Welcome <?php echo $_SESSION['edit_brecord'] ?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
    	<td><label class="control-label">Book Img.</label></td>
        <td>
        	<p><img src="../book_images/<?php echo $_SESSION['bookPic']; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="book_image" accept="image/*" />
        </td>
    </tr>
    <tr>
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="bookId" value="<?php echo $_SESSION['bookId']; ?>" required /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book Title:</label></td>
        <td><input class="form-control" type="text" name="bookTitle" value="<?php echo $_SESSION['bookTitle']; ?>" required /></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Date Reserved:</label></td>
        <td><input class="form-control" type="text" name="author" value="<?php echo $_SESSION['dateReserve']; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">RFID CARD.</label></td>
        <td><input class="form-control" type="text" name="rfidno" value="<?php echo $rfidno; ?>" autofocus /></td>
    </tr>   
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/testreserve.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
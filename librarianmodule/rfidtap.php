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
	
	if(isset($_GET['reserve_id']) && !empty($_GET['reserve_id']))
	{
		$id = $_GET['reserve_id'];
		$stmt_res = $DB_con->prepare('SELECT * FROM reservation WHERE id =:uid');
		$stmt_res->execute(array(':uid'=>$id));
		$save_row = $stmt_res->fetch(PDO::FETCH_ASSOC);
		extract($save_row);
	}
	else
	{
		header("Location: reserve.php");
	}
	
	
	
	if(isset($_POST['btn_save_issued']))
	{
		$crfidno = $_POST['crfidno'];
		$rfidno = $_POST['rfidno'];	
		$reserveBy = $_POST['reserveBy'];
		$bookId = $_POST['bookId'];
		$bookTitle = $_POST['bookTitle'];// book title
		$dateReserve = $_POST['dateReserve'];
									
		if(empty($crfidno)){
			$errMSG = "Please Tap the RFID.";
		}
		if($crfidno != $rfidno){
			$errMSG = "Your RFID no. didnt match!";
		}
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare("INSERT INTO issuedbook(rfid,borrowedBy,isbn,bookTitle,dateReserve,dateIssued,returnDuedate) VALUES(:rrfid, :rrby, :bisbn, :btit, :rdre, now(),now() + INTERVAL 7 DAY)");
			$stmt->bindParam(':rrfid',$rfidno);
			$stmt->bindParam(':rrby',$reserveBy);
			$stmt->bindParam(':bisbn',$bookId);
			$stmt->bindParam(':btit',$bookTitle);
			$stmt->bindParam(':rdre',$dateReserve);

			if ($stmt->execute()){
				$stmt_delete = $DB_con->prepare("DELETE FROM reservation WHERE id = :did");
				$stmt_delete->bindParam(':did',$id);
				
				if($stmt_delete->execute()){
					?>
	                <script>
					alert('Successfully Inserted ...');
					window.location.href='reserve.php';
					</script>
	                <?php
				}
				else{
					$errMSG = "Sorry Data Could Not Inserted !";
				}
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
input:focus {
    background-color: yellow;
}
</style>
</head>
<body bgcolor=#ccd9ff>
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a class="current" href="#">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../librarianmodule/reserve.php">RESERVATION</a></li>
		<li><a class="current" href="../librarianmodule/rfidtap.php">TAP RFID</a></li>
		<li><a href="../librarianmodule/issuedrecords.php">ISSUED RECORDS</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 

<div class="container">


	<div class="page-header">
    	<br><h1 class="h2">&nbsp;BORROW BOOK <a class="btn btn-default" href="../librarianmodule/index.php"> See all books </a></h1>
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
    	<td><label class="control-label">RFID Card.</label></td>
        <td><input class="form-control" type="text" id="crfidno" name="crfidno" placeholder="Tap the RFID Card" value="<?php echo $crfidno; ?>" autofocus /></td>
    </tr>
    <tr>
    	<td><label class="control-label">ID No.</label></td>
        <td><input class="form-control" type="text" id="rfidno" name="rfidno" value="<?php echo $rfidNo ?>" required / readonly></td>
    </tr>
	<tr>
    	<td><label class="control-label">Reserved By.</label></td>
        <td><input class="form-control" type="text" name="reserveBy" value="<?php echo $reserveBy ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="bookId" value="<?php echo $bookId; ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book Name(Title):</label></td>
        <td><input class="form-control" type="text" name="bookTitle" value="<?php echo $bookTitle; ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">Date Reserved:</label></td>
        <td><input class="form-control" type="text" name="dateReserve" value="<?php echo $dateReserve; ?>" required / readonly></td>
    </tr>

    <tr>
<!--   	<td><label class="control-label">Book Img.</label></td>
        <td>
        	<p><img src="../book_images/<?php echo $bookPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="book_image" accept="image/*" />
        </td>
    </tr>  -->
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_issued" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/reserve.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
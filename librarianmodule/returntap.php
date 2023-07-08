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
	
	if(isset($_GET['return_id']) && !empty($_GET['return_id']))
	{
		$id = $_GET['return_id'];
		$stmt_res = $DB_con->prepare('SELECT * FROM issuedbook WHERE id =:uid');
		$stmt_res->execute(array(':uid'=>$id));
		$save_row = $stmt_res->fetch(PDO::FETCH_ASSOC);
		extract($save_row);
	}
	else
	{
		header("Location: reserve.php");
	}
	
	//
	
	if(isset($_POST['btn_save_issued']))
	{
		$cfrfid = $_POST['cfrfid'];
		$rfidno = $_POST['rfidno'];	
		$returnBy = $_POST['borrowedBy'];
		$isbn = $_POST['isbn'];
		$bookTitle = $_POST['bookTitle'];// book title
		$dateReserve = $_POST['dateReserve'];
		$dateIssued = $_POST['dateIssued'];
									
		if(empty($cfrfid)){
			$errMSG = "Please Tap the RFID.";
		}
		if(empty($rfidno)){
			$errMSG = "The RFID in previous transaction didnt tap or incode!..";
		}
		if($cfrfid != $rfid){
			$errMSG = "<h4>Your RFID didnt match to the RFID in previous transaction! <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8594; ".$cfrfid." != ".$rfid."</h4>";
		}
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare("INSERT INTO returnbook(rfidNumber,returnBy,isbn,bookTitle,dateReserve,dateIssued,dateReturn) VALUES(:rrfid, :rrby, :bisbn, :btit, :rdre, :ids, now())");
			$stmt->bindParam(':rrfid',$rfidno);
			$stmt->bindParam(':rrby',$returnBy);
			$stmt->bindParam(':bisbn',$isbn);
			$stmt->bindParam(':btit',$bookTitle);
			$stmt->bindParam(':rdre',$dateReserve);
			$stmt->bindParam(':ids',$dateIssued);
				
			if($stmt->execute()){
				//$id = $_GET['return_id'];
				$stmt_delete = $DB_con->prepare("DELETE FROM issuedbook WHERE id = :did");
				$stmt_delete->bindParam(':did',$id);
				//$stmt_delete = $DB_con->(array(':did'=>$id));
				if($stmt_delete->execute()){
					$stmt_update = $DB_con->prepare("UPDATE books SET quantity = quantity + 1 WHERE isbn=:bisbn");
					$stmt_update->bindParam(':bisbn',$isbn);
					if($stmt_update->execute()){
						?>
		                <script>
						alert('Successfully Receive ...');
						window.location.href='issuedrecords.php';
						</script>
		                <?php
		            }
	            }
			}
			else{
				$errMSG = "Sorry Data Could Not Inserted !";
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
		<li><a href="../librarianmodule/reserve.php">RESERVATION HISTORY</a></li>
		<li><a class="current" href="../librarianmodule/rfidtap.php">TAP RFID</a></li>
		<li><a href="../librarianmodule/issuedrecords.php">ISSUED RECORDS</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 

<div class="container">


	<div class="page-header">
    	<h1 class="h2">RETURN BOOK. <a class="btn btn-default" href="../librarianmodule/index.php"> See all books </a></h1>
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
    	<td><label class="control-label">CONFIRM RFID.</label></td>
        <td><input class="form-control" type="text" id="cfrfid" name="cfrfid" placeholder="Tap to confirm RFID" value="<?php echo $cfrfid; ?>" autofocus /></td>
    </tr>
	<tr>
    	<td><label class="control-label">RFID Card.</label></td>
        <td><input class="form-control" type="text" id="rfidno" name="rfidno" placeholder="Tap the RFID Card" value="<?php echo $rfid; ?>" / readonly></td>
    </tr>
	<tr>
    	<td><label class="control-label">Reserved By.</label></td>
        <td><input class="form-control" type="text" name="borrowedBy" value="<?php echo $borrowedBy; ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="isbn" value="<?php echo $isbn; ?>" required / readonly></td>
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
    	<td><label class="control-label">Date Issued:</label></td>
        <td><input class="form-control" type="text" name="dateIssued" value="<?php echo $dateIssued; ?>" required / readonly></td>
    </tr>

<!--    <tr>
   	<td><label class="control-label">Book Img.</label></td>
        <td>
        	<p><img src="../book_images/<?php echo $bookPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="book_image" accept="image/*" />
        </td>
    </tr>  -->
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_issued" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Receive
        </button>
        
        <a class="btn btn-default" href="../librarianmodule/issuedrecords.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>

</div>
</body>
</html>
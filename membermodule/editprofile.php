<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['memId']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT memberId, password, fullname, address, contactNo, emailAddress, userStatus, retrieve, userPic FROM member WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: ../membermodule/memprofile.php");
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
			$stmt = $DB_con->prepare('UPDATE member 
									     SET memberId=:mid, 
										     password=:lpas,
										     fullname=:lfna,
										     address=:ladd,
										     contactNo=:lcon,
										     emailAddress=:lema,
										     userStatus=:lsta,
										     retrieve=:lret, 
										     userPic=:lpic 
								       WHERE id=:uid');
			$stmt->bindParam(':mid',$memberId);
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
				window.location.href='memprofile.php';
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
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutlib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="../membermodule/memprofile.php">PROFILE</a> </li>
		<li><a  href="../membermodule/index.php">BOOK LIST</a></li>
		<li><a href="../logouts/logoutmem.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
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
    	<td><label class="control-label">Member ID : </label></td>
        <td><input class="form-control" type="text" name="user_mid" value="<?php echo $memberId; ?>"  / readonly></td>
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
        <td><input class="form-control" type="text" name="user_stat" value="<?php echo $userStatus; ?>" readonly /></td>
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
        
        <a class="btn btn-default" href="memprofile.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
</div>
</div>
<div class="right_content">
<?php
//RECORDS FOR RESERVATION
	include('../includes/connect2.php');
	$query = "select count(*) from reservation";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 5;
	$totalpages = ceil($numrows/$rowsperpage);
	
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
	{
		$currentpage = (int) $_GET['currentpage'];
	}
	else{
		$currentpage = 1;
	}
	if ($currentpage > $totalpages){
		$currentpage = $totalpages;
	}
	if ($currentpage <1){
		$currentpage =1;
	}
	$offset = ($currentpage-1)*$rowsperpage;
	//set epr to null
	$epr='';

	if(isset($_GET['epr']))
		$epr=$_GET['epr'];

	if($epr=='cancelup'){
		$id=$_POST['textid']; 
		$reserveBy=$_POST['textrb'];
		$bookId=$_POST['textbid'];
		$bookTitle=$_POST['textit'];
		//$dateReserve=$_POST['textdr'];
		//$reserveExp=$_POST['textre'];

		$id=$_POST['textid'];
		if ($reserveBy==''||$bookId==''||$bookTitle==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("UPDATE books SET quantity=quantity + 1 WHERE isbn='$bookId'");
			if ($a_sql){
				$delete=mysql_query("DELETE from reservation where id='$id'");
				if($delete){
					$successMSG = "<center>The reservation is successfully canceled</center>";
					header("refresh:1;editprofile.php");
				}else{
					$msg='ERROR:'.mysql_error();
				}
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}

?>
<?php
	if($epr=='rcancel'){
		$id = $_GET['id'];
		$row6=mysql_query("SELECT r.*,b.description,b.isbn,b.bookPic FROM reservation AS r LEFT JOIN books AS b ON r.bookId = b.isbn WHERE r.id='$id' ");
		$st_row=mysql_fetch_array($row6);
?>
<h3 align="center">CANCEL RESERVATION</h3>
<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
				<strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
				<strong><?php echo $successMSG; ?></strong>
        </div>
        <?php
	
	}
?>  
<form method="POST" action='editprofile.php?epr=cancelup'>
	<table align="center">
		<tr>
			<td></td>
			<td><input type='hidden' name='textid' value="<?php echo $st_row['id'] ?>"/ readonly></td>
		</tr>
		<tr>
			<!--<td>RFID :</td> -->
			<td><input type='hidden' name='textrb' value="<?php echo $st_row['rfidNo'] ?>"/ readonly></td>
		</tr>
		<tr>
			<!-- <td>RESERVE BY :</td> -->
			<td><input type='hidden' name='textrb' value="<?php echo $st_row['reserveBy'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td>ISBN :</td>
			<td><input type='text' name='textbid' value="<?php echo $st_row['bookId'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td>TITLE :</td>
			<td><input type='text' name='textit' value="<?php echo $st_row['bookTitle'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td>Details:</td>
			<td><textarea name='textde' rows="4" cols="22" readonly><?php echo $st_row['description'] ?></textarea></td>
		</tr>
		<tr>
			<td>Reservation Date:</td>
			<td><input type='text' name='textdr' value="<?php echo $st_row['dateReserve'] ?>"/></td>
		</tr>
		<!-- <tr>
			<td>Expiration:</td>
			<td><input type='text' name='textre' value="<?php echo $st_row['reserveExp'] ?>"/></td>
		</tr> -->
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='DELETE'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='CANCEL' onClick="window.location='../membermodule/editprofile.php';" /></td>
		</tr>
	</table>
</form>

<?php }else{
?>
<?php } ?>
<!--<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div> -->
<h2>&nbsp;&nbsp;&nbsp;Reservation History</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>RFID No.</th>
		<th>ISBN</th>
		<th>TITLE</th>
		<th>DATE RESERVE</th>
		<th>EXPIRATION DATE</th>
		<th>ACTION</th>
	</thead>
	<tbody>
	<?php
	if(isset($_POST['search1'])){
		$search=$_POST['search'];
		$query=mysql_query("SELECT * FROM reservation WHERE  bookTitle like '%{$search}' || dateReserve like '%{$search}' || reserveExp like '%{$search}' and rfidNo = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($query) > 0){
				while ($row = mysql_fetch_array($query)) {
				echo "<tr>
					<td>".$row['rfidNo']."</td>
					<td>".$row['bookId']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['reserveExp']."</td>
					<td align='center'>
						 <a href='editprofile.php?epr=rcancel&id=".$row['id']."'>CANCEL</a> 
					</td>
				</tr>";
			}	
		}else{
			echo "<h2>No Reserved Book yet!</h2>";
		}
	}else{
		$stmt = mysql_query("SELECT * FROM reservation WHERE rfidNo = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
				while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['rfidNo']."</td>
					<td>".$row['bookId']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['reserveExp']."</td>
					<td align='center'>
						 <a href='memprofile.php?epr=rcancel&id=".$row['id']."'>CANCEL</a> 
					</td>
				</tr>";
			}	
		}else{
			echo "<h2>No Reserved Book yet!</h2>";
		}
	}
	?>
	</tbody>
</table>
<br>
<center>
<?php
	if($currentpage>1){
		echo "<a href=' {$_SERVER['PHP_SELF']}?currentpage=1'>First</a> &nbsp;&nbsp;";
		$prevpage = $currentpage -1;
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a>&nbsp;&nbsp;";
	}
	$range = 3;
	for($x=($currentpage - $range);$x<(($currentpage + $range)+1);$x++){
		if (($x>0) && ($x<=$totalpages)){
			if ($x==$currentpage){
				echo " [<b> $x </b>]&nbsp;&nbsp;";
			}else{
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a>&nbsp;&nbsp;";
			}
		}
	}
	if ($currentpage!=$totalpages){
		$nextpage = $currentpage + 1;
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a>&nbsp;&nbsp;";
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a>";
	}
?>
</center>
<br>
<?php
//RECORDS FOR BORROWED BOOKS
	include('../includes/connect2.php');
	$query = "select count(*) from issuedbook";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 5;
	$totalpages = ceil($numrows/$rowsperpage);
	
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
	{
		$currentpage = (int) $_GET['currentpage'];
	}
	else{
		$currentpage = 1;
	}
	if ($currentpage > $totalpages){
		$currentpage = $totalpages;
	}
	if ($currentpage <1){
		$currentpage =1;
	}
	$offset = ($currentpage-1)*$rowsperpage;
?>
<!--<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div> -->
<h2>&nbsp;&nbsp;&nbsp;Book Borrowed</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>RFID No.</th>
		<th>ISBN</th>
		<th>TITLE</th>
		<th>DATE RESERVE</th>
		<th>DATE BORROW</th>
		<th>RETURN DUE DATE</th>
		
	</thead>
	<tbody>
	<?php
	if(isset($_POST['search1'])){
		$search=$_POST['search'];
		$query=mysql_query("SELECT * FROM issuedbook WHERE  isbn like '%{$search}' || bookTitle like '%{$search}' || dateReserve like '%{$search}' || reserveExp like '%{$search}' and rfid = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($query) > 0){
				while ($row = mysql_fetch_array($query)) {
				echo "<tr>
					<td>".$row['rfid']."</td>
					<td>".$row['bookId']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['reserveExp']."</td>
					<td>".$row['returnDuedate']."</td>
					
				</tr>";
			}	
		}else{
			echo "<h2>No Borrowed Book yet!</h2>";
		}
	}else{
		$stmt = mysql_query("SELECT * FROM issuedbook WHERE rfid = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
				while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['rfid']."</td>
					<td>".$row['isbn']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['dateIssued']."</td>
					<td>".$row['returnDuedate']."</td>
					
				</tr>";
			}	
		}else{
			echo "<h2>No Borrowed Book yet!</h2>";
		}
	}
	?>
	</tbody>
</table>
<br>
<center>
<?php
	if($currentpage>1){
		echo "<a href=' {$_SERVER['PHP_SELF']}?currentpage=1'>First</a> &nbsp;&nbsp;";
		$prevpage = $currentpage -1;
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a>&nbsp;&nbsp;";
	}
	$range = 3;
	for($x=($currentpage - $range);$x<(($currentpage + $range)+1);$x++){
		if (($x>0) && ($x<=$totalpages)){
			if ($x==$currentpage){
				echo " [<b> $x </b>]&nbsp;&nbsp;";
			}else{
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a>&nbsp;&nbsp;";
			}
		}
	}
	if ($currentpage!=$totalpages){
		$nextpage = $currentpage + 1;
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a>&nbsp;&nbsp;";
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a>";
	}
?>
</center>
<br>
<?php
//RECORDS FOR BORROWED BOOKS
	include('../includes/connect2.php');
	$query = "select count(*) from issuedbook";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 5;
	$totalpages = ceil($numrows/$rowsperpage);
	
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
	{
		$currentpage = (int) $_GET['currentpage'];
	}
	else{
		$currentpage = 1;
	}
	if ($currentpage > $totalpages){
		$currentpage = $totalpages;
	}
	if ($currentpage <1){
		$currentpage =1;
	}
	$offset = ($currentpage-1)*$rowsperpage;
?>
<!--<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div> -->
<h2>&nbsp;&nbsp;&nbsp;Book Return History</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>RFID No.</th>
		<th>ISBN</th>
		<th>TITLE</th>
		<th>DATE RESERVE</th>
		<th>DATE BORROW</th>
		<th>DATE RETURN</th>
		
	</thead>
	<tbody>
	<?php
		$stmt = mysql_query("SELECT * FROM returnbook WHERE rfidNumber = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
				while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['rfidNumber']."</td>
					<td>".$row['isbn']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['dateIssued']."</td>
					<td>".$row['dateReturn']."</td>
					
				</tr>";
			}	
		}else{
			echo "<h2>No Return Book yet!</h2>";
		}
	
	?>
	</tbody>
</table>
<br>
<center>
<?php
	if($currentpage>1){
		echo "<a href=' {$_SERVER['PHP_SELF']}?currentpage=1'>First</a> &nbsp;&nbsp;";
		$prevpage = $currentpage -1;
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a>&nbsp;&nbsp;";
	}
	$range = 3;
	for($x=($currentpage - $range);$x<(($currentpage + $range)+1);$x++){
		if (($x>0) && ($x<=$totalpages)){
			if ($x==$currentpage){
				echo " [<b> $x </b>]&nbsp;&nbsp;";
			}else{
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a>&nbsp;&nbsp;";
			}
		}
	}
	if ($currentpage!=$totalpages){
		$nextpage = $currentpage + 1;
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a>&nbsp;&nbsp;";
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a>";
	}
?>
</center>
<br>
<?php
//RECORDS FOR BORROWED BOOKS
	include('../includes/connect2.php');
	$query = "select count(*) from issuedbook";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 5;
	$totalpages = ceil($numrows/$rowsperpage);
	
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
	{
		$currentpage = (int) $_GET['currentpage'];
	}
	else{
		$currentpage = 1;
	}
	if ($currentpage > $totalpages){
		$currentpage = $totalpages;
	}
	if ($currentpage <1){
		$currentpage =1;
	}
	$offset = ($currentpage-1)*$rowsperpage;
?>
<!--<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div> -->
<h2>&nbsp;&nbsp;&nbsp;Cancelled Reservation History</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>RFID No.</th>
		<th>ISBN</th>
		<th>TITLE</th>
		<th>DATE RESERVE</th>
		<th>DATE CANCELLED</th>
		
	</thead>
	<tbody>
	<?php
		$stmt = mysql_query("SELECT * FROM cancelledreserve WHERE rfidNu = '{$_SESSION['memId']}' ORDER BY id DESC limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
				while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['rfidNu']."</td>
					<td>".$row['bookId']."</td>
					<td>".$row['bookTitle']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['dateCancelled']."</td>
				</tr>";
			}	
		}else{
			echo "<h2>No Cancelled Reservation yet!</h2>";
		}
	
	?>
	</tbody>
</table>
<br>
<center>
<?php
	if($currentpage>1){
		echo "<a href=' {$_SERVER['PHP_SELF']}?currentpage=1'>First</a> &nbsp;&nbsp;";
		$prevpage = $currentpage -1;
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a>&nbsp;&nbsp;";
	}
	$range = 3;
	for($x=($currentpage - $range);$x<(($currentpage + $range)+1);$x++){
		if (($x>0) && ($x<=$totalpages)){
			if ($x==$currentpage){
				echo " [<b> $x </b>]&nbsp;&nbsp;";
			}else{
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a>&nbsp;&nbsp;";
			}
		}
	}
	if ($currentpage!=$totalpages){
		$nextpage = $currentpage + 1;
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a>&nbsp;&nbsp;";
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a>";
	}
?>
</center>
<br>
</div> 

</div>
</body>
</html>
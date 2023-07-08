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
include ("../includes/connect6.php");
//**** END Database connection script

//**** START Clean out expired reservations and add + 1 to quantity
//**** Amount of time that reservations are held is set here 3 HOUR
// Get list of expired seats from 1 table and original number of seats from another table
//r. is the reservation table while a. is the books table
$clean = "SELECT r.*, b.quantity FROM reservation AS r 
		LEFT JOIN books AS b ON b.isbn = r.bookId 
		WHERE r.dateReserve < (NOW() - INTERVAL 3 HOUR)";
$freequery = mysqli_query($connect, $clean) or die (mysqli_error($connect));
$num_check = mysqli_num_rows($freequery);
if ($num_check != 0){
	while ($row = mysqli_fetch_array($freequery, MYSQLI_ASSOC)){
		$bkid = $row['bookId'];
		$btit = $row['bookTitle'];
		$bid = $row['id'];	
		//$brestat = $row['bookStatus'];
		$resby = $row['reserveBy'];
		$bquan = $row['quantity'];
		$quantity = $bquan + 1;
		//$astat = "available";
		// Add back the expired reserves $dS is the numseats
		//$updateAvailable = $originalavail + $dS;

		// Delete the reservation transaction
		$sql3 = "DELETE FROM reservation WHERE bookId='$bkid' LIMIT 1";
		$query3 = mysqli_query($connect, $sql3);
		// Update the database set bookStatus to available
		$sql3 = "UPDATE books SET quantity='$quantity' WHERE isbn='$bkid' LIMIT 1";
		$query3 = mysqli_query($connect, $sql3);
	}
}
?>

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
	<title><?php echo $_SESSION['memId']?></title>
</head>
<!-- <?php

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
		
		$imgFile = $_FILES['book_image']['name'];
		$tmp_dir = $_FILES['book_image']['tmp_name'];
		$imgSize = $_FILES['book_image']['size'];
		
		
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
?> -->
<body bgcolor="lightgreen">
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="../membermodule/memprofile.php">PROFILE</a> </li>
<!--		<li><a href="../membermodule/memreservation.php">TRANSACTION</a> </li> -->
		<li><a href="../membermodule/index.php">BOOK LIST</a></li>
		<li><a href="../logouts/logoutmem.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="left_content">
<?php
//	include('../includes/connect2.php');
//	$stmt=mysql_query("SELECT * from librarian where username like '$username' ");
	
//	echo "this is the value of session -> ".$_SESSION['userName'];
	echo "<br/><br/>"; //double space
	require_once '../includes/connect5.php';
	$username=$_SESSION['userName'];
	$stmt = $DB_con->prepare('SELECT * FROM member where memberId = ? ');
	$stmt->execute(array($_SESSION['memId']));
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				
			&nbsp;<img src="../user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
				
			<!--	
			<p class="page-header"><?php echo $memberId."&nbsp;/&nbsp;".$fullname; ?></p> -->
				<tr>
				<td><label class="control-label">Member ID : </label></td>
				<td><input type="text" name="" value="<?php echo $memberId; ?>" readonly></td><br/>
				</tr>
				<tr>
				<td><label class="control-label">Fullname : &nbsp;&nbsp;</label></td>
				<td><input type="text" name="" value="<?php echo $fullname; ?>" readonly></td>
				</tr>
				<p class="page-header">
				<span>
				&nbsp;&nbsp;<a class="btn btn-info" href="editprofile.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" "><span class="glyphicon glyphicon-edit"></span>Update</a>
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
<h2>FEEDBACKS AND REPORTS</h2>
<form method="POST" action='madreports.php?epr=save'>
	<table align="center">
		<tr>
			<td>From:</td>
			<td><input type='text' name='textf' value="<?php echo $_SESSION['userName'];?>" readonly>
			</td>
		</tr>
<!--		<tr>
			<td>Date:</td>
			<td><input type='date' name='textda'></td>
		</tr> -->
		<tr>
			<td>Details:</td>
			<!--<td><input type='text' name='textde'></td>
			<td><textarea rows="4" cols="50" name="comment" form="usrform"></td> -->
			<td><textarea name='textde' rows="4" cols="22" placeholder="Input details here..."></textarea></td>
		</tr>
<!--		<tr>
			<td>Status :</td>
			<td align='center'><input type='text' value="new" name='textsta' readonly></td>
		</tr> -->
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='ADD RECORD'></td>
		</tr>
	</table>
</form>

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
		$reserveBy=$_POST['textrfb'];
		$bookId=$_POST['textbid'];
		$bookTitle=$_POST['textit'];
		$dateReserve=$_POST['textdr'];
		$fullname = $_SESSION['userName'];
		//$reserveExp=$_POST['textre'];

		$id=$_POST['textid'];
		if ($reserveBy==''||$bookId==''||$bookTitle==''){
			$errMSG = "<center>Data Incomplete.</center>";
		}
		else{
			$rmove = mysql_query("INSERT INTO cancelledreserve values('','$reserveBy','$fullname','$bookId','$bookTitle','$dateReserve',now())");
			if ($rmove){
				$a_sql=mysql_query("UPDATE books SET quantity=quantity + 1 WHERE isbn='$bookId'");
				if ($a_sql){
					$delete=mysql_query("DELETE from reservation where id='$id'");
					if($delete){
						$successMSG = "<center>The reservation is successfully canceled</center>";
						header("refresh:1;memprofile.php");
					}else{
						$msg='ERROR:'.mysql_error();
					}
				}
				else{
					$msg='ERROR:'.mysql_error();
				}
			}else{
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
<form method="POST" action='memprofile.php?epr=cancelup'>
	<table align="center">
		<tr>
			<td></td>
			<td><input type='hidden' name='textid' value="<?php echo $st_row['id'] ?>"/ readonly></td>
		</tr>
		<tr>
			<!--<td>RFID :</td> -->
			<td><input type='hidden' name='textrfb' value="<?php echo $st_row['rfidNo'] ?>"/ readonly></td>
		</tr>
		<tr>
			<!-- <td>RESERVE BY :</td> -->
			<td><input type='hidden' name='textrb' value="<?php echo $st_row['reserveBy'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td colspan="2"><center><img src="../book_images/<?php echo $st_row['bookPic']; ?>" align="center" class="img-rounded" width="100px" height="100px" /> </center></td>
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
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='CANCEL'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='BACK' onClick="window.location='../membermodule/memprofile.php';" /></td>
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
						<!--<a onClick=\"javascript: return confirm('Please confirm for canceling reservation...');\"href='memprofile.php?epr=rcancel&id=".$row['id']."'>CANCEL</a> -->
						<a href='memprofile.php?epr=rcancel&id=".$row['id']."'>CANCEL</a>
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
</div>
</body>
</html>
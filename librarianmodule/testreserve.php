<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
//$selected_brecord = $_GET['edit_brecord']; // get edit_brecord from testindex.php
//$_SESSION['edit_brecord'] = $_GET['edit_brecord'];
?>
<?php
include ("../includes/connect6.php");
//**** END Database connection script

//**** START Clean out expired reservations
//**** Amount of time that reservations are held is set here 3 HOUR
// Get list of expired seats from 1 table and original number of seats from another table
//r. is the reservation table while a. is the books table
$clean = "SELECT r.*, b.bookStatus FROM reservation AS r 
		LEFT JOIN books AS b ON b.isbn = r.bookId 
		WHERE r.dateReserve < (NOW() - INTERVAL 3 HOUR)";
$freequery = mysqli_query($connect, $clean) or die (mysqli_error($connect));
$num_check = mysqli_num_rows($freequery);
if ($num_check != 0){
	while ($row = mysqli_fetch_array($freequery, MYSQLI_ASSOC)){
		$bkid = $row['bookId'];
		$btit = $row['bookTitle'];
		$bid = $row['id'];	
		$brestat = $row['bookStatus'];
		$resby = $row['reserveBy'];
		$astat = "available";
		// Add back the expired reserves $dS is the numseats
		//$updateAvailable = $originalavail + $dS;

		// Delete the reservation transaction
		$sql3 = "DELETE FROM reservation WHERE bookId='$bkid' LIMIT 1";
		$query3 = mysqli_query($connect, $sql3);
		// Update the database set bookStatus to available
		$sql3 = "UPDATE books SET bookStatus='$astat' WHERE isbn='$bkid' LIMIT 1";
		$query3 = mysqli_query($connect, $sql3);
	}
}
?>
<?php

	require_once '../includes/connect5.php';
	
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT bookPic FROM bookrecord WHERE id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("../book_images/".$imgRow['bookPic']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM bookrecord WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: ../librarianmodule/testviewbookrecord.php");
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
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
    	<h1 class="h2">All Books. /
		 <a class="btn btn-default" href="../librarianmodule/addbookdata.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp; add new </a></h1> 
    </div>
    
<br />

<div class="row">
<?php
	
	$stmt = $DB_con->prepare("SELECT * FROM reservation ORDER BY id DESC");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" /> -->
				<p class="page-header"><?php echo "Reserve By : &nbsp;" .$reserveBy."&nbsp;&nbsp;ISBN : &nbsp;&nbsp;".$bookId; ?></p>
				<p class="page-header"><label class="control-label"><?php echo $bookTitle; ?></label></p>
				<p class="page-header"><label class="control-label"><?php echo $dateReserve; ?></label></p>
				<p class="page-header"><label class="control-label"><?php echo $reserveExp; ?></label></p>
				<p class="page-header">
				<span>
				<?php 
				$_SESSION['reserveBy'] = $reserveBy;
				$_SESSION['bookId'] = $bookId;
				$_SESSION['bookTitle'] = $bookTitle;
				$_SESSION['dateReserve'] = $dateReserve;
				$_SESSION['bookPic'] = $bookPic; ?>
				<a class="btn btn-info" href="testrfidtap.php?issue_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('Sure to Issue ?')"><span class="glyphicon glyphicon-edit"></span> Issue Book</a> 
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
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
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
	}
	
?>
</div>	




</div>


</div>
</div>
</body>
</html>
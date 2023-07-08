<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Module</title>
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
		<li><a href="../membermodule/memprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../membermodule/index.php">BOOK LIST</a></li>
		
		
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="container">

	<div class="page-header">
    	<h1 class="h2"><br/><center>--BOOKS--</center></h1> 
    </div>
<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div>
    
<br />
<div class="row">

<?php
require_once '../includes/connect5.php';
$astat = "available";
if(isset($_POST['search1'])){
	$search=$_POST['search'];
	// select from books where data like search and bookStatus = available
	$stmt = $DB_con->prepare("SELECT * FROM books WHERE isbn like '%{$search}%' || bookName like '%{$search}%' || author like '%{$search}%' || category like '%{$search}%' || description like '%{$search}%' AND bookStatus = '$astat' ORDER BY id DESC");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{	
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 
<!--				<a class="btn btn-info" href="reservebook.php?reserve=<?php echo $row['bookName']; ?>" title="click for edit" onclick="return confirm('Redirect to the Book Records ?')"><span class="glyphicon glyphicon-edit"></span> RESERVE</a>  -->
				</span></p>
<!--				<p class="page-header"><label class="control-label">Author : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $author; ?></p>
				<p class="page-header"><label class="control-label">Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $category; ?></p>
				<p class="page-header"><label class="control-label"><?php echo $description; ?></label></p>		-->
<!--<?php ?> for updating bookStatus
				<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p> -->
				<p class="page-header">	
				<span>&nbsp;&nbsp;
<!--			<?php $_SESSION['bookId'] = $bookId; 
				$_SESSION['bookTitle'] = $bookTitle; ?> 
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span>Reserve</a> 
			<a class="btn btn-info" href="reservebook.php?reserve=<?php echo $row['bookTitle']; ?>" title="click for edit" onclick="return confirm('Redirect to the Book Records ?')"><span class="glyphicon glyphicon-edit"></span> RESERVE</a>  -->
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


}else{
$astat = "available";
	$stmt = $DB_con->prepare("SELECT * FROM books WHERE bookStatus = '$astat' ORDER BY id DESC");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 
<!--				<a class="btn btn-info" href="reservebook.php?reserve=<?php echo $row['bookName']; ?>" title="click for edit" onclick="return confirm('Redirect to the Book Records ?')"><span class="glyphicon glyphicon-edit"></span> RESERVE</a>  -->
				</span></p>
<!--				<p class="page-header"><label class="control-label">Author : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $author; ?></p>
				<p class="page-header"><label class="control-label">Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $category; ?></p>
				<p class="page-header"><label class="control-label"><?php echo $description; ?></label></p>		-->
<!--<?php ?> for updating bookStatus
				<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p> -->
				<p class="page-header">	
				
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
}
	
?>
</div>	




</div>


</div>
</div>
</body>
</html>
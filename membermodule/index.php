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
//update bookstatus to unavailable
$qupdate = "SELECT * FROM books WHERE quantity < 2";
$quanquery = mysqli_query($connect,$qupdate) or die (mysql_error($connect));
$quan_check = mysqli_num_rows($quanquery);
if ($quan_check != 0){
	while ($row = mysqli_fetch_array($quanquery, MYSQLI_ASSOC)){
		$bkno = $row['isbn'];
		$ustat = "unavailable";
		//update the database set bookStatus to unavailable
		$sql2 = "UPDATE books SET bookStatus = '$ustat' WHERE isbn = '$bkno' LIMIT 1";
		$query2 = mysqli_query($connect, $sql2);
	}
}
?>
<?php
include ("../includes/connect6.php");
//update bookstatus to unavailable
$qupdate = "SELECT * FROM books WHERE quantity > 1";
$quanquery = mysqli_query($connect,$qupdate) or die (mysql_error($connect));
$quan_check = mysqli_num_rows($quanquery);
if ($quan_check != 0){
	while ($row = mysqli_fetch_array($quanquery, MYSQLI_ASSOC)){
		$bkno = $row['isbn'];
		$astat = "available";
		//update the database set bookStatus to unavailable
		$sql2 = "UPDATE books SET bookStatus = '$astat' WHERE isbn = '$bkno' LIMIT 1";
		$query2 = mysqli_query($connect, $sql2);
	}
}
?>
<?php
include ("../includes/connect6.php");
//**** END Database connection script

//**** START Clean out expired reservations and add 1 to the quantity in books
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
div#categ {
	background-color: #99e6ff;
}
div#categ a{
	text-decoration:none;
	color: #000000;
	font-weight: bold;
	font-size: 20px;
	padding: 15px;
	display: inline-block;
}
ul#clist {
	display: inline;
	margin: 0;
	padding: 0;
}
ul#clist li {display: inline-block;}
ul#clist li:hover {background-color: #33ccff;}
ul#clist li:hover ul {display:block;}
ul#clist li ul {
	position: absolute;
	width: 200px;
	display: none;
}
ul#clist li ul li {
	background: #99e6ff;
	display: block;
}
ul#clist li ul li a {display: block !important;}
ul#clist li ul li:hover {background: #33ccff;}

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

<div class="left_content">
<div id="categ">
<ul id="clist">
<li><a name="C">Categories  &nbsp;&#8681;</a>
	<ul>
	<?php
	require_once '../includes/connect5.php';
	$book_categories = $DB_con->prepare("SELECT * FROM bcategories ORDER BY catTitle");
	$book_categories->execute();
	if($book_categories->rowCount() > 0){
		while($row=$book_categories->fetch(PDO::FETCH_ASSOC)){
			extract($row);
	?>
		<li>
			<form action="" method="post">
			<input type="submit" name="search2" value="<?php echo $row['catTitle'];?>">

			</form>
		</li>
	<?php
		}
	}
	?>		
	</ul>
</li>
</ul>
</div>
<!-- <div><br>
<form action="" method="post">
	<select name="search2" >
	<option>CATEGORIES</option>
	<?php
	require_once '../includes/connect5.php';
	$book_categories = $DB_con->prepare("SELECT * FROM bcategories ORDER BY catTitle");
	$book_categories->execute();
	if($book_categories->rowCount() > 0){
		while($row=$book_categories->fetch(PDO::FETCH_ASSOC)){
			extract($row);
	?>
	<option>
		<?php echo $row['catTitle'];?>
	</option>
	<?php
		}
	}
	?>	
	</select>
	<input type="submit" value=">">
</form>
</div> -->
</div>
<div class="right_content">
<div class="container">
<div>
<?php
	if(isset($banMSG)){
			?>
            <div class="alert alert-danger">
				<strong><?php echo $banMSG; ?></strong>
            </div>
            <?php
	}
?>
</div>

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
				<a href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" >
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				</a>
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> 
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" "><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 
				</span></p>


				<p class="page-header">	
				<span>&nbsp;&nbsp;
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

}else if (isset($_POST['search2'])){
	$csearch = $_POST['search2'];
	$stmt = $DB_con->prepare("SELECT * FROM books WHERE category like '%{$csearch}%' ORDER BY bookName");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{	
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<a href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" >
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				</a>
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> 
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" "><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 
				</span></p>


				<p class="page-header">	
				<span>&nbsp;&nbsp;
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
				<a href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" >
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				</a>
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" "><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 

				</span></p>
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
</div>
</body>
</html>
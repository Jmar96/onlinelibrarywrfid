<?php 
session_start();
if(!$_SESSION['flName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['librId']){
	header('refresh:0.10;../cheatingmsg.php');
}
//$userName = $_SESSION['userName'];
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
	<title>Librarian Module</title>
</head>
<!--<?php

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
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
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
<div class="right_header">Welcome <?php echo $_SESSION['flName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
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
	$librId=$_SESSION['librId'];
	$stmt = $DB_con->prepare('SELECT * FROM librarian where libId = ? ');
	$stmt->execute(array($_SESSION['librId']));
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">

				&nbsp;<img src="../user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
		<!--		<form method="post" enctype="multipart/form-data" class="form-horizontal">
					<table class="table table-bordered table-responsive">
					<tr>
			        <td><input class="input-group" type="file" name="user_image" accept="image/*" /></td>
				    </tr>
				    
				    <tr>
				        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
				        <span class="glyphicon glyphicon-save"></span>Save New Profile
				        </button>
				        </td>
				    </tr>
				    </table>
				</form>
				
			<p class="page-header"><?php echo $libId."&nbsp;/&nbsp;".$fullname; ?></p>
			-->
				<br>
				<tr>
				<td><label class="control-label">Librarian ID :</label></td>
				<td><input type="text" name="" value="<?php echo $libId; ?>" readonly></td><br/>
				</tr>
				<tr>
				<td><label class="control-label">Fullname : &nbsp;&nbsp;</label></td>
				<td><input type="text" name="" value="<?php echo $fullname; ?>" readonly></td>
				</tr>
				<p class="page-header">
				<span>
				&nbsp;&nbsp;<a class="btn btn-info" href="editprofile.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" "><span class="glyphicon glyphicon-edit"></span> Update</a>
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
<?php
	include('../includes/connect2.php');

	$count_librarian = mysql_query("SELECT count(*) AS clibrarian from librarian");
	$data1 = mysql_fetch_assoc($count_librarian);
	if (empty($data1)){
		echo "All Librarian is no good...";
	}else{
		echo "<h3>There are <u>".$data1['clibrarian']."</u> librarian user here...</h3>";
	}

	$member_active = mysql_query("SELECT count(*) AS mactive FROM member WHERE userStatus = 'active'") or exit (mysql_error());
	$data2 = mysql_fetch_assoc($member_active);
	if (empty($data2)){
		echo "They are bad in others so that they are deactivated...";
	}else{
		echo "<h3> There are <u>".$data2['mactive']."</u> active account...</h3>";
	}

	$member_deactive = mysql_query("SELECT count(*) AS mdeactive FROM member WHERE userStatus = 'deactive'") or exit (mysql_error());
	$data3 = mysql_fetch_object($member_deactive);
	if (empty($data3)){
		echo "They are good good so cute and so their account is activated...";
	}else{
		echo "<h3> There are <u>".$data3->mdeactive."</u> deactive...</h3>";
	}

?>
</div>
<div class="right_content">

<!--
<?php
 function countdeactive($m, $b){
 	echo $m + $b;
 }
 
?>	-->

<!--below shows the reports of the memberlist-->

<?php
include('../includes/connect2.php');
	$query = "select count(*) from reports";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 20;
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
<table id="rounded-corner" width="80%">
	<thead>
	<tr><th colspan="4">REPORT LIST</th></tr>
	<tr>
		<th>From</th>
		<th>Date</th>
		<th>Details</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$mreports = mysql_query("SELECT * FROM reports ORDER BY id DESC LIMIT $offset,$rowsperpage");
	if (mysql_num_rows($mreports)) {
		while ($row1 = mysql_fetch_array($mreports)) {
		echo "<tr>
		 <td>".$row1['reportFrom']."</td>
		 <td>".$row1['daytime']."</td>
		 <td>".$row1['details']."</td>
		 <td>".$row1['status']."</td>
	
		</tr>
		";
		}

	}
	?>
	</tbody>
</table>

</div>

</div>
</div>
</body>
</html>
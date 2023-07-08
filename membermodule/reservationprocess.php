<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['memId']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php// echo $_SESSION['userName'] ?>
<?php
$dateTime = new DateTime("now", new DateTimeZone('Asia/Manila'));
$mysqldate = $dateTime->format("Y-m-d H:i:s");
//echo $mysqldate;
 ?>	
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reservation process</title>
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
table {
    border-collapse: collapse;
    width: 50%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: white;
}
th {
    background-color: #4CAF50;
    color: white;
}

tr:hover{
background-color:#f5f5f5;
}
</style>
</head>
<body bgcolor=#ccd9ff>
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['memId'] ?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
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
<?php
error_reporting( ~E_NOTICE); // AVOID NOTICE

require_once '../includes/connect5.php';
if(isset($_POST['btn_save_updates'])){
// books table
//	$bookId = $_POST['bookId'];
	$isbn = $_POST['isbn'];
	$bookName = $_POST['bookName'];
	$author = $_POST['author'];
	$category = $_POST['category'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$bookStatus = $_POST['bookStatus'];
	$bookPic = $_POST['bookPic'];
// member user table
	$reserveBy = $_SESSION['userName'];
	$rfidNo = $_SESSION['memId'];

//	$ = $_POST[''];
	if (empty($isbn)) {
		$errMSG = "Error the book ISBN is empty";
	}
	elseif (empty($bookName)) {
		$errMSG = "Error the Book Title is Empty";
	}

	if (!isset($errMSG)) {
		$stmt = $DB_con->prepare('INSERT INTO reservation(rfidNo,reserveBy,bookId,bookTitle,dateReserve,reserveExp) VALUES(:rfno,:rrsb,:risbn,:rbkn,now(),now() + INTERVAL 3 HOUR)');
		$stmt->bindParam(':rfno',$rfidNo);
		$stmt->bindParam(':rrsb',$reserveBy);
		$stmt->bindParam(':risbn',$isbn);
		$stmt->bindParam(':rbkn',$bookName);
		//$stmt->bindParam(':rnow',now());

		if($stmt->execute()){
			$newquantity = $quantity - 1;
			$stmt = $DB_con->prepare("UPDATE books SET quantity = :bquan - 1 WHERE isbn=:bisbn");
			$stmt->bindParam(':bquan',$quantity);
//			$unavailable = "unavailable";
//			$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE isbn=:bisbn");
//			$stmt->bindParam(':bua',$unavailable);
			$stmt->bindParam(':bisbn',$isbn);
			if ($stmt->execute()){
			echo "<center><h1><br>The Book is successfully reserved you have only 3 hours to pick it up!...</h1>";
			echo "<br><table border='2'>
			<tr>
			<th>RESERVE BY</th><th>ISBN</th><th>TITLE</th><th>DATE RESERVE</th>
			</tr><tr>
			<td>".$reserveBy."</td><td>".$isbn."</td><td>".$bookName."</td><td>".$mysqldate."</td>
			</tr>

			</table><br><br><br>";

			header("refresh:10;index.php");
			}else{
				$errMSG = "Error Updating BOok Status!....";
			}
		}
		else{
			$errMSG = "Error BOok Reservation!....";
		}

	}

}
?>
</div>
</div>
</div>
</body>
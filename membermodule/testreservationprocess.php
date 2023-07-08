<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php echo $_SESSION['userName'] ?>
<?php
error_reporting( ~E_NOTICE); // AVOID NOTICE

require_once '../includes/connect5.php';
if(isset($_POST['btn_save_updates'])){
// book table
//	$isbn = $_POST['isbn'];
	$bookId = $_POST['bookId'];
	$bookTitle = $_POST['bookTitle'];
	$author = $_POST['author'];
	$category = $_POST['category'];
	$description = $_POST['description'];
//	$releaseDate = $_POST['releaseDate'];
//	$bookStatus = $_POST['bookStatus'];
// member user table
	$reserveBy = $_SESSION['userName'];

//	$ = $_POST[''];
	if (empty($bookId)) {
		$errMSG = "Error the book ID is empty";
	}
	elseif (empty($bookTitle)) {
		$errMSG = "Error the Book Title is Empty";
	}

	if (!isset($errMSG)) {
		$stmt = $DB_con->prepare('INSERT INTO reservation(reserveBy,bookId,bookTitle,dateReserve,reserveExp) VALUES(:rrsb,:rbid,:rbtt,now(),now() + interval 3 day)');
		$stmt->bindParam(':rrsb',$reserveBy);
		$stmt->bindParam(':rbid',$bookId);
		$stmt->bindParam(':rbtt',$bookTitle);
		//$stmt->bindParam(':rnow',now());

		if($stmt->execute()){
//			$unavailable = "unavailable";
//			$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE isbn=:bisbn");
//			$stmt->bindParam(':bua',$unavailable);
//			$stmt->bindParam(':bisbn',$isbn);
			if ($stmt->execute()){
			echo "<center><h1><br>The Book is successfully reserved you have only 72 hours to pick it up!...</h1>";

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
<a href="../membermodule/index.php">BOOK LIST</a>
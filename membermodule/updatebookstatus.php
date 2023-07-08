//this will work
<?php
$username = $_SESSION['userName'];


$stmt = $DB_con->prepare("SELECT dateReserve from reservation where reserveBy = ?");
$stmt->execute(array($_SESSION['userName']));
$result = $stmt->fetch();
//$row = $result->fetch();
$dReserve = $result['dateReserve'];
echo $dReserve;
$expired = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s",strtotime($dReserve))."+ 3 day"));
echo "<br>".$expired;
if (date("Y-m-d H:i:s") > $expired) {
	
	$available = "available";
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bav WHERE id=:uid");
	$stmt->bindParam(':bav',$available);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();
	echo $available;
}else{
	
	$unavailable = "unavailable";
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE id=:uid");
	$stmt->bindParam(':bua',$unavailable);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();echo $unavailable;
}
?>

<?php
$username = $_SESSION['userName'];
$available = "available";
$unavailable = "unavailable";
$stmt = $DB_con->prepare("SELECT dateReserve from reservation where reserveBy = ?");
$stmt->execute(array($_SESSION['userName']));
$result = $stmt->fetch();
//$row = $result->fetch();
$dReserve = $result['dateReserve'];
echo $dReserve;
$expired = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s",strtotime($dReserve))."+ 3 day"));
echo "<br>".$expired;
if (date("Y-m-d H:i:s") < $expired) {
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bav WHERE id=:uid");
	$stmt->bindParam(':bav',$available);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();
}else{
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE id=:uid");
	$stmt->bindParam(':bua',$unavailable);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();
}
?>

// work if $row has been executed
<?php
	$available = "available";
	$unavailable = "unavailable";
	$dReserve = $row['dateReserve'];
	$isbn = $row['isbn'];
	$expired = date("Y-m-d",strtotime(date("Y-m-d",strtotime($dReserve))."+ 3 day"));
	if (date("Y-m-d") > $expired) {
		$a_sql=mysql_query("UPDATE books SET bookStatus='$available' WHERE isbn ='$isbn'");
		echo $available;
		echo $isbn;
	}else{
		$a_sql=mysql_query("UPDATE books SET bookStatus='$unavailable' WHERE isbn ='$isbn'");
		echo $unavailable;
		echo $isbn;
	}
?>
//another
<?php
$username = $_SESSION['userName'];
$available = "available";
$unavailable = "unavailable";
$stmt = $DB_con->prepare("SELECT dateReserve, reserveExp from reservation where reserveBy = $username");
$dReserve = $row_reservation['dateReserve'];
$expired = date("Y-m-d",strtotime(date("Y-m-d",strtotime($dReserve))."+ 3 day"));
if (date("Y-m-d") < $expired) {
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bav WHERE id=:uid");
	$stmt->bindParam(':bav',$available);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();
}else{
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE id=:uid");
	$stmt->bindParam(':bua',$unavailable);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();
}
?>

<?php

?>
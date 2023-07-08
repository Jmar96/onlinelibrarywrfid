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

<?php
session_start();
$regDate = $row_Registered['Timestamp'];
$expired = date("Y-m-d", strtotime(date("Y-m-d",strtotime($regDate))."+ 2 day"));
echo $regDate;
?>

<?php
if (date("Y-m-d") < $expired) {
	echo "alive";
}else{
	echo "expired";
}
?>
<?php
$expire_date = date("Y-m-d", strtotime("+2 day"));

?>


<?php
echo "Object Oriented Style<br>";
$date = new DateTime('2006-12-12');
$date->modify('+1 day');
echo $date->format('Y-m-d');
echo "<br><br>";
?>

<?php
echo "Procedural Style<br>";
$date = date_create('2006-12-12');
date_modify($date, '+1 day');
echo date_format($date, 'Y-m-d');
echo "<br>";
?>

<?php
$dt = new DateTime();
echo $dt->format('Y-m-d H:i:s');
?>

<?php
// strtotime is for datetime datatype only
if(strtotime($tot) > time()){

}else{

}
?>
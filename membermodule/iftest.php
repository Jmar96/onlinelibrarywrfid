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
	echo $available;?>
	<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p>

<?php}else{
	
	$unavailable = "unavailable";
	$stmt = $DB_con->prepare("UPDATE books SET bookStatus=:bua WHERE id=:uid");
	$stmt->bindParam(':bua',$unavailable);
	$stmt->bindParam(':uid',$id);
	$stmt->execute();echo $unavailable; ?>
	<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p>
<?php}
?>
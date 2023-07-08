<?php
	include('../includes/connect2.php');
	$query = "select count(*) from reservation";
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
	
	$epr='';
	
	if(isset($_GET['epr']))
		$epr=$_GET['epr'];
	
	if($epr=='save'){
		//$id=$_POST['textid']; id is not necessary
		$rfidNo=$_POST['textrfid'];
		$reserveBy=$_POST['textrb'];
		$bookId=$_POST['textbid'];
		$bookTitle=$_POST['textit'];
		//$dateReserve=$_POST['textdr'];
		//$reserveExp=$_POST['textre'];

		
		if ($rfidNo==''||$reserveBy==''||$bookId==''||$bookTitle==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("INSERT INTO reservation values('','$rfidNo','$reserveBy','$bookId','$bookTitle', now(),now() + INTERVAL 3 HOUR )");
			if ($a_sql){
				$successMSG = "<center>New record successfully added!</center>";
				header("refresh:1;reserve.php");
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}
	if($epr=='delete'){
		$id=$_GET['id'];
		$delete=mysql_query("DELETE from reservation where id='$id'");
		if ($delete){
			$addquantity=mysql_query("UPDATE books SET quantity='$quantity' WHERE isbn='$bookId' LIMIT 1");
			if ($addquantity){
				$successMSG = "<center>The data has been deleted</center>";
				header("refresh:1;adreports.php");
			}else{
				$msg='ERROR:'.mysql_error();
			}
		}
		else{
			$msg='ERROR:'.mysql_error();
		}
	}
	if($epr=='saveup'){
		$id=$_POST['textid']; //not necessary theres id below
		$reserveBy=$_POST['textrb'];
		$bookId=$_POST['textbid'];
		$bookTitle=$_POST['textit'];
		//$dateReserve=$_POST['textdr'];
		//$reserveExp=$_POST['textre'];

		$id=$_POST['textid'];
		if ($reserveBy==''||$bookId==''||$bookTitle==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("UPDATE books SET quantity=quantity + 1 WHERE isbn='$bookId'");
			if ($a_sql){
				$delete=mysql_query("DELETE from reservation where id='$id'");
				if($delete){
					$successMSG = "<center>The record is successfully update</center>";
					header("refresh:1;reserve.php");
				}else{
					$msg='ERROR:'.mysql_error();
				}
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}
?>

<?php
if($epr=='update'){
$id=$_GET['id'];
$row=mysql_query("SELECT * FROM reservation where id='$id'");
$st_row=mysql_fetch_array($row);	
?>

<h3 align="center">DELETE RESERVATION</h3>
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
<form method="POST" action='reserve.php?epr=saveup'>
	<table align="center">
		<tr>
			<td></td>
			<td><input type='hidden' name='textid' value="<?php echo $st_row['id'] ?>"/></td>
		</tr>
		<tr>
			<td>RFID :</td>
			<td><input type='text' name='textrb' value="<?php echo $st_row['rfidNo'] ?>"/></td>
		</tr>
		<tr>
			<td>RESERVE BY :</td>
			<td><input type='text' name='textrb' value="<?php echo $st_row['reserveBy'] ?>"/></td>
		</tr>
		<tr>
			<td>ISBN :</td>
			<td><input type='text' name='textbid' value="<?php echo $st_row['bookId'] ?>"/></td>
		</tr>
		<tr>
			<td>TITLE :</td>
			<td><input type='text' name='textit' value="<?php echo $st_row['bookTitle'] ?>"/></td>
		</tr>
		<!-- <tr>
			<td>Reservation Date:</td>
			<td><input type='text' name='textdr' value="<?php echo $st_row['dateReserve'] ?>"/></td>
		</tr>
		<tr>
			<td>Expiration:</td>
			<td><input type='text' name='textre' value="<?php echo $st_row['reserveExp'] ?>"/></td>
		</tr> -->
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='DELETE'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='CANCEL' onClick="window.location='../librarianmodule/reserve.php';" /></td>
		</tr>
	</table>
</form>
<?php }else{
?>
<h3 align="center">ADD NEW TRANSACTION</h3>
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
<form method="POST" action='reserve.php?epr=save'>
	<table align="center">
		<tr>
			<td>RFID No :</td>
			<td><input type='text' name='textrfid' placeholder=" RFID NO."></td>
		</tr>
		<tr>
			<td>RESERVE BY :</td>
			<td><input type='text' name='textrb' placeholder=" FULLNAME"></td>
		</tr>
		<tr>
			<td>ISBN :</td>
			<td><input type='text' name='textbid' placeholder="International Standard Book Number"></td>
		</tr>
		<tr>
			<td>BOOK TITLE :</td>
			<td><input type='text' name='textit' placeholder=" TITLE"></td>
		</tr>
		<!-- <tr>
			<td>Date Reserved:</td>
			<td><input type='date' name='textdr'></td>
		</tr>
		<tr>
			<td>Expiration:</td>
			<td><input type='date' name='textre'></td>
		</tr> -->
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='ADD RECORD'></td>
		</tr>
	</table>
</form>
<?php } ?>
<?php 
session_start();

?>
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
		$reserveBy=$_POST['textrb'];
		$isbn=$_POST['textisbn'];
		$bookName=$_POST['textbn'];
		$dateReserve=$_POST['textdr'];
		$reserveExp=$_POST['textre'];

		
		if ($reserveBy==''||$isbn==''||$bookName==''||$dateReserve==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("INSERT INTO reservation values('','$reserveBy','$isbn','$bookName','$dateReserve','$reserveExp')");
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
			$successMSG = "<center>The data has been deleted</center>";
			header("refresh:1;reserve.php");
		}
		else{
			$msg='ERROR:'.mysql_error();
		}
	}
	if($epr=='saveup'){
		//$id=$_POST['textid']; not necessary theres id below
		$reserveBy=$_POST['textrb'];
		$isbn=$_POST['textisbn'];
		$bookName=$_POST['textbn'];
		$dateReserve=$_POST['textdr'];
		$reserveExp=$_POST['textre'];
		$id=$_POST['textid'];
		if ($reserveBy==''||$isbn==''||$bookName==''||$dateReserve==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("UPDATE reservation SET reserveBy='$reserveBy',isbn='$isbn',bookName='$bookName',dateReserve='$dateReserve',reserveExp='$reserveExp' WHERE id='$id'");
			if ($a_sql){
				$successMSG = "<center>The record is successfully update</center>";
				header("refresh:1;reserve.php");
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Module</title>
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
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a class="current" href="../librarianmodule/reserve.php">RESERVATION HISTORY</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="left_content">
<?php
if($epr=='update'){
$id=$_GET['id'];
$row=mysql_query("SELECT * FROM reservation where id='$id'");
$st_row=mysql_fetch_array($row);	
?>

<h3 align="center">Update Reservation History</h3>
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
			<td>Reserved By:</td>
			<td><input type='text' name='textrb' value="<?php echo $st_row['reserveBy'] ?>"/></td>
		</tr>
		<tr>
			<td>ISBN:</td>
			<td><input type='text' name='textisbn' value="<?php echo $st_row['isbn'] ?>"/></td>
		</tr>
		<tr>
			<td>Book Name (TITLE):</td>
			<td><input type='text' name='textbn' value="<?php echo $st_row['bookName'] ?>"/></td>
		</tr>
		<tr>
			<td>Reservation Date:</td>
			<td><input type='text' name='textdr' value="<?php echo $st_row['dateReserve'] ?>"/></td>
		</tr>
		<tr>
			<td>Expiration:</td>
			<td><input type='text' name='textre' value="<?php echo $st_row['reserveExp'] ?>"/></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='SAVE'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='CANCEL' onClick="window.location='../librarianmodule/reserve.php';" /></td>
		</tr>
	</table>
</form>
<?php }else{
?>
<h3 align="center">Add new Transaction</h3>
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
			<td>Reserve By:</td>
			<td><input type='text' name='textrb'></td>
		</tr>
		<tr>
			<td>ISBN:</td>
			<td><input type='text' name='textisbn'></td>
		</tr>
		<tr>
			<td>Book Name:</td>
			<td><input type='text' name='textbn'></td>
		</tr>
		<tr>
			<td>Date Reserved:</td>
			<td><input type='date' name='textdr'></td>
		</tr>
		<tr>
			<td>Expiration:</td>
			<td><input type='date' name='textre'></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='ADD RECORD'></td>
		</tr>
	</table>
</form>
<?php } ?>
</div>
<!-Show data->
<div class="right_content">   
<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div>
<h2>&nbsp;&nbsp;&nbsp;Reservation History</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>Reserved By</th>
		<th>ISBN</th>
		<th>Book Name</th>
		<th>Date Reserved</th>
		<th>Expiration Date</th>
		<th>ACTION</th>
	</thead>
	<tbody>
	<?php
	if(isset($_POST['search1'])){
		$search=$_POST['search'];
		$stmt=mysql_query("SELECT * from reservation where reserveBy like '%{$search}%' || isbn like '%{$search}%' || bookName like '%{$search}%' limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['reserveBy']."</td>
					<td>".$row['isbn']."</td>
					<td>".$row['bookName']."</td>
					<td>".$row['dateReserve']."</td>
					<td>".$row['reserveExp']."</td>
					<td align='center'>
					<a href='reserve.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='reserve.php?epr=delete&id=".$row['id']."'>DELETE</a>
					</td>
				</tr>";
			}
		}else{
			echo "<P> <B>No Admin Found </P>";
		}
	}
	else{
	$stmt = mysql_query("SELECT * FROM reservation ORDER BY id DESC limit $offset,$rowsperpage");
	if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
			echo "<tr>
				<td>".$row['reserveBy']."</td>
				<td>".$row['isbn']."</td>
				<td>".$row['bookName']."</td>
				<td>".$row['dateReserve']."</td>
				<td>".$row['reserveExp']."</td>
				<td align='center'>
					<a href='reserve.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='reserve.php?epr=delete&id=".$row['id']."'>DELETE</a>
				</td>
			</tr>";
		}	
	}

	}
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
	</tbody>
</table>
<br>
<center>
<?php
	if($currentpage>1){
		echo "<a href=' {$_SERVER['PHP_SELF']}?currentpage=1'>First</a> &nbsp;&nbsp;";
		$prevpage = $currentpage -1;
		echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Previous</a>&nbsp;&nbsp;";
	}
	$range = 3;
	for($x=($currentpage - $range);$x<(($currentpage + $range)+1);$x++){
		if (($x>0) && ($x<=$totalpages)){
			if ($x==$currentpage){
				echo " [<b> $x </b>]&nbsp;&nbsp;";
			}else{
				echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a>&nbsp;&nbsp;";
			}
		}
	}
	if ($currentpage!=$totalpages){
		$nextpage = $currentpage + 1;
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a>&nbsp;&nbsp;";
		echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a>";
	}
?>
</center>
<br>
</div>
</div>


</div>
</body>
</html>
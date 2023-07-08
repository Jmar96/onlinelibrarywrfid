<?php 
session_start();
if(!$_SESSION['flName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['librId']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
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
	
	$epr='';
	
	if(isset($_GET['epr']))
		$epr=$_GET['epr'];
	
	if($epr=='save'){
		//$id=$_POST['textid']; id is not necessary
		$from=$_POST['textf'];
		//$daytime=$_POST['textda'];
		$details=$_POST['textde'];
		$status=$_POST['textsta'];

		
		if ($from==''||$details==''||$status==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("INSERT INTO reports values('','$from','$details','$status',now())");
			if ($a_sql){
				$successMSG = "<center>New record successfully added!</center>";
				header("refresh:1;adreports.php");
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}
	
	if($epr=='delete'){
		$id=$_GET['id'];
		$delete=mysql_query("DELETE from reports where id='$id'");
		if ($delete){
			$successMSG = "<center>The data has been deleted</center>";
			header("refresh:1;adreports.php");
		}
		else{
			$msg='ERROR:'.mysql_error();
		}
	}
	if($epr=='saveup'){
		//$id=$_POST['textid']; not necessary theres id below
		$from=$_POST['textfr'];
		$daytime=$_POST['textdat'];
		$details=$_POST['textdet'];
		$status=$_POST['textstat'];
		$id=$_POST['textid'];
		if ($from==''||$daytime==''||$details==''||$status==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("UPDATE reports SET reportFrom='$from',daytime=now(),details='$details',status='$status' WHERE id='$id'");
			if ($a_sql){
				$successMSG = "<center>The record is successfully update</center>";
				header("refresh:1;adreports.php");
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
<title>Librarian Module</title>
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
<div class="right_header">Welcome <?php echo $_SESSION['flName']?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a class="current" href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../librarianmodule/reserve.php">RESERVATION</a></li>
		<li><a href="../librarianmodule/issuedrecords.php">ISSUED BOOKS</a></li>
		<li><a href="../librarianmodule/returnrecords.php">RETURN BOOKS</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="left_content">
<?php
if($epr=='update'){
$id=$_GET['id'];
$row=mysql_query("SELECT * FROM reports where id='$id'");
$st_row=mysql_fetch_array($row);	
?>

<h3 align="center">Update Reports</h3>
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
<form method="POST" action='adreports.php?epr=saveup'>
	<table align="center">
		<tr>
			<td></td>
			<td><input type='hidden' name='textid' value="<?php echo $st_row['id'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td>From:</td>
			<td><input type='text' name='textfr' value="<?php echo $st_row['reportFrom'] ?>"/ readonly></td>
		</tr>
		<tr>
			<td>Date:</td>
			<td><input type='text' name='textdat' value="<?php echo $st_row['daytime'] ?>"/ readonly></td>
		</tr>	
		<tr>
			<td>Details:</td>
			<!-- <td><input type='text' name='textdet' value="<?php echo $st_row['details'] ?>" /></td> -->
			<td><textarea name='textdet' rows="4" cols="22" placeholder="Input details here..."><?php echo $st_row['details'] ?></textarea></td>
		</tr>
		<tr>
			<td>Status:</td>
			<td>

			<input type="radio" name="textstat" value="new">New
			<input type="radio" name="textstat" <?php if (isset($status) && $status="old") echo "checked";?> value="old" checked>Old
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='SAVE'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='CANCEL' onClick="window.location='../librarianmodule/adreports.php';" /></td>
		</tr>
	</table>
</form>
<?php }else{
?>
<h3 align="center">ADD NEW REPORT</h3>
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
<form method="POST" action='adreports.php?epr=save'>
	<table align="center">
		<tr>
			<td>From:</td>
			<td><input type='text' name='textf' value="<?php echo $_SESSION['flName'];?>">
			</td>
		</tr>
<!--		<tr>
			<td>Date:</td>
			<td><input type='date' name='textda'></td>
		</tr> -->
		<tr>
			<td>Details:</td>
			<!--<td><input type='text' name='textde'></td>
			<td><textarea rows="4" cols="50" name="comment" form="usrform"></td> -->
			<td><textarea name='textde' rows="4" cols="22" placeholder="Input details here..."></textarea></td>
		</tr>
		<tr>
			<td>Status :</td>
			<td align='center'><input type='text' value="new" name='textsta' readonly></td>
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
<h2><br>&nbsp;&nbsp;&nbsp;REPORT LIST</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>From</th>
		<th>Date</th>
		<th>Details</th>
		<th>Status</th>
		<th>ACTION</th>
	</thead>
	<tbody>
	<?php
	if(isset($_POST['search1'])){
		$search=$_POST['search'];
		$stmt=mysql_query("SELECT * from reports where reportFrom like '%{$search}%' || daytime like '%{$search}%' || details like '%{$search}%' || status like '%{$search}%'  limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['reportFrom']."</td>
					<td>".$row['daytime']."</td>
					<td>".$row['details']."</td>
					<td>".$row['status']."</td>
					<td align='center'>
					<a href='adreports.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='adreports.php?epr=delete&id=".$row['id']."'>DELETE</a>
					</td> 
				</tr>";
			}
		}else{
			echo "<P> <B>No Data Found </P>";
		}
	}
	else{
	$stmt = mysql_query("SELECT * FROM reports ORDER BY id DESC limit $offset,$rowsperpage");
	if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
			echo "<tr>
				<td>".$row['reportFrom']."</td>
				<td>".$row['daytime']."</td>
				<td>".$row['details']."</td>
				<td>".$row['status']."</td>
				 <td align='center'>
					<a href='adreports.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='adreports.php?epr=delete&id=".$row['id']."'>DELETE</a>
				</td> 
			</tr>";
		}	
	}
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
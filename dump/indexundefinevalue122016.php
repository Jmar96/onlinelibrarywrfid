<?php
	include('../includes/connect2.php');
	$query = "select count(*) from admin";
	$result = mysql_query($query,$con) or die (mysql_error());
	$r=mysql_fetch_row($result) or die (mysql_error());
	
	$numrows=$r[0];
	$rowsperpage = 3;
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
		$adminId=$_POST['textadid'];
		$username=$_POST['textun'];
		$password=$_POST['textpass'];
		$fullname=$_POST['textf'];
		$address=$_POST['textad'];
		$contactNo=$_POST['textcn'];
		$emailAddress=$_POST['textea'];
		$retrieve=$_POST['textret'];
		//$picture=$_POST['textpic'];
		
		if ($adminId==''||$username==''||$password==''||$fullname==''||$contactNo==''||$emailAddress==''||$retrieve==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("INSERT INTO admin values('','$adminId','$username','$password','$fullname','$address','$contactNo','$emailAddress','$retrieve','')");
			if ($a_sql){
				$successMSG = "<center>New record successfully added!</center>";
				header("refresh:1;index.php");
			}
			else{
				$msg='ERROR:'.mysql_error();
			}
		}
	}

	if($epr=='delete'){
		$id=$_GET['id'];
		$delete=mysql_query("DELETE from admin where id='$id'");
		if ($delete){
			$successMSG = "<center>The data has been deleted</center>";
			header("refresh:1;index.php");
		}
		else{
			$msg='ERROR:'.mysql_error();
		}
	}
	if($epr=='saveup'){
		$adminId=$_POST['textadnid'];
		$username=$_POST['textusn'];
		$password=$_POST['textpassw'];
		$fullname=$_POST['textfl'];
		$address=$_POST['textadd'];
		$contactNo=$_POST['textcno'];
		$emailAddress=$_POST['textead'];
		//$picture=$_POST['textpic'];
		$id=$_POST['textid'];
		if ($adminId==''||$username==''||$password==''||$fullname==''||$contactNo==''||$emailAddress==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
		}
		else{
			$a_sql=mysql_query("UPDATE admin SET adminId='$adminId',username='$username',password='$password',fullname='$fullname',address='$address',contactNo='$contactNo',emailAddress='$emailAddress' WHERE id='$id'");
			if ($a_sql){
				$successMSG = "<center>The record is successfully update</center>";
				header("refresh:1;index.php");
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
<div class="right_header">Welcome Admin<a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="#">ADMIN</a></li>
		<li><a href="#">LIBRARIAN USER LIST</a> </li>
		<li><a href="#">MEMBER USER LIST</a> </li>
		<li><a href="#">BOOK LIST</a></li>
		<li><a href="#">REPORTS</a></li>
		<li><a href="../logouts/logoutadmin.php?id=22" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="left_content">
<?php
if($epr=='update'){
$id=$_GET['id'];
$row=mysql_query("SELECT * FROM admin where id='$id'");
$st_row=mysql_fetch_array($row);	
?>
<h3 align="center">Update Admin</h3>
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
<form method="POST" action="index.php?epr=saveup">
	<table align="center">
		<tr>
			<td></td>
			<td><input type='hidden' name='textid' value="<?php echo $st_row['id'] ?>"/></td>
		</tr>
		<tr>
			<td>Admin ID :</td>
			<td><input type="number" name="textadid" value="<?php echo  $st_row['id']  ?>" required /></td>
		</tr>
		<tr>
			<td>Username :</td>
			<td><input type="text" name="textname" value="<?php echo  $st_row['username']  ?>" required /></td>
		</tr>
		<tr>
			<td>Password :</td>
			<td><input type="text" name="textpass" value="<?php echo  $st_row['password']  ?>" required /></td>
		</tr>
		<tr>
			<td>Fullname :</td>
			<td><input type="text" name="textfnam" value="<?php echo  $st_row['fullname']  ?>" required /></td>
		</tr>
		<tr>
			<td>Address :</td>
			<td><input type="text" name="textadd" value="<?php echo $st_row['address']  ?>" required /></td>
		</tr>
		<tr>
			<td>Contact No :</td>
			<td><input type="number" name="textcno" value="<?php echo  $st_row['contactNo']  ?>" required /></td>
		</tr>
		<tr>
			<td>Email Address :</td>
			<td><input type="email" name="textemal" value="<?php echo  $st_row['emailAddress']  ?>" required /></td>
		</tr>
		<tr>
			<td>Retrieving Phrase :</td>
			<td><input type="text" name="textretp" value="<?php echo  $st_row['retrieve']  ?>" required /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' class="btn btn-primary btn-small" name='btnsave' value='SAVE'>
			<input type='button' class="btn btn-warning btn-small" name='back' value='CANCEL' onClick="window.location='../adminmodule/index.php';" /></td>
		</tr>
	</table>
</form>
<?php
	}else{
?>
<h3 align="center">Add Admin</h3>
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
<form method="POST" action="index.php?epr=save">
	<table align="center">
	<tr>
		<td>Admin ID :</td>
		<td><input type="number" name="textadid"></td>
	</tr>
	<tr>
		<td>Username :</td>
		<td><input type="text" name="textun"></td>
	</tr>
	<tr>
		<td>Password :</td>
		<td><input type="text" name="textpass"></td>
	</tr>
	<tr>
		<td>Fullname :</td>
		<td><input type="text" name="textf"></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td><input type="text" name="textad"></td>
	</tr>
	<tr>
		<td>Contact No :</td>
		<td><input type="number" name="textcn"></td>
	</tr>	
	<tr>
		<td>Email Address :</td>
		<td><input type="email" name="textea"></td>
	</tr>
	<tr>
		<td>Retrieving Phrase :</td>
		<td><input type="text" name="textret"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="btn btn-primary btn-small" name="btnsave" value="ADD">
		</td>
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
<h2>&nbsp;&nbsp;&nbsp;Admin Users List</h2>
<table id="rounded-corner" width="80%">
	<thead>
		<th>Admin ID</th>
		<th>Username</th>
		<th>Password</th>
		<th>Fullname</th>
		<th>Address</th>
		<th>Contact No.</th>
		<th>Email Address</th>
		<th>ACTION</th>
	</thead>
	<tbody>
	<?php
	if(isset($_POST['search1'])){
		$search=$_POST['search'];
		$stmt=mysql_query("SELECT * from admin where username like '%{$search}%' || password like '%{$search}%' || fullname like '%{$search}%' || address like '%{$search}%' || address like '%{$search}%' || contactNo like '%{$search}%' || emailAddress like '%{$search}%' limit $offset,$rowsperpage");
		if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
				echo "<tr>
					<td>".$row['adminId']."</td>
					<td>".$row['username']."</td>
					<td>".$row['password']."</td>
					<td>".$row['fullname']."</td>
					<td>".$row['address']."</td>
					<td>".$row['contactNo']."</td>
					<td>".$row['emailAddress']."</td>
					<td align='center'>
					<a href='index.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='index.php?epr=delete&id=".$row['id']."'>DELETE</a>
					</td>
				</tr>";
			}
		}else{
			echo "<P> <B>No Admin Found </P>";
		}
	}
	else{
	$stmt = mysql_query("SELECT * FROM admin ORDER BY id DESC limit $offset,$rowsperpage");
	if (mysql_num_rows($stmt) > 0){
			while ($row = mysql_fetch_array($stmt)) {
			echo "<tr>
				<td>".$row['adminId']."</td>
				<td>".$row['username']."</td>
				<td>".$row['password']."</td>
				<td>".$row['fullname']."</td>
				<td>".$row['address']."</td>
				<td>".$row['contactNo']."</td>
				<td>".$row['emailAddress']."</td>
				<td align='center'>
					<a href='index.php?epr=update&id=".$row['id']."'>UPDATE</a> |
					<a onClick=\"javascript: return confirm('Please confirm deletion');\"href='index.php?epr=delete&id=".$row['id']."'>DELETE</a>
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
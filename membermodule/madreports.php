<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['memId']){
	header('refresh:0.10;../cheatingmsg.php');
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
	<title><?php echo $_SESSION['memId']?></title>
</head>
<body bgcolor="lightgreen">
<div id="main_container">
<div id="header">
<div class="jclock"></div>
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a class="current" href="../membermodule/memprofile.php">PROFILE</a> </li>
<!--		<li><a href="../membermodule/memreservation.php">TRANSACTION</a> </li> -->
		<li><a href="../membermodule/index.php">BOOK LIST</a></li>
		<li><a href="../logouts/logoutmem.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<?php
	include('../includes/connect2.php');
	/*$query = "select count(*) from reports";
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
	$offset = ($currentpage-1)*$rowsperpage; */
	
	$epr='';
	
	if(isset($_GET['epr']))
		$epr=$_GET['epr'];
	
	if($epr=='save'){
		//$id=$_POST['textid']; id is not necessary
		$from=$_POST['textf'];
		//$daytime=$_POST['textda'];
		$details=$_POST['textde'];
		$status= "new";

		
		if ($from==''||$details==''||$status==''){
			$errMSG = "<center>You must fill in all the fields.</center>";
			header("refresh:2;memprofile.php");
		}
		else{
			$a_sql=mysql_query("INSERT INTO reports values('','$from','$details','$status',now())");
			if ($a_sql){
				$successMSG = "<center>New record successfully added!</center>";
				header("location:memprofile.php");
			}
			else{
				$msg='ERROR:'.mysql_error();
				header("refresh:2;memprofile.php");
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
</div>
</div>
</body>
</html>
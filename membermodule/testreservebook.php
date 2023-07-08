<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
$selected_bkid = $_GET['reserve_id']; // get reserve_id from index.php
$_SESSION['reserve_id'] = $_GET['reserve_id'];
?>
	<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['reserve_id']) && !empty($_GET['reserve_id']))
	{
		$id = $_GET['reserve_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM booktitle WHERE bookId =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Module</title>
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
<div class="right_header">Welcome <?php echo $_SESSION['userName'] ?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../membermodule/memprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../membermodule/index.php">BOOK LIST</a></li>
		<li><a href="../logouts/logoutmem.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 

<div class="container">


	<div class="page-header">
    	<center><h1 class="h2">RESERVE BOOK </center><a class="btn btn-default" href="../membermodule/index.php"> See all books </a></h1>
    </div>

<div class="clearfix"></div>
<!--@@@@@@@@@@@@@@@@@@@@@@the form action below@@@@@@@@@@@@@@@@@@@@@@@@-->
<form method="post" action="../membermodule/reservationprocess.php" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">

    <tr>
    	<td></td>
        <td>
        	<p><img src="../book_images/<?php echo $bookPic; ?>" height="150" width="150" /></p>
        	
        </td>
    </tr>
    <tr>
    	<td><label class="control-label">Book ID.</label></td>
        <td><input class="form-control" type="text" name="bookId" value="<?php echo $bookId; ?>" required / readonly></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Book Title:</label></td>
        <td><input class="form-control" type="text" name="bookTitle" value="<?php echo $bookTitle; ?>" readonly></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Author:</label></td>
        <td><input class="form-control" type="text" name="author" value="<?php echo $author; ?>" required / readonly></td>
    </tr>

    <tr>
    	<td><label class="control-label">Category:</label></td>
        <td><input class="form-control" type="text" name="category" value="<?php echo $category; ?>" required / readonly></td>
    </tr>

    <tr>
    	<td><label class="control-label">Description:</label></td>
        <td><input class="form-control" type="text" name="description" value="<?php echo $description; ?>" required / readonly></td>
    </tr>

<!--    <tr>
    	<td><label class="control-label">Release Date:</label></td>
        <td><input class="form-control" type="text" name="releaseDate" value="<?php echo $releaseDate; ?>" required / readonly></td>
    </tr>

    <tr>
    	<td><label class="control-label">Book Status:</label></td>
        <td><input class="form-control" type="text" name="bookStatus" value="<?php echo $bookStatus; ?>" required / readonly></td>
    </tr>
 --> 
    <tr>
        <td colspan="2"><h2>&nbsp;&nbsp;&nbsp;<?php msgcondition($av); ?></h2> <button type="submit" name="btn_save_updates" class="btn btn-default"><span class="glyphicon glyphicon-save"></span><?php rescondition($av); ?></button>
        <a class="btn btn-default" href="../membermodule/index.php"> <span class="glyphicon glyphicon-backward"></span> CANCEL </a> </td>
    </tr>
    
    </table>
    
</form>
<?php
    include('../includes/connect2.php');
    $num_result=mysql_query("SELECT COUNT(*) as bookId from bookrecord WHERE bookId = '{$_SESSION['reserve_id']}'") or exit(mysql_error());
    $row=mysql_fetch_object($num_result);
    echo "<h3>Quantity : ";
    echo $row->bookId;
    $quantity = $row->bookId;
?>
<?php  
    $num_result = mysql_query("SELECT count(*) as bookStatus from bookrecord where bookStatus = 'unavailable' ") or exit(mysql_error());
    $row = mysql_fetch_object($num_result);
    echo "<h3>Unavailable : ";
    echo $row->bookStatus;
    $ua = $row->bookStatus;
?> 
<?php  
    $num_result = mysql_query("SELECT count(*) as bookStatus from bookrecord where bookStatus = 'available' and bookId = '{$_SESSION['reserve_id']}' ") or exit(mysql_error());
    $row = mysql_fetch_object($num_result);
    echo "<h3>Available : ";
    echo $row->bookStatus;

    $av = $row->bookStatus;
?> 
<?php
 function rescondition($avail){
    if ($avail < 1) {
        echo "";
    }else{
        echo "RESERVE";
    }
 }
 
?>
<?php
 function msgcondition($avail){
    if ($avail > 1) {
        echo "Low of Stock";
    }else{
        echo "RESERVE (only for 3 hours)";
    }
 }
 
?>
</div>

</div>
</body>
</html>
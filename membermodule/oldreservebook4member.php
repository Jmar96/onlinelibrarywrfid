<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
if(!$_SESSION['memId']){
    header('refresh:0.10;../cheatingmsg.php');
}
$selected_bkid = $_GET['reserve_id']; // get reserve_id from index.php
$_SESSION['reserve_id'] = $_GET['reserve_id'];
?>

<?php
//search reservation and member
//echo $_SESSION['memId'];

//    echo $row->reserveBy;
//    echo $row->username;
//    echo $row->bookTitle;
//    $rby = $row->reserveBy;
//    $mus = $row->username;
//    $bktt = $row->bookTitle;
?>
<!--<?php

	error_reporting( ~E_NOTICE );
	
	require_once '../includes/connect5.php';
	
	if(isset($_GET['reserve_id']) && !empty($_GET['reserve_id']))
	{
		$id = $_GET['reserve_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM books WHERE isbn =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
?> -->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserve Book</title>
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
<div class="right_header">Welcome <?php echo $_SESSION['memId'] ?><a href="../logouts/logoutadmin.php?id=22" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../membermodule/memprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../membermodule/index.php">BOOK LIST</a></li>
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
    	<td><label class="control-label">ISBN.</label></td>
        <td><input class="form-control" type="text" name="isbn" value="<?php echo $isbn; ?>" required / readonly></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">BOOK TITLE:</label></td>
        <td><input class="form-control" type="text" name="bookName" value="<?php echo $bookName; ?>" readonly></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">AUTHOR:</label></td>
        <td><input class="form-control" type="text" name="author" value="<?php echo $author; ?>" required / readonly></td>
    </tr>

    <tr>
    	<td><label class="control-label">CATEGORY:</label></td>
        <td><input class="form-control" type="text" name="category" value="<?php echo $category; ?>" required / readonly></td>
    </tr>

    <tr>
    	<td><label class="control-label">DESCRIPTION:</label></td>
        <td><input class="form-control" type="text" name="description" value="<?php echo $description; ?>" required / readonly></td>
    </tr>
    <tr>
        <td><label class="control-label">QUANTITY:</label></td>
        <td><input class="form-control" type="text" name="quantity" value="<?php echo $quantity; ?>" required / readonly></td>
    </tr>
    <tr>
    	<td><label class="control-label">STATUS:</label></td>
        <td><input class="form-control" type="text" name="bookStatus" value="<?php echo $bookStatus; ?>" required / readonly></td>
    </tr>
<?php
    include('../includes/connect2.php');

    //$reserveBy = $_SESSION['userName'];
    $resbutton = mysql_query("SELECT r.*,m.memberId FROM reservation AS r LEFT JOIN member AS m ON m.memberId = r.rfidNo WHERE r.rfidNo = '{$_SESSION['memId']}' AND r.bookTitle = '$bookName' ");
    $row2 = mysql_fetch_object($resbutton);
    if (empty($row2)){
        $membId = "can696";
    }else{
        $row2->rfidNo;
        $row2->memberId;
        $row2->bookTitle;
        $rsrvBy = $row2->rfidNo;
        $membId = $row2->memberId;
        $bkTit = $row2->bookTitle;
    }

    $borbutton = mysql_query("SELECT b.*,u.memberId FROM issuedbook AS b LEFT JOIN member AS u ON u.memberId = b.rfid WHERE b.rfid = '{$_SESSION['memId']}' AND b.bookTitle = '$bookName' ");
    $row3 = mysql_fetch_object($borbutton);
    if (empty($row3)){
        $mbId = "can969";
    }else{
        $row3->rfidNo;
        $row3->memberId;
        $row3->bookTitle;
        $brBy = $row3->rfid;
        $mbId = $row3->memberId;
        $brkTit = $row3->bookTitle;
    }
    echo $brBy;
    $uastatus = "unavailable";
    $bknm = $bookName;
    //echo $bknm;
    //echo $bkTit;
    //$cbtrue = "True";
    if ($bookStatus == $uastatus){
        $rbutton = '<button type="submit" disabled>UNAVAILABLE</button>';
    }
    else if ($rsrvBy == $membId){
        if ($bkTit == $bknm){
            $rbutton = '<button type="submit" disabled>RESERVED</button>';
            $buttonmsg = "You reserve this book already...";
        }else{
            $rbutton = '<button type="submit" name="btn_save_updates" class="btn btn-default"><span class="glyphicon glyphicon-save"></span>RESERVE</button>';
        }
    }else if ($brBy == $mbId){
        if ($brkTit == $bknm){
            $rbutton = '<button type="submit" disabled>BORROWED</button>';
            $buttonmsg = "You borrow this book already...";
        }else{
            $rbutton = '<button type="submit" name="btn_save_updates" class="btn btn-default"><span class="glyphicon glyphicon-save"></span>RESERVE</button>';
        }
    }else{
        $rbutton = '<button type="submit" name="btn_save_updates" class="btn btn-default"><span class="glyphicon glyphicon-save"></span>RESERVE</button>';
    }
?>

    <tr>
        <td colspan="2"><h2>&nbsp;&nbsp;&nbsp;</h2> 
            <?php echo $rbutton; ?>
            <a class="btn btn-default" href="../membermodule/index.php"> <span class="glyphicon glyphicon-backward"></span> CANCEL </a> 
        </td>
    </tr>
    
    </table>
<?php
    if (empty($buttonmsg)){
        echo " ";
    }else{
        echo "<h2 style='color:orange;'>&nbsp;&nbsp;&nbsp;".$buttonmsg."</h2>";
    }
?>
</form>
<!--
<?php
    include('../includes/connect2.php');
    $reserveBy = $_SESSION['userName'];
    $num_result = mysql_query("SELECT r.*,m.username FROM reservation AS r LEFT JOIN member AS m ON m.username = r.reserveBy WHERE r.reserveBy = '{$_SESSION['userName']}'");
    $row = mysql_fetch_object($num_result);
    echo $row->reserveBy;
    echo $row->username;
    $rby = $row->reserveBy;
    $mus = $row->username;

    function buttoncondition($argument1,$argument2){
        if ($argument1 = $argument2){
            echo "True"; // button invisible
            $cant = "true";
        }else{
            echo "False"; // button visible
            $cant = "false";
        }
    }
    buttoncondition($rby,$mus);
    $cbutton = buttoncondition($rby,$mus);
    echo $cbutton;
?> -->

</div>


</div>
</body>
</html>
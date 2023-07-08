<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	require_once '../includes/connect5.php';
	
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT bookPic FROM booktitle WHERE id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("../book_images/".$imgRow['bookPic']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM booktitle WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: ../membermodule/index.php");
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
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutadmin.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../membermodule/memprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../membermodule/index.php">BOOK LIST</a></li>
		<li><a href="../membermodule/memreservation.php">TRANSACTION</a> </li>
		<li><a href="../logouts/logoutmem.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="container">

	<div class="page-header">
    	<h1 class="h2"><br/><center>--BOOKS--</center></h1> 
    </div>
<div class="sidebar_search">
	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" autofocus>
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="../design4all2/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="../design4all2/user_logout.png">
	</form>
</div>
    
<br />
<div class="row">

<?php
if(isset($_POST['search1'])){
	$search=$_POST['search'];
	$stmt = $DB_con->prepare("SELECT * FROM booktitle WHERE bookTitle like '%{$search}%' || author like '%{$search}%' || category like '%{$search}%'  ORDER BY id DESC");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="bookId" name="bookId" value="<?php echo $bookId; ?>"></p>
				<p class="page-header"><label class="control-label">Book Title : &nbsp;&nbsp;&nbsp;</label><?php echo $bookTitle; ?></p>
				<p class="page-header"><label class="control-label">Author : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $author; ?></p>
				<p class="page-header"><label class="control-label">Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $category; ?></p>
				<p class="page-header"><label class="control-label"><?php echo $description; ?></label></p>		
<!--<?php ?> for updating bookStatus
				<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p> -->
				<p class="page-header">	
				<span>&nbsp;&nbsp;
<!--				<?php $_SESSION['bookId'] = $bookId; 
				$_SESSION['bookTitle'] = $bookTitle; ?> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['bookId']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span>Reserve</a> 
<!--				<a class="btn btn-info" href="reservebook.php?reserve=<?php echo $row['bookTitle']; ?>" title="click for edit" onclick="return confirm('Redirect to the Book Records ?')"><span class="glyphicon glyphicon-edit"></span> RESERVE</a>  -->
				</span>
				</p>

			</div> 
			<br>      
			<?php
		}
	}
	else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
	}


}else{

	$stmt = $DB_con->prepare('SELECT * FROM booktitle ORDER BY id DESC');
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<img src="../book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="bookId" name="bookId" value="<?php echo $bookId; ?>"></p>
				<p class="page-header"><label class="control-label">Book Title : &nbsp;&nbsp;&nbsp;</label><?php echo $bookTitle; ?></p>
				<p class="page-header"><label class="control-label">Author : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $author; ?></p>
				<p class="page-header"><label class="control-label">Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $category; ?></p>
				<p class="page-header"><label class="control-label"><?php echo $description; ?></label></p>		
<!--<?php ?> for updating bookStatus
				<p class="page-header"><label class="control-label">Status : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $bookStatus; ?></p> -->
				<p class="page-header">	
				<span>&nbsp;&nbsp;
<!--				<?php $_SESSION['bookId'] = $bookId; 
				$_SESSION['bookTitle'] = $bookTitle; ?> -->
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['bookId']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span>Reserve</a> 
<!--				<a class="btn btn-info" href="reservebook.php?reserve=<?php echo $row['bookTitle']; ?>" title="click for edit" onclick="return confirm('Redirect to the Book Records ?')"><span class="glyphicon glyphicon-edit"></span> RESERVE</a>  -->
				</span>
				</p>

			</div> 
			<br>      
			<?php
		}
	}
	else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
	}
}
	
?>
</div>	




</div>


</div>
</div>
</body>
</html>
<?php 
session_start();
if(!$_SESSION['userName']){
	header('refresh:0.10;../cheatingmsg.php');
}
?>
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once '../includes/connect5.php';
	
	if(isset($_POST['btnsave']))
	{
		$bookId = $_SESSION['bookId'];
		$isbn = $_POST['isbn'];// isbn
		$bookTitle = $_SESSION['bookTitle'];// book title
		$author = $_SESSION['author'];
		$category = $_SESSION['category'];
		$bookStatus = $_POST['bookStatus'];

//		$description = $_POST['description'];
//		$releaseDate = $_POST['releaseDate'];
//		$bookStatus = $_POST['bookStatus'];
		
		if(empty($isbn)){
			$errMSG = "Please Enter Book ISBN.";
		}
		if(empty($bookStatus)){
			$errMSG = "Please Enter the Book Status.";
		}
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO bookrecord(bookId,isbn,bookTitle,author,category,bookStatus) VALUES(:bkid, :bisbn, :bbkt, :baut, :bcat, :bstat)');
			$stmt->bindParam(':bkid',$bookId);
			$stmt->bindParam(':bisbn',$isbn);
			$stmt->bindParam(':bbkt',$bookTitle);
			$stmt->bindParam(':baut',$author);
			$stmt->bindParam(':bcat',$category);
			$stmt->bindParam(':bstat',$bookStatus);

			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				$_SESSION['bookId'] = $bookId; 
				$_SESSION['bookTitle'] = $bookTitle;
				$_SESSION['author'] = $author;
				$_SESSION['category'] = $category;
				$_SESSION['description'] = $description;
				header("refresh:1;addbookdata.php"); // redirects image view page after a seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
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
<div class="right_header">Welcome <?php echo $_SESSION['userName']?><a href="../logouts/logoutslib.php" class="logout" onClick="return confirm('Are you sure to Log Out?')">  </a></div>
</div>
<div class="main_content">
	<div class="menu">
		<ul>
		<li><a href="../librarianmodule/libprofile.php">PROFILE</a> </li>
		<li><a class="current" href="../librarianmodule/index.php">BOOK LIST</a></li>
		<li><a href="../librarianmodule/memberlist.php">MEMBER USER LIST</a> </li>
		<li><a href="../librarianmodule/adreports.php">REPORTS</a></li>
		<li><a href="../librarianmodule/reserve.php">RESERVATION HISTORY</a></li>
		<li><a href="../logouts/logoutlib.php" onClick="return confirm('Are you sure to Log Out?')">LOG OUT</a></li>
		</ul>
	</div>
</div>
<div class="center_content"> 
<div class="container">


	<div class="page-header">
    	<h1 class="h2"> &nbsp;Adding New Book Record&nbsp;&nbsp;&nbsp;&nbsp;. <a class="btn btn-default" href="../librarianmodule/testindex.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; Stop Adding Records </a></h1>
    </div>
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">	
    <tr>
    	<td><label class="control-label">Book ID:</label></td>
        <td><input class="form-control" type="text" name="bookId" placeholder="Input Book ID or No." value="<?php echo $_SESSION['bookId']; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book ISBN:</label></td>
        <td><input class="form-control" type="text" name="isbn" placeholder="Input International Standard Book Number" value="<?php echo $isbn; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book Title:</label></td>
        <td><input class="form-control" type="text" name="bookTitle" placeholder="Book Name or Title" value="<?php echo $_SESSION['bookTitle']; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Author:</label></td>
        <td><input class="form-control" type="text" name="author" placeholder="Book Author or Editor" value="<?php echo $_SESSION['author']; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Category:</label></td>
        <td><input class="form-control" type="text" name="author" placeholder="Book Author or Editor" value="<?php echo $_SESSION['category']; ?>" /></td>
    </tr>
    <tr>
    	<td><label class="control-label">Book Status:</label></td>
    	<td><select name="bookStatus" value="<?php echo $bookStatus; ?>">
    		<option></option>
    		<option>available</option>
    		<option>unavailable</option>
    	</select></td>
    </tr>

    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
<div>
<?php
include('../includes/connect2.php');
$result=mysql_query("SELECT count(*) as bookTitle from bookrecord");
$data=mysql_fetch_assoc($result);
echo"<h3>Total of Books</h3> " .$data['bookTitle'];
?>
</div>

</div>



</div>


</body>
</html>
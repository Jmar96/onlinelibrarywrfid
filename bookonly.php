<?php 
	session_start();
	require_once('includes/connect1.php');
?>
<!DOCTYPE.html>
<html>
<head>
<title>OLS Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="shortcut icon" href="design/editingicon.png" />
<link rel="stylesheet" type="text/css" href="cssjava/loginstyle1.css">
<link href="cssjava/buttons.css" rel="stylesheet" media="screen">
</head>
<?php
$astat = "available"; ?>
<body bgcolor="lightblue">


<?php
require_once 'includes/connect5.php';

	$stmt = $DB_con->prepare("SELECT * FROM books WHERE bookStatus = '$astat' ORDER BY id DESC LIMIT 12 ");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-xs-3">
				<a href="#A" >
				<img src="book_images/<?php echo $row['bookPic']; ?>" class="img-rounded" width="250px" height="250px" />
				</a>
				
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> -->
				<a class="btn btn-info" href="#A"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> 

				</span></p>

			</div> 
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

	
?>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</div>


</body>
</html>
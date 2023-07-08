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
<body bgcolor="lightblue">
<?php
	if(isset($_POST['submit'])) {
		$memberId = $_POST['memberId'];
		$password = $_POST['password'];
		
		$result = $dbh->prepare("SELECT * FROM member WHERE memberId= :umid AND password= :pswo");
		$result->bindParam(':umid', $memberId);
		$result->bindParam(':pswo', $password);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		if($rows > 0) {
		
			$result=$dbh->prepare("SELECT * FROM member WHERE memberId=:umid");
			$result->bindParam(':umid', $memberId);
			$result->execute();
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				$res_id = $row['id'];
				$curr_status = $row['userStatus'];
				$mbid = $row['memberId'];
				$fn = $row['fullname'];
			}
			
				if($curr_status=='deactive') {
					$message = "Sorry <b>$username</b> ganda/pogeh, your account is temporarily deactivated, try contact the admin for activation!..";
				}else{
					$_SESSION['memId'] = $mbid;
					$_SESSION['userName'] = $fn;
					header("location: membermodule/index.php?logid=$res_id");
				}
			
		}
		else{
			$message = 'ID no. and Password are not exists.';
		}
	}
?>

<div id="header">
	<ul class="fly-in-text hidden">
	            <li>W</li>
	            <li>E</li>
	            <li>L</li>
	            <li>C</li>
	            <li>O</li>
	            <li>M</li>
	            <li>E</li>
	           
	</ul>
	<ul class="fly-in-text2 hidden">
	            <li>t</li>
	            <li>o</li>
	           
	</ul>
	<ul class="fly-in-text3 hidden">
	            <li>A</li>
	            <li>M</li>
	            <li>A</li>
	           
	</ul>
	<ul class="fly-in-text4 hidden">
	            <li>O</li>
	            <li>N</li>
	            <li>L</li>
	            <li>I</li>
	            <li>N</li>
	            <li>E</li>
	            <li></li>
	            <li><a href="indexlib.php" style="text-decoration: none; color: #fff;" onClick="return confirm('Are you an librarian?')">L</a></li>
	            <li>I</li>
	            <li>B</li>
	            <li>R</li>
	            <li>A</li>
	            <li>R</li>
	            <li>Y</li>
	            <li></li>
	            <li>S</li>
	            <li>Y</li>
	            <li>S</li>
	            <li>T</li>
	            <li>E</li>
	            <li>M</li>
	</ul>
	<script src="cssjava/jquery.min.js"></script>
	<script type="text/javascript">
	            
	            $(function() {
	                
	                setTimeout(function() {
	                    $('.fly-in-text').removeClass('hidden');
	                }, 500);
	                
	            })();
	            
	</script>
	<script type="text/javascript">
	            
	            $(function() {
	                
	                setTimeout(function() {
	                    $('.fly-in-text2').removeClass('hidden');
	                }, 500);
	                
	            })();
	            
	</script>
	<script type="text/javascript">
	            
	            $(function() {
	                
	                setTimeout(function() {
	                    $('.fly-in-text3').removeClass('hidden');
	                }, 500);
	                
	            })();
	            
	</script>
	<script type="text/javascript">
	            
	            $(function() {
	                
	                setTimeout(function() {
	                    $('.fly-in-text4').removeClass('hidden');
	                }, 500);
	                
	            })();
	            
	</script>
<!--	<div align="left"><a style="text-decoration: none;" href="mihr/index.php" class="login" onClick="return confirm('Are you an admin?')"> &nbsp;­&nbsp;­&nbsp;­&nbsp;­ </a>
	</div>
	<div class="right_header">WELCOME<a href="indexlib.php" class="logout" onClick="return confirm('Are you an Librarian?')">  </a></div> -->
</div>
<!--	<script src="cssjava/jquery.min.js"></script>
	<script type="text/javascript">
			(function() {

                var navLinks = $('nav ul li a'),
                    navH = $('nav').height(),
                    section = $('section'),
                    documentEl = $(document);
                
                documentEl.on('scroll', function() {
                    var currentScrollPos = documentEl.scrollTop();
                    
                    section.each(function() {
                        var self = $(this);
                        if ( self.offset().top < (currentScrollPos + navH) && (currentScrollPos + navH) < (self.offset().top + self.outerHeight()) ) {
                            var targetClass = '.' + self.attr('class') + '-marker';
                            navLinks.removeClass('active');
                            $(targetClass).addClass('active');
                        }
                    });
                    
                });
			})();
	</script> 
<nav>
	<ul>
		<li><a href="index.php">HOME</a></li>
		<li><a href="olsregistration.php">SIGN UP</a></li>
		<li><a href="#">CATEGORIES</a></li>
		<li><a href="#">CONTACTS</a></li>
	</ul>
</nav> -->
<div id="categ">
	<ul id="clist">
		<li><a href="index.php">HOME</a></li>
		<li><a href="#A">CATEGORIES</a>
			<ul>
				<?php
				require_once 'includes/connect5.php';
				$book_categories = $DB_con->prepare("SELECT * FROM bcategories ORDER BY catTitle");
				$book_categories->execute();
				if($book_categories->rowCount() > 0){
					while($row=$book_categories->fetch(PDO::FETCH_ASSOC)){
						extract($row);
				?>
					<li>

						<form action="" method="post">
						<input type="submit" name="search2" value="<?php echo $row['catTitle'];?>">
						</form>

					</li>
				<?php
					}
				}
				?>	
			</ul>
		</li>
		<li><a href="olsregistration.php">SIGN UP</a></li>
		<li><a href="#">CONTACTS</a></li>
	</ul>

</div>
<a name="A">
<div class="sidebar_search">

	<form action="" method="post">
		<input class="search_input" name="search" type="search" placeholder="Search keyword" >
		<input class="search_submit" type="image" name="search1" value="SEARCH" src="design/search.png">
		<input class="cancel_submit" type="image" name="back" value="CANCEL" src="design/user_logout.png">
	</form>
</div>
<!--//MEMBER LOGIN
<section class="login"> -->
<div class="login-container">
<a href="#" class="login-button">Login</a>
<blockquote> 
<table class="login">
	<tr>
		<th>ID No.</th><th>Password</th><th></th>
	</tr>
	<tr>
		<td>
			<form class="login_input" action="index.php" method="post">
				<input class="login_input" type="text" name="memberId" id="memberId" value="" placeholder="RFID No." />
		</td>
		<td>
				<input class="login_input" type="password" name="password" id="password" value="" placeholder="Password" />
		</td>		
				<?php
					if(!empty($message)){
						echo "<p style='color:red; padding:2px; font-size:15px;'>".$message." </p>";
					}
				?>
		<td>
				<input type="submit" name="submit" value=" LOGIN " class="btn btn-primary btn-small"/>
		</td>
	</tr>
	<tr>
	<td></td>
		<td colspan="2"><a style="text-decoration: none; color: white;" href="forgotpassw.php">Forgot your password?</a> </td>
	</tr>
			</form>	
</table> </blockquote> 
<script src="cssjava/jquery2.min.js"></script>
        <script type="text/javascript">
            
            (function(){
                
                var quoteButton = $('.login-button'),
                    blockquote = $('blockquote');
                
                quoteButton.on('click', function(e) {
                    e.preventDefault();
                    var quoteButtonText = quoteButton.text();
                    
                    blockquote.slideToggle(01, function(){
                        quoteButtonText == "Login" ? quoteButton.text("Close") : quoteButton.text("Login");
                    });
    
                });
                
            })();
            
        </script>
<!-- </section> -->
</div>
</a>
<div id="main_container">

<!-- BOOKS -->
<div class="container">

<div class="row">
<h1 align="left" style="color: #fff;">BOOKS</h1>
<?php
require_once 'includes/connect5.php';
$astat = "available";
if(isset($_POST['search1'])){
	$search=$_POST['search'];
	// select from books where data like search and bookStatus = available
	$stmt = $DB_con->prepare("SELECT * FROM books WHERE isbn like '%{$search}%' || bookName like '%{$search}%' || author like '%{$search}%' || category like '%{$search}%' || description like '%{$search}%' AND bookStatus = '$astat' ORDER BY id DESC");
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
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> 
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> -->
				<a class="btn btn-info" href="#A"><?php echo $bookName; ?></a> 
				</span></p>


				<p class="page-header">	
				<span>&nbsp;&nbsp;
				</span>
				</p>

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

}else if (isset($_POST['search2'])){
	$csearch = $_POST['search2'];
	$stmt = $DB_con->prepare("SELECT * FROM books WHERE category like '%{$csearch}%' ORDER BY bookName");
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
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label">&nbsp;&nbsp;&nbsp;</label><span>&nbsp;&nbsp;
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> 
				<a class="btn btn-info" href="reservebook.php?reserve_id=<?php echo $row['isbn']; ?>" title="click for reserve" onclick="return confirm('Reserve this Book ?')"><span class="glyphicon glyphicon-edit"></span><?php echo $bookName; ?></a> -->
				<a class="btn btn-info" href="#A"><?php echo $bookName; ?></a> 
				</span></p>


				<p class="page-header">	
				<span>&nbsp;&nbsp;
				</span>
				</p>

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

}else{
$astat = "available";
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
				<p class="page-header"><input class="control-label" type="hidden" id="id" name="id" value="<?php echo $id; ?>"></p>
				<p class="page-header"><input class="control-label" type="hidden" id="isbn" name="isbn" value="<?php echo $isbn; ?>"></p>
				<p class="page-header"><label class="control-label"></label><span>
<!--				<?php $_SESSION['isbn'] = $isbn; 
				$_SESSION['bookName'] = $bookName; ?> -->
				<a class="btn btn-info" href="#A"><?php echo $bookName; ?></a> 

				</span></p>
				<p class="page-header">	
				
				</p>

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
}
	
?>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</div>
</div>

</body>
</html>
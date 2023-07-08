<?php
	include_once('../includes/connect5.php');

	$stmt = $DB_con->prepare ("SELECT COUNT(*) from admin");
	$stmt->execute();
	$result = $stmt->bindParam('*', $id, PDO::PARAM_INT) or die (mysql_error());
	$rows = array();
//it should be while ($row = mysql_fetch_array($query)) { below but written $rows=array(); above
	$r=$stmt->fetch($result) or die (mysql_error());
//the fetch above is from while while($row=$stmt->fetch(PDO::FETCH_ASSOC)) below
	$numrows=$r[0];
	$rowsperpage = 3;
	$totalpages = ceil($numrows/$rowsperpage);
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])){
		$currentpage = (int) $_GET['currentpage'];
	}else{
		$currentpage = 1;
	}
	if ($currentpage > $totalpages){
		$currentpage = $totalpages;
	}
	if ($currentpage <1){
		$currentpage =1;
	}
	$offset = ($currentpage-1)*$rowsperpage;	

	//$epr='';
	//set no value of $epr

	if(isset($_GET['delete_id'])){
		//select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT userPic FROM admin WHERE id=:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['userPic']);
		//it will delete an acctual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM admin WHERE id=:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		header("Location:../adminmodule/index.php");
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
<h3 align="center">Add Admin</h3>
<form method="POST" action="">
	<table align="center">
	<tr>
		<td>Admin ID :</td>
		<td><input type="number" name="textai"></td>
	</tr>
	<tr>
		<td>Username :</td>
		<td><input type="text" name="textun"></td>
	</tr>
	<tr>
		<td>Password :</td>
		<td><input type="text" name="textpw"></td>
	</tr>
	<tr>
		<td>Fullname :</td>
		<td><input type="text" name="textfn"></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td><input type="text" name="textad"></td>
	</tr>
	<tr>
		<td>Contact No :</td>
		<td><input type="number" name="textno"></td>
	</tr>	
	<tr>
		<td>Email Address :</td>
		<td><input type="email" name="textea"></td>
	</tr>
	<tr>
		<td>Retrieving Phrase :</td>
		<td><input type="text" name="textrp"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="btn btn-primary btn-small" name="btnsave" value="ADD"></td>
	</tr>
	</table>
</form>
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
		$stmt=$DB_con->prepare("SELECT * from admin where username like '%{$search}%' || password like '%{$search}%' || fullname like '%{$search}%' || address like '%{$search}%' || address like '%{$search}%' || contactNo like '%{$search}%' || emailAddress like '%{$search}%' limit $offset,$rowsperpage");
		$stmt->execute();
		if ($stmt->rowCount() > 0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<tr>
					<td>".$row['adminId']."</td>
					<td>".$row['username']."</td>
					<td>".$row['password']."</td>
					<td>".$row['fullname']."</td>
					<td>".$row['address']."</td>
					<td>".$row['contactNo']."</td>
					<td>".$row['emailAddress']."</td>
					<td></td>

				</tr>";
			}
		}else{
			echo "<P> <B>No Admin Found </P>";
		}
	}
	else{
	$stmt = $DB_con->prepare("SELECT * FROM admin ORDER BY id DESC limit $offset,$rowsperpage");
	$stmt->execute();
	if($stmt->rowCount() > 0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>
				<td>".$row['adminId']."</td>
				<td>".$row['username']."</td>
				<td>".$row['password']."</td>
				<td>".$row['fullname']."</td>
				<td>".$row['address']."</td>
				<td>".$row['contactNo']."</td>
				<td>".$row['emailAddress']."</td>
				<td>

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
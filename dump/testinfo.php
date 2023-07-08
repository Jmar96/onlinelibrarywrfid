<?php
session_start();;
//require 'connection.php';

$aql = "SELECT * FROM member WHERE email = '".$_SESSION['info']."'";
$aqlq=mysqli_query($connect,$sql);
$aqlqq=mysqli_fetch_assoc($aqlq);

$u=$aqlqq['username'];
$p=$aqlqq['password'];

echo "your information is "."<br>".$u."<br>".$p;


?>



<?php
$newpass = getRandomString(10);
				
				//echo $newpass;
				$stmt = $dbh->prepare("UPDATE member SET password=:pas WHERE email=:emil ");
				$stmt->bindParam(':pas',$newpass);
				$stmt->bindParam(':emil',$email);
				if ($stmt->execute()){
					$checkpass = $dbh->prepare("SELECT * FROM member WHERE emailAddress=:emal");
					$checkpass->bindParam(':emal', $email);
					$checkpass->execute();
					while($row = $checkpass->fetch(PDO::FETCH_ASSOC)){
					$mem_id = $row['id'];
					$membId = $row['memberId'];
					$passwor = $row['password'];
					$fnam = $row['fullname'];
					$cntn = $row['contactNo'];
					$currnt_status = $row['userStatus'];
					$retriv = $row['retrieve'];
					}
				}

?>
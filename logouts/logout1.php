<?php// error not working
	session_start();
	session_unset();
	session_destroy();

	if($_SESSION['userName'] == ""){
		echo"Successfull";
		header("refresh:10; ../mihr/index.php");

	}else{
		echo"error";
	}
?>
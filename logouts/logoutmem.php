<?php
session_start();
unset($_SESSION['userName']);
unset($_SESSION['memId']);
session_destroy();
echo"<h1>Successfully Logout</h1>";
header("refresh:0.1; ../index.php");
exit;
?>

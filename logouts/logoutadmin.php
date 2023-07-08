<?php
session_start();
unset($_SESSION['userName']);
session_destroy();
echo"<h1>Successfully Logout</h1>";
header("refresh:0.1; ../indexlib.php");
exit;
?>
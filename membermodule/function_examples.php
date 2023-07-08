<?php
    include('../includes/connect2.php');
    $num_result=mysql_query("SELECT COUNT(*) as bookId from bookrecord WHERE bookId = '{$_SESSION['reserve_id']}'") or exit(mysql_error());
    $row=mysql_fetch_object($num_result);
    echo "<h3>Quantity : ";
    echo $row->bookId;
    $quantity = $row->bookId;
?>
<?php  
    $num_result = mysql_query("SELECT count(*) as bookStatus from bookrecord where bookStatus = 'unavailable' ") or exit(mysql_error());
    $row = mysql_fetch_object($num_result);
    echo "<h3>Unavailable : ";
    echo $row->bookStatus;
    $ua = $row->bookStatus;
?> 
<?php  
    $num_result = mysql_query("SELECT count(*) as bookStatus from bookrecord where bookStatus = 'available' and bookId = '{$_SESSION['reserve_id']}' ") or exit(mysql_error());
    $row = mysql_fetch_object($num_result);
    echo "<h3>Available : ";
    echo $row->bookStatus;

    $av = $row->bookStatus;
?> 
<?php
 function rescondition($avail){
    if ($avail < 1) {
        echo "";
    }else{
        echo "RESERVE";
    }
 }
 
?>
<?php
 function msgcondition($avail){
    if ($avail > 1) {
        echo "Low of Stock";
    }else{
        echo "RESERVE (only for 3 hours)";
    }
 }
 
?>
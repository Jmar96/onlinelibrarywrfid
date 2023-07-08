<?php
$row6=mysql_query("SELECT r.*,b.description,b.isbn,b.bookPic FROM reservation AS r LEFT JOIN books AS b ON r.bookId = b.isbn WHERE r.id ='$id' ");
?>
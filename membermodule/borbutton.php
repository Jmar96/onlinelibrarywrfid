<?php
	$borbutton = mysql_query("SELECT b.*,u.memberId FROM issuedbook AS b LEFT JOIN member AS u ON u.memberId = b.rfid WHERE b.rfid = '{$_SESSION['memId']}' AND b.bookTitle = '$bookName' ");
    $row3 = mysql_fetch_object($borbutton);
    if (empty($row3)){
        $mbId = "can969";
    }else{
        $row3->rfidNo;
        $row3->memberId;
        $row3->bookTitle;
        $brBy = $row3->rfid;
        $mbId = $row3->memberId;
        $brkTit = $row3->bookTitle;
    }
?>


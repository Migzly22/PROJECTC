<?php

require("../Database.php");
session_start();
ob_start();

$data = "
<table class='table'>
    <thead>
        <tr>
            <th scope='col' style='text-align:start;border:1px solid black;'>Date</th>
            <th scope='col' style='text-align:start;border:1px solid black;'>Mode of Payment</th>
            <th scope='col' style='text-align:center;border:1px solid black;'>Amount</th>
        </tr>
    </thead>
    <tbody id='TBODYELEMENT'>
";

$sqlcodeTable = $_GET["sqlcode"];
$paymentquery = mysqli_query($conn, $sqlcodeTable);

while ($paymentresult = mysqli_fetch_assoc($paymentquery)) {
    $data .= "<tr>
        <td style='text-align:start;border:1px solid black;'>".$paymentresult['PaymentDate']."</td>
        <td style='text-align:start;border:1px solid black;'>".$paymentresult['PaymentMethod']."</td>
        <td style='text-align:end;border:1px solid black;'>".$paymentresult['AmountPaid']."</td>
    </tr>";
}

$data .= "</tbody></table>";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=download.xls");
echo $data;
exit();
?>
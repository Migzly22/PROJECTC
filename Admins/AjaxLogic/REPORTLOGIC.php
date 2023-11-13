<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT * FROM guestpayments a ORDER BY PaymentDate DESC;";


function CHART($conn, $sqlcode3){
    $querynum3 = mysqli_query($conn,$sqlcode3);

    $arraychartdata = array();
    while ($result = mysqli_fetch_assoc($querynum3)) {
        $arraychartdata[$result["month"]] = $result["monthamount"];
    }
    $jsonString = json_encode($arraychartdata);
    echo $jsonString;
}
function PRINTING($conn, $sqlcode3){
 
    $querynum3 = mysqli_query($conn,$sqlcode3);
    $table5 = "";

    while ($result = mysqli_fetch_assoc($querynum3)) {
        # code...
        $table5 .=  "
        <tr>
            <th style='text-align:start;'>".$result['PaymentDate']."</th>
            <td style='text-align:start;'>".$result['PaymentMethod']."</td>
            <td style='text-align:end;'>₱ ".$result['AmountPaid']."</td>
        </tr>
        ";
    }

    if (mysqli_num_rows($querynum3) == 0) {
        $table5 = "     <tr>
            <td colspan='3' style='text-align:center; font-weight:bolder;'>No data </td>
        </tr> ";
    }
    echo $table5;
}

switch ($_POST["Process"]) {
    case 'Search':
        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn, $sqlcode3);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $sqlcode3);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $sqlcode3);
        break;        
    case 'Insertmore':   
        mysqli_query($conn,$sqlcode);
        break;    
    case 'Chart':
        CHART($conn, $sqlcode);
        break;
    case 'ChartSpecific':
        $querynum3 = mysqli_query($conn,$sqlcode);
        $result = mysqli_fetch_assoc($querynum3)["Amount"];
        echo $result;
        break;
    default:
        # code...
        break;
}
<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT  a.*, b.*, IF(b.Description = 'Downpayment', 'Done', 'Pending') AS STATUSHEHE FROM reservations a LEFT JOIN guestpayments b ON a.ReservationID = b.ReservationID WHERE a.UserID = 16 AND b.Description ='Downpayment' ORDER BY a.ReservationID DESC;";


function PRINTING($conn, $sqlcode3){
 
    $querynum3 = mysqli_query($conn,$sqlcode3);
    $table5 = "";
    while ($result = mysqli_fetch_assoc($querynum3)) {
        # code...
        $table5 .= "
            <tr>
                <td scope='col' style='text-align: center;'>".$result['CheckInDate']."</td>
                <td scope='col' style='text-align: center;'>".$result['CheckOutDate']."</td>
                <td scope='col' style='text-align: end;'>".$result['TotalPrice']."</td>
                <td scope='col' style='text-align: end;'>".$result['Downpayment']."</td>
                <td scope='col' style='text-align: center;'>".$result['STATUSHEHE']."</td>
                <td class='ActionTABLE' id='".$result['ReservationID']."'>
                    <button class='addbtn' onclick='VIEW(`".$result['ReservationStatus']."`,`".$result['GuestID']."`)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z'/></svg>
                    </button>
                </td>
            </tr>
        ";
    }

    if (mysqli_num_rows($querynum3) == 0) {
        $table5 = "     <tr>
            <td colspan='6' style='text-align:center; font-weight:bolder;'>No data </td>
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
    default:
        # code...
        break;
}
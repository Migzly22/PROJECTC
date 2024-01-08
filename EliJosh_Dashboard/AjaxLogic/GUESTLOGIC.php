<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT a.*, b.*, CONCAT(a.LastName,', ', a.FirstName) as Name FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID ORDER BY a.Lastname, a.Firstname;";


function PRINTING($conn, $sqlcode3){
 
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $data1 .= "
        <tr>
            <td>
                <p>".$result['Name']."</p>
            </td>
            <td>".$result['Email']."</td>
            <td>".$result['eCheckin']."</td>
            <td>".$result['finalCheckout']."</td>
            <td class='TableBtns'>
                <a class='OpenBTN' href='./index.php?nzlz=guest_info&ISU=".$result['GuestID']."'  rel='noopener noreferrer'>
                    <i class='fa-regular2 fa-regular fa-eye'></i>
                </a>
            </td>
        </tr>";
    }

    if(mysqli_num_rows($queryrun1) <= 0){
        $data1 .= "
        <tr>
            <td>No Data</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>";
    }
    echo $data1;
}

switch ($_POST["Process"]) {
    case 'Search':
        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn, $default);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $default);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $default);
        break;     
    case 'Specialmention':
        $sqlcode2 = "SELECT
        (a.TotalPrice +COALESCE(b.ExtraChargeSum, 0)) AS TotalOverall,
        (a.TotalPrice +COALESCE(b.ExtraChargeSum, 0)) - SUM(c.AmountPaid) AS Balance
    FROM reservations a
    LEFT JOIN (
        SELECT ReservationID, SUM(ChargeAmount) AS ExtraChargeSum
        FROM guestextracharges
        GROUP BY ReservationID) b ON a.ReservationID = b.ReservationID
    LEFT JOIN guestpayments c ON a.ReservationID = c.ReservationID
    WHERE a.ReservationID = '$sqlcode';";


        $special = mysqli_query($conn,$sqlcode2);
        $result = mysqli_fetch_assoc($special);
        echo $result["Balance"];

        break;      
    case 'Insertmore':   
        mysqli_query($conn,$sqlcode);
        break;    
    default:
        # code...
        break;
}
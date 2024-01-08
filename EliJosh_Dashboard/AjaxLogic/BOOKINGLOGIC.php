<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID ORDER BY a.CheckInDate DESC;";


function PRINTING($conn, $sqlcode3){
 
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $time = $result['eCheckin'];
        $statuscolor = ($result['ReservationStatus'] == "BOOKED" ? "process" : ($result['ReservationStatus'] == "CANCELLED" ? "pending" : "completed"));
        
        $data1 .= "
        <tr>
            <td style='display:flex;flex-direction:column;align-items:start;'>
                <p>".$result['Name']."</p>
                <small><i>".$result['Email']."</i></small>
            </td>
            <td>$time</td>
            <td>".$result['finalCheckout']."</td>
            <td><a href='#' onclick='showChangeStatus(`".$result['ReservationID']."`,`".$result['ReservationStatus']."`)'><span class='status $statuscolor'>".$result['ReservationStatus']."</span></a></td>
            <td class='TableBtns' >
                <a class='EditBTN' href='./index.php?nzlz=booking_info&ISU=".$result['ReservationID']."'  rel='noopener noreferrer'>
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
    case 'CheckingOUT':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $default);
        break; 
    default:
        # code...
        break;
}
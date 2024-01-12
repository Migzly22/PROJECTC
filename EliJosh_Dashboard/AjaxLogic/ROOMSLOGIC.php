<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT c.*, CONCAT(TIME(d.eCheckin), ' to ', TIME(d.CheckOutDate)) AS DT, IF(d.ReservationStatus IS NULL, 'Available', IF(d.ReservationStatus = 'CANCELLED', 'Available', d.ReservationStatus)) AS Status FROM rooms c LEFT JOIN (SELECT a.*, b.* FROM roomsreservation a LEFT JOIN (SELECT * FROM reservations WHERE CheckInDate = CURRENT_DATE() AND ReservationStatus != 'CHECKOUT') b ON a.greservationID = b.ReservationID WHERE b.ReservationID IS NOT NULL) d ON c.RoomNum = d.Room_num GROUP BY c.RoomID ORDER BY c.RoomNum ;";


function PRINTING($conn, $sqlcode3){
 
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...

        $statuscolor = ($result['Status'] == "BOOKED" ? "process" : ($result['Status'] == "Available" ? "pending" : "completed"));

        $data1 .= "
        <tr>
            <td>".$result["RoomNum"]."</td>
            <td>".$result["RoomType"]."</td>
            <td>".$result["DT"]."</td>
            <td><span class='status $statuscolor'>".$result['Status']."</span></td>
        </tr>
        ";
    }
    if(mysqli_num_rows($queryrun1) <= 0){
        $data1 .= "
        <tr>
            <td>No Data</td>
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
    default:
        # code...
        break;
}
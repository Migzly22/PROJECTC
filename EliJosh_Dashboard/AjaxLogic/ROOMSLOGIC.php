<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT a.*, a.RoomType AS roomname, f.*, if(f.ReservationStatus is null, 'Available', f.ReservationStatus) AS Status, CONCAT(g.LastName, ', ', g.FirstName) AS Name
FROM rooms a
LEFT JOIN (
    SELECT d.*, e.*
    FROM roomsreservation d
    LEFT JOIN reservations e ON d.greservationID = e.ReservationID
    WHERE (e.ReservationStatus != 'CHECKOUT') AND (DATE(e.CheckInDate) <= CURRENT_DATE AND e.CheckOutDate >= CURRENT_TIMESTAMP)
) f ON f.Room_num = a.RoomID
LEFT JOIN guests g ON f.GuestID = g.GuestID
ORDER BY a.RoomID;";


function PRINTING($conn, $sqlcode3){
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...

        $statuscolor = ($result['Status'] == "BOOKED" ? "process" : ($result['Status'] == "Available" ? "pending" : "completed"));

        $data1 .= "
        <tr>
            <td>".$result["RoomType"]."</td>
            <td>".$result["Name"]."</td>
            <td>".$result["eCheckin"]."</td>
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
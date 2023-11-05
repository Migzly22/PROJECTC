<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];


function PRINTING($conn,  $sqlcodeRF = "SELECT a.*,d.* FROM rooms a LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num LEFT JOIN greservations c ON b.greservationID = c.ReservationID LEFT JOIN roomtypes d ON a.RoomType = d.RoomType ORDER BY a.RoomID"){
    $options = "";
    $queryRF = mysqli_query($conn,$sqlcodeRF);
    while ($resultRF = mysqli_fetch_assoc($queryRF)) {
        $options .= "<option value='".$resultRF['RoomNum']."'>".$resultRF['RoomNum']."-".$resultRF['RoomType']."</option>";
        # code...
    }
    echo $options;
}

switch ($_POST["Process"]) {
    case 'Search':
        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn);
        break;        
    case 'PaymentTime':
        $_SESSION["Newcustomerappointment"] = $sqlcode;
        break;       
    default:
        # code...
        break;
}
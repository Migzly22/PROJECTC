<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

if(isset( $_POST["sqlcode2"])){
    $sqlcode2 = $_POST["sqlcode2"];
}



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
        $query =  mysqli_query($conn,$sqlcode2);
        echo mysqli_fetch_assoc($query)["GuestID"];
        break;   


    case 'UpdateGuest':
        mysqli_query($conn,$sqlcode);
        $query =  mysqli_query($conn,$sqlcode2);
        echo mysqli_fetch_assoc($query)["GuestID"];
        break;   
    case 'UpdateReservation':
        mysqli_query($conn,$sqlcode);
        $query =  mysqli_query($conn,$sqlcode2);
        echo mysqli_fetch_assoc($query)["ReservationID"];
        break;  
    case 'Insertmore':   
        mysqli_query($conn,$sqlcode);
        break;  
    case 'Insertmore2':   
        $sqlcode = floatval($sqlcode);
        $sqlcode11 = "UPDATE reservations SET TotalPrice = TotalPrice + $sqlcode WHERE ReservationID = '".$_POST["IDS"]."'";
    
        mysqli_query($conn,$sqlcode11);
        break;  
    default:
        # code...
        break;
}
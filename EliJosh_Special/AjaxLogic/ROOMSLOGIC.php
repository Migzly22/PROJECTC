<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT a.*, d.*, if(d.Status1 IS NULL, 'Available', d.Status1) AS Status FROM rooms a 
LEFT JOIN (SELECT  b.*, IF(c.ReservationStatus IS NULL, 'Available', c.ReservationStatus) AS Status1, CONCAT(c.CheckInDate, ' to ', c.CheckOutDate) AS DT FROM roomsreservation b LEFT JOIN reservations c ON b.greservationID = c.ReservationID  WHERE CURDATE() BETWEEN c.CheckInDate AND c.CheckOutDate) d ON a.RoomNum = d.Room_num
ORDER BY a.RoomID;";


function PRINTING($conn, $sqlcode3){
 
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...

        $statuscolor = ($result['Status'] == "BOOKED" ? "process" : ($result['Status'] == "Available" ? "pending" : "completed"));
        
        if ($_SESSION["ACCESS"] == "ADMIN"){
            $tablebuttnon = "<td class='TableBtns'>
            <div class='DeleteBTN' onclick='DELETION(this,`".$result["RoomID"]."`)'>
                <i class='bx bx-trash-alt' ></i>
            </div>
        </td>";
        }else{
            $tablebuttnon = "";
        }


        $data1 .= "
        <tr>
            <td>".$result["RoomNum"]."</td>
            <td>".$result["RoomType"]."</td>
            <td>".$result["DT"]."</td>
            <td><span class='status $statuscolor'>".$result['Status']."</span></td>
            $tablebuttnon
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
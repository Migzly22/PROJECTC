<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT a.*, d.* FROM rooms a 
LEFT JOIN (SELECT  b.*, IF(c.ReservationStatus IS NULL, 'Available', c.ReservationStatus) AS Status, CONCAT(c.CheckInDate, ' to ', c.CheckOutDate) AS DT FROM roomsreservation b LEFT JOIN reservations c ON b.greservationID = c.ReservationID  WHERE CURDATE() BETWEEN c.CheckInDate AND c.CheckOutDate) d ON a.RoomNum = d.Room_num
ORDER BY a.RoomID;";


function PRINTING($conn, $sqlcode3){
 
    $querynum3 = mysqli_query($conn,$sqlcode3);
    $table5 = "";

    while($result3 = mysqli_fetch_assoc($querynum3)){
        if ($_SESSION["ACCESS"] == "ADMIN"){
            $tablebuttnon = "<td class='ActionTABLE' id='".$result3["RoomID"]."'>
                <button class='Deletebtn' onclick='DELETION(this)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                </button>
            </td>";
        }else{
            $tablebuttnon = "";
        }
        $table5 .= "
            <tr>
                <td>".$result3["RoomNum"]."</td>
                <td>".$result3["RoomType"]."</td>
                <td>".$result3["Status"]."</td>
                <td style='text-align: center;'>".$result3["DT"]."</td>
                $tablebuttnon
            </tr>
                ";
        }

    if (mysqli_num_rows($querynum3) == 0) {
        $table5 = "     <tr>
            <td colspan='5' style='text-align:center; font-weight:bolder;'>No data </td>
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
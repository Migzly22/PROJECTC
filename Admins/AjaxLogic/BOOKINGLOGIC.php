<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID ORDER BY a.CheckInDate DESC;";


function PRINTING($conn, $sqlcode3){
 
    $querynum3 = mysqli_query($conn,$sqlcode3);
    $table5 = "";

    while ($result = mysqli_fetch_assoc($querynum3)) {
        # code...
        $table5 .= "
            <tr>
                <td>".$result['Name']."</td>
                <td>".$result['Email']."</td>
                <td scope='col' style='text-align: center;'>".$result['CheckInDate']."</td>
                <td scope='col' style='text-align: center;'>".$result['CheckOutDate']."</td>
                <td scope='col' style='text-align: end;'>".$result['TotalPrice']."</td>
                <td scope='col' style='text-align: end;'>".$result['Downpayment']."</td>
                <td class='ActionTABLE' id='".$result['GuestID']."'>
                    <button class='Editbtn' onclick='EDIT(`".$result['ReservationStatus']."`)'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/></svg>
                    </button>
                </td>
        </tr>
        ";
    }

    if (mysqli_num_rows($querynum3) == 0) {
        $table5 = "     <tr>
            <td colspan='7' style='text-align:center; font-weight:bolder;'>No data </td>
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
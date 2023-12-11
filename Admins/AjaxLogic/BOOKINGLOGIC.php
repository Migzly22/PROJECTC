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
        $RESERVATIONDETAILS = "
        <td scope='col' >
            ".$result['ReservationStatus']."
            <select>
                <option value='BOOKED'>Booked</option>
                <option value='CHECKIN'>Check-in</option>
                <option value='CANCELLED'>Cancelled</option>
            </select>
        </td>";
        $select1 = "";$select2 = "";$select3 = "";
        switch ($result['ReservationStatus']) {
            case 'BOOKED':
                $select1 = "selected";
                break;
            case 'CHECKIN':
                $select2 = "selected";
                break;
            case 'CANCELLED':
                $select3 = "selected";
                break;
        }
        $RESERVATIONDETAILS = "
        <td scope='col' >
            <div class='ACCESSTABLE'>
                <select  onchange='CHANGESTATE(this,`".$result['ReservationID']."`)'>
                    <option value='BOOKED' $select1>Booked</option>
                    <option value='CHECKIN' $select2>Check-in</option>
                    <option value='CANCELLED' $select3>Cancelled</option>
                </select>                   
            </div>
        </td>";

        if($result['ReservationStatus'] == "CHECKOUT"){
            $RESERVATIONDETAILS = "<td scope='col' >Check out</td>";
        }

        # code...
        $table5 .= "
        <tr>
            <td>".$result['Name']."</td>
            <td>".$result['Email']."</td>
            <td scope='col' style='text-align: center;'>".$result['eCheckin']."</td>
            <td scope='col' style='text-align: center;'>".$result['finalCheckout']."</td>
            $RESERVATIONDETAILS
            <td class='ActionTABLE' id='".$result['ReservationID']."'>
                <button class='addbtn' onclick='VIEW(`".$result['ReservationStatus']."`,`".$result['GuestID']."`)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z'/></svg>
                </button>
                <button class='addbtn' onclick='PAYMENT(`".$result['ReservationID']."`)'>
                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M64 0C46.3 0 32 14.3 32 32V96c0 17.7 14.3 32 32 32h80v32H87c-31.6 0-58.5 23.1-63.3 54.4L1.1 364.1C.4 368.8 0 373.6 0 378.4V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V378.4c0-4.8-.4-9.6-1.1-14.4L488.2 214.4C483.5 183.1 456.6 160 425 160H208V128h80c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H64zM96 48H256c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zM64 432c0-8.8 7.2-16 16-16H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm48-168a24 24 0 1 1 0-48 24 24 0 1 1 0 48zm120-24a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM160 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM328 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM256 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM424 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM352 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48z'/></svg>
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


function SPECIALPARTS($conn, $sqlcode3){

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
    case 'CheckingOUT':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $sqlcode3);
        break; 
    default:
        # code...
        break;
}
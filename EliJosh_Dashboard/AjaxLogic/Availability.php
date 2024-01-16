<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

switch ($_POST['tday']) {
    case 'Day':
        # code...
        $datas = "17:00";
        break;
    case 'Night':
        # code...
        $datas = "07:00";
        break;    
    case '22Hrs':
        # code...
        $datas = "12:00";
        break;
}

switch ($sqlcode) {
    case 'Package1':
        # code...
        $sqlcode3 = "SELECT a.*, f.*, CONCAT(a.CottageType, '-', a.Cottagenum) AS cottagename FROM 
        (SELECT b.*, c.* FROM cottage b LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName) a 
        LEFT JOIN
        (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM cottagereservation d LEFT JOIN reservations e ON d.reservationID = e.ReservationID 
        WHERE e.CheckInDate = '".$_POST['cin']."' 
        AND (e.timapackage = '".$_POST['tday']."' OR e.timapackage = '22Hrs')) f ON a.Cottagenum = f.cottagenum WHERE f.cr_id IS NULL;";
        $query = mysqli_query($conn,$sqlcode3);
        if(mysqli_num_rows($query) > 0){
            echo "true";
        }else{
            echo "false";
        }
        break;
    case 'Package2':
        $sqlcode3 = "SELECT a.*,f.*
        FROM rooms a
        LEFT JOIN (
            SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate, e.finalCheckout, e.CheckOutDate
            FROM roomsreservation d
            LEFT JOIN reservations e ON d.greservationID = e.ReservationID
            WHERE (DATE(e.CheckInDate) <= '".$_POST['cin']."' AND e.CheckOutDate >= '".$_POST['cin']." $datas') AND e.finalCheckout is null
        ) f ON f.Room_num = a.RoomID WHERE f.RR_ID is null
        ORDER BY a.RoomID;";
        $query = mysqli_query($conn,$sqlcode3);
        if(mysqli_num_rows($query) > 0){
            echo "true";
        }else{
            echo "false";
        }
        break;
    case 'Package3':
        $sqlcode3 = "SELECT a.*,f.*
        FROM eventpav a 
        LEFT JOIN (
            SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate 
            FROM eventreservation d 
            LEFT JOIN reservations e ON d.reservationID = e.ReservationID 
            WHERE e.CheckInDate = '".$_POST['cin']."' AND (e.timapackage = '".$_POST['tday']."' OR e.timapackage = '22Hrs')
        ) f ON a.Pavtype = f.eventname 
        WHERE f.e_ID IS NULL;";
        $query = mysqli_query($conn,$sqlcode3);
        if(mysqli_num_rows($query) > 0){
            echo "true";
        }else{
            echo "false";
        }
        break;

}
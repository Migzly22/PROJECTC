<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];



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
        $sqlcode3 = "SELECT a.*, f.*, CONCAT(a.RoomType, '-', a.RoomNum) AS roomname FROM 
        (SELECT b.RoomID, b.RoomNum , c.* FROM rooms b LEFT JOIN roomtypes c ON b.RoomType = c.RoomType) a
        LEFT JOIN (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM roomsreservation d LEFT JOIN reservations e ON d.greservationID = e.ReservationID WHERE e.CheckInDate = '".$_POST['cin']."' AND (e.timapackage = '".$_POST['tday']."' OR e.timapackage = '22Hrs')) f ON a.RoomNum = f.Room_num WHERE f.RR_ID IS NULL;";
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
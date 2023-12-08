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
        $sqlcode3 = "SELECT b.* ,c.* ,a.* FROM cottage b LEFT JOIN cottagereservation c ON b.Cottagenum = c.cottagenum LEFT JOIN reservations a ON c.reservationID = a.ReservationID AND a.CheckInDate = '2023-12-06' AND a.timapackage = 'Day' WHERE c.cr_id IS NULL;";
        $query = mysqli_query($conn,$sqlcode3);
        if(mysqli_num_rows($query) > 0){
            echo "true";
        }else{
            echo "false";
        }
        # code...
        break;
    case 'Package3':
        $sqlcode3 = "SELECT b.* ,c.* ,a.* FROM cottage b LEFT JOIN cottagereservation c ON b.Cottagenum = c.cottagenum LEFT JOIN reservations a ON c.reservationID = a.ReservationID AND a.CheckInDate = '2023-12-06' AND a.timapackage = 'Day' WHERE c.cr_id IS NULL;";
        $query = mysqli_query($conn,$sqlcode3);
        if(mysqli_num_rows($query) > 0){
            echo "true";
        }else{
            echo "false";
        }
        # code...
        break;

}
<?php
header('Content-Type: text/html; charset=utf-8');

require("../../Database.php");
session_start();
ob_start();


$sqlcode = $_POST["sqlcode"];


function PRINTING($conn,  $sqlcode){
    $queryrun1 = mysqli_query($conn,$sqlcode);
    $data = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...
        $data .= "<div class='SO-item' onclick='this.querySelector(`label`).click()'>
            <input type='checkbox' id='".$result["ExtraID"]."' value='".$result['ItemName']."||".$result['remaining']."||".$result['Price']."' name='SOItemSelect'>
            <label for='".$result["ExtraID"]."'>".$result['ItemName']."</label>
        </div>";
    }
    if(mysqli_num_rows($queryrun1) <= 0){
        $data = "No Data";
    }
    echo $data;
}

$default = "SELECT a.*, (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) AS remaining FROM extracharges a LEFT JOIN (
    SELECT SUM(d.quantity) as USED, d.ChargeDescription, d.finalCheckout FROM (SELECT b.*, c.finalCheckout FROM guestextracharges b LEFT JOIN reservations c ON b.ReservationID = c.ReservationID WHERE c.finalCheckout IS NULL) d GROUP BY d.ChargeDescription
    ) e ON a.ItemName = e.ChargeDescription
    WHERE (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) > 0
    ORDER BY a.ItemName;";
switch ($_POST["Process"]) {
    case 'Search':
        $data = isset ($_POST["data"]) ? $_POST["data"]: "";
        $newString = str_replace("{item}", $data, $sqlcode);
        PRINTING($conn, $newString);
        break;
    case 'Reset':
        PRINTING($conn,$default);
        break;
}
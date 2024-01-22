<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT COUNT(a.RR_ID)  AS total,
c.timapackage,
ROUND(SUM(
CASE 
    WHEN c.timapackage = 'Night' THEN if(c.ReservationStatus = 'CHECKOUT', b.NightTimePrice, b.NightTimePrice /2 )
WHEN c.timapackage = 'Day' THEN if(c.ReservationStatus = 'CHECKOUT', b.DayTimePrice, b.DayTimePrice /2 )
WHEN c.timapackage = '22Hrs' THEN if(c.ReservationStatus = 'CHECKOUT', b.Hours22, b.Hours22 /2 )
END
),2)as Profit,


b.*  FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomID
LEFT JOIN reservations c ON a.greservationID = c.ReservationID
GROUP BY b.RoomType DESC  
ORDER BY COUNT(a.RR_ID) DESC";

function CHART($conn, $sqlcode3)
{
    $querynum3 = mysqli_query($conn, $sqlcode3);

    $arraychartdata = array();
    while ($result = mysqli_fetch_assoc($querynum3)) {
        $arraychartdata[$result["DateData"]] = $result["monthamount"];
    }
    $jsonString = json_encode($arraychartdata);
    echo $jsonString;
}
function PRINTING($conn, $sqlcode3)
{
    $queryrun1 = mysqli_query($conn, $sqlcode3);
    $data = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $data .= "
            <tr>
                <td>
                    <p>" . $result['DateData'] . "</p>
                </td>
                <td>₱ " . number_format($result['monthamount'], 2) . "</td>
            </tr>
        ";
    }
    if (mysqli_num_rows($queryrun1) <= 0) {
        $data = "
            <tr>
                <td>No Data</td>
                <td></td>

            </tr>
        ";
    }
    echo $data;
}
function PRINTING2($conn, $sqlcode4)
{

    $queryrun1 = mysqli_query($conn, $sqlcode4);
    $data = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $data .= "
            <tr>
                <td>
                    <p>".$result['RoomType']."</p>
                </td>
                <td>".$result['total']."</td>
                <td>".number_format($result['Profit'],2,'.',',')."</td>
            </tr>
        ";
    }
    if(mysqli_num_rows($queryrun1) <= 0 ){
        $data = "
            <tr>
                <td>No Data</td>
                <td></td>
                <td></td>
            </tr>
        ";
    }
    echo $data;
}
switch ($_POST["Process"]) {
    case 'Search':
        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn, $sqlcode3);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn, $sqlcode);
        PRINTING($conn, $sqlcode3);
        break;
    case 'AccessUpdate':
        mysqli_query($conn, $sqlcode);
        PRINTING($conn, $sqlcode3);
        break;
    case 'Insertmore':
        mysqli_query($conn, $sqlcode);
        break;
    case 'Chart':
        CHART($conn, $sqlcode);
        break;
    case 'ChartSpecific':
        $querynum3 = mysqli_query($conn, $sqlcode);
        $result = mysqli_fetch_assoc($querynum3)["Amount"];
        echo $result;
        break;
    case 'Search2':
        PRINTING2($conn, $sqlcode);
        break;
    case 'Reset2':
        PRINTING2($conn, $sqlcode3);
        break;
    default:
        # code...
        break;
}

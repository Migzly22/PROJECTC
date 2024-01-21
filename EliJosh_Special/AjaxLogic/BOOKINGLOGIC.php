<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$default = "SELECT  a.*, (a.NumAdults + a.NumChildren + a.NumSeniors + a.NumExcessPax) AS noguest,
CASE
  WHEN a.package = 'Package1' THEN 'Swimming'
  WHEN a.package = 'Package2'THEN 'Rooms + Swimming'
  ELSE 'Pavilion'
END AS packagesname,
b.* FROM reservations a LEFT JOIN guestpayments b ON a.ReservationID = b.ReservationID WHERE a.UserID = '" . $_SESSION["USERID"] . "' AND b.Description is NOT NULL ORDER BY a.ReservationID DESC;";


function PRINTING($conn, $sqlcode3)
{

    $queryrun1 = mysqli_query($conn, $sqlcode3);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $statuscolor = ($result['ReservationStatus'] == "BOOKED" ? "process" : ($result['ReservationStatus'] == "CANCELLED" ? "pending" : "completed"));

        if ($result['ReservationStatus'] != "CANCELLED" && $result['ReservationStatus'] != "CHECKOUT") {
            $onclicvalue = "showChangeStatus(`" . $result['ReservationID'] . "`,`" . $result['ReservationStatus'] . "`)";
        } else {
            $onclicvalue = "";
        }

        $data1 .= "
        <tr>
            <td style='display:flex;flex-direction:column;align-items:start;'>
                <p>" . $result['eCheckin'] . "</p>
            </td>
            <td>
            " . $result['timapackage'] . " " . $result['packagesname'] . "
            </td>
            <td>
                ₱ " . number_format($result['Downpayment'], 2) . "
            </td>
            <td>" . $result['Description'] . "</td>
            <td><a href='#' onclick='$onclicvalue'><span class='status $statuscolor'>" . $result['ReservationStatus'] . "</span></a></td>
            <td class='TableBtns'>
									<a class='EditBTN' href='../Admins/Composer/paypal2.php?id=" . $result['ReservationID'] . "'  rel='noopener noreferrer'>
										<i class='bx bx-printer' ></i>
									</a>
								</td>
        </tr>";
    }

    if (mysqli_num_rows($queryrun1) <= 0) {
        $data1 .= "
        <tr>
            <td>No Data</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>";
    }
    echo $data1;
}



switch ($_POST["Process"]) {
    case 'Search':
        $sqlcode = str_replace("a.UserID = '" . $_SESSION["USERID"] . "' AND b.Description is NOT NULL", "a.UserID = '" . $_SESSION["USERID"] . "' AND b.Description is NOT NULL AND $sqlcode", $default);

        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn, $default);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn, $sqlcode);
        PRINTING($conn, $default);
        break;
    case 'AccessUpdate':
        mysqli_query($conn, $sqlcode);
        PRINTING($conn, $default);
        break;
    case 'CheckingOUT':
        mysqli_query($conn, $sqlcode);
        PRINTING($conn, $default);
        break;
    case 'insertion':
        mysqli_query($conn, $sqlcode);
        # code...
        break;
}

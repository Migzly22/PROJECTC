<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

$sqlcode3 = "SELECT a.*, CONCAT(c.LastName, ', ', c.FirstName) AS Name FROM guestpayments a LEFT JOIN reservations b ON a.ReservationID = b.ReservationID LEFT JOIN guests c ON b.GuestID = c.GuestID ORDER BY a.PaymentDate DESC;";
$sqlcode4 = "SELECT a.*, COALESCE(c.USEDQUANTITY, 0) AS USEDQUANTITY , COALESCE(c.TOTALAMOUNT, 0) AS TOTALAMOUNT FROM extracharges a LEFT JOIN (SELECT b.*, SUM(b.quantity) AS USEDQUANTITY, SUM(b.ChargeAmount) AS TOTALAMOUNT FROM guestextracharges b GROUP BY b.ChargeDescription) c ON a.ItemName = c.ChargeDescription ORDER BY c.TOTALAMOUNT DESC, c.USEDQUANTITY DESC;";

function CHART($conn, $sqlcode3){
    $querynum3 = mysqli_query($conn,$sqlcode3);

    $arraychartdata = array();
    while ($result = mysqli_fetch_assoc($querynum3)) {
        $arraychartdata[$result["month"]] = $result["monthamount"];
    }
    $jsonString = json_encode($arraychartdata);
    echo $jsonString;
}
function PRINTING($conn, $sqlcode3){
 
    $queryrun1 = mysqli_query($conn,$sqlcode3);
    $data = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $data .= "
            <tr>
                <td>
                    <p>".$result['Name']."</p>
                </td>
                <td>".$result['PaymentDate']."</td>
                <td>".$result['PaymentMethod']."</td>
                <td>₱ ".number_format($result['AmountPaid'],2)."</td>
            </tr>
        ";
    }
    if(mysqli_num_rows($queryrun1) <= 0 ){
        $data = "
            <tr>
                <td>No Data</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ";
    }
    echo $data;
}
function PRINTING2($conn, $sqlcode4){
 
    $queryrun1 = mysqli_query($conn,$sqlcode4);
    $data = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							$data .= "
								<tr>
									<td>
										<p>".$result['ItemName']."</p>
									</td>
									<td>".$result['USEDQUANTITY']."</td>
									<td>₱ ".number_format($result['TOTALAMOUNT'],2)."</td>
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
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $sqlcode3);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn, $sqlcode3);
        break;        
    case 'Insertmore':   
        mysqli_query($conn,$sqlcode);
        break;    
    case 'Chart':
        CHART($conn, $sqlcode);
        break;
    case 'ChartSpecific':
        $querynum3 = mysqli_query($conn,$sqlcode);
        $result = mysqli_fetch_assoc($querynum3)["Amount"];
        echo $result;
        break;
    case 'Search2':
        PRINTING2($conn, $sqlcode);
        break;
    case 'Reset2':
        PRINTING2($conn, $sqlcode4);
        break;
    default:
        # code...
        break;
}
<?php
require 'vendor/autoload.php';
require("../Database.php");
session_start();
ob_start();

use Dompdf\Dompdf;
use Dompdf\Options;



$options = new Options;
$options->setChroot(__DIR__); //file directory
$options->setIsRemoteEnabled(true);


$dompdf = new Dompdf($options);
$dompdf->setPaper("A4", "portrait"); // change the paper properties to A4 and landscape




$sqlcode = $_GET["sqlcode"];

$msgarray = array();
$monthsArray = [];

for ($i = 1; $i <= 12; $i++) {
    $monthsArray[$i] = date('F', mktime(0, 0, 0, $i, 1));
}

if (strpos($sqlcode, "a.PaymentDate") !== false) {
    if (strpos($sqlcode, "<=") !== false || strpos($sqlcode, ">=") !== false) {

        if (strpos($sqlcode, ">=") !== false) {
            $nn1 = explode(">= '", $sqlcode)[1];
            $newcode = explode("'", $nn1)[0];
            $msgarray[] = "from $newcode";
        }
        if (strpos($sqlcode, "<=") !== false) {
            $nn1 = explode("<= '", $sqlcode)[1];
            $newcode = explode("'", $nn1)[0];
            $msgarray[] = "to $newcode";
        }
        $STRINGMSG = implode(" ", $msgarray);
    } else {
        if (strpos($sqlcode, "MONTH(") !== false) {
            $nn1 = explode("MONTH(a.PaymentDate) = '", $sqlcode)[1];
            $newcode = explode("'", $nn1)[0];
            $msgarray[] = "the month of " . $monthsArray[$newcode];
        }
        if (strpos($sqlcode, "YEAR(") !== false) {
            $nn1 = explode("YEAR(a.PaymentDate) = '", $sqlcode)[1];
            $newcode = explode("'", $nn1)[0];
            $msgarray[] = "year $newcode";
        }
        $STRINGMSG = implode(" and ", $msgarray);
    }
} else {
    $STRINGMSG = "the beginning of the Sales";
}



$sql = "SELECT a.*, if(a.Description = 'Downpayment', 'WALKIN', a.Description) AS DESCK, CONCAT(c.LastName, ', ', c.FirstName) AS NAME, b.timapackage, b.eCheckin, b.CheckOutDate , (b.NumAdults+b.NumChildren+b.NumSeniors+b.NumExcessPax) AS NUMGUEST 
    FROM guestpayments a LEFT JOIN reservations b ON a.ReservationID = b.ReservationID LEFT JOIN guests c ON b.GuestID = c.GuestID
    where $sqlcode
    ORDER BY  CASE WHEN a.Description = 'CHECKOUT' THEN 1 ELSE 0 END, a.PaymentDate DESC ;";

$result = mysqli_query($conn, $sql);

$tablerowdata = "";
$COTTAGE = array();
$ROOM = array();
$PAVILION = array();
$ITEMS = array();

while ($row = mysqli_fetch_assoc($result)) {
    $daterow = $row['PaymentDate'];
    $PaymentMethod = $row['NAME'];
    $description = $row['DESCK'];
    $AmountPaid = number_format($row['AmountPaid'], 2, ".", ",");

    $ReservationID = $row['ReservationID'];
    $date1 = new DateTime($row["eCheckin"]);
    $date2 = new DateTime($row["CheckOutDate"]);

    $interval = $date1->diff($date2);

    $total_hours = $interval->h + ($interval->days * 24);

    // Round up to the nearest multiple of 24 hours
    $rounded_hours = ceil($total_hours / 24);


    if ($description == "CHECKOUT") {
        $sqlITEM = "SELECT COALESCE( SUM(a.ChargeAmount), 0) AS TOTAL FROM guestextracharges a WHERE a.ReservationID = '$ReservationID';";
        $sqlITEMquery = mysqli_query($conn, $sqlITEM);
        $ITEMRESULT = mysqli_fetch_assoc($sqlITEMquery);
        $ITEMS[$ReservationID] = $ITEMRESULT['TOTAL'];
    }

    if ($row["timapackage"] == "22Hrs") {
        $datatype = "NightPrice";
    } else {
        $datatype = $row["timapackage"] . "Price";
    }

    $sqlcottage = "SELECT a.*, SUM(c.$datatype) AS TOTAL FROM cottagereservation a LEFT JOIN cottage b ON a.cottagenum = b.Cottagenum LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName WHERE a.reservationID = '$ReservationID';";
    $cottagequery = mysqli_query($conn, $sqlcottage);
    $cottageresult = mysqli_fetch_assoc($cottagequery);
    $COTTAGE[$ReservationID] = ($description == "CHECKOUT") ? floatval($cottageresult["TOTAL"]) : floatval($cottageresult["TOTAL"]) / 2;


    if ($row["timapackage"] == "22Hrs" || $rounded_hours > 1) {
        $datatype2 = "Hours22";
    } else {
        $datatype2 = $row["timapackage"] . "TimePrice";
    }

    $sqlroom = "SELECT a.*, SUM(b.$datatype2) AS TOTAL FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomID WHERE a.greservationID = '$ReservationID';";

    $roomquery = mysqli_query($conn, $sqlroom);
    $roomresult = mysqli_fetch_assoc($roomquery);
    $ROOM[$ReservationID] = ($description == "CHECKOUT") ? floatval($roomresult["TOTAL"]) * $rounded_hours : (floatval($roomresult["TOTAL"]) * $rounded_hours) / 2;


    $EVENTLIST = "SELECT a.*, b.* FROM eventreservation a LEFT JOIN eventpav b ON a.eventname = b.Pavtype WHERE a.reservationID = '$ReservationID';";

    $EVENTLISTQuery =  mysqli_query($conn, $EVENTLIST);
    if (mysqli_num_rows($EVENTLISTQuery) > 0) {
        $event2 = array();
        while ($EVENTResult = mysqli_fetch_assoc($EVENTLISTQuery)) {

            $guesttotalnumber = $row["NUMGUEST"];
            $newsql22 = "SELECT `" . $EVENTResult["Pavtype"] . "` FROM eventplace WHERE PAX >= '$guesttotalnumber' ORDER BY PAX ASC LIMIT 1;";
            $EVENTLISTQuery1 =  mysqli_query($conn, $newsql22);
            $EVENTresult = mysqli_fetch_assoc($EVENTLISTQuery1);
            $event2[$EVENTResult["eventname"]] = $EVENTresult[$EVENTResult["Pavtype"]];
        }

        if (!empty($event2)) {
            $PAVILION[$ReservationID] =  ($description == "CHECKOUT") ? array_sum($event2) : array_sum($event2) / 2;
        }
    }
    $tablerowdata .= "
        <tr>
          <td>$daterow</td>
          <td>$PaymentMethod</td>
          <td>$description</td>
          <td>$AmountPaid</td>
        </tr>
        ";
}








$jinks = $_SESSION['jinks'];

$salesreport = "";
$queryrun1 = mysqli_query($conn,$jinks);
while ($resultnewer = mysqli_fetch_assoc($queryrun1)) {
    $salesreport .= "
            <tr>
                <td>" . $resultnewer['DateData'] . "
                </td>
                <td>" . number_format($resultnewer['monthamount'], 2) . "</td>
            </tr>
        ";
}
if (mysqli_num_rows($queryrun1) <= 0) {
    $salesreport = "
            <tr>
                <td>No Data</td>
                <td></td>

            </tr>
        ";
}








$base64Image1 = $_SESSION['imgs'];
// Remove the data:image/png;base64 prefix
$base64Image = str_replace('data:image/png;base64,', '', $base64Image1);
// Decode the base64-encoded image
$imageData = base64_decode($base64Image);

// Specify the file path to save the image
$filePath = './base64_image.png';

// Save the image to the file
if (file_put_contents($filePath, $imageData) === false) {
    die("Error saving the image.");
}


$type = pathinfo($filePath, PATHINFO_EXTENSION);
$data = file_get_contents($filePath);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$currentDate = new DateTime();
$currentDate->setTimezone(new DateTimeZone('Asia/Taipei'));
$date1 = $currentDate->format('Y-m-d');


$html = file_get_contents("./REPORTITSELF.html");
$needtochange = [
    "{{DATE}}",
    "{{IMG}}",
    "{{DATAMENT}}",
    "{{REPORT1}}",
    "{{REPORT2}}"
];
$valuetochange = [
    $date1,
    $base64Image1,
    $STRINGMSG,
    $salesreport,
    $tablerowdata,

];

$html = str_replace($needtochange, $valuetochange, $html);


$dompdf->loadHtml($html); // load the value that you pass in it
//$dompdf -> load_html_file('htmltemplate.html'); // use to load another html file
$dompdf->render();

$dompdf->addInfo("Title", 'Report'); // Add additional info in the pdf
$dompdf->stream("SalesReport.pdf", ["Attachment" => 0]); //the text here represent the name of the pdf file
        // Attachment -> 0 means view of the pdf
        // while Attachment -> 1 means download the pdf but differ on the configuration of the borwser


        
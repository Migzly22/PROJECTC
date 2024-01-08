<?php
require '../../Database.php';
require 'vendor/autoload.php';
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;

// Load the template DOCX file
$templateFile = 'ReservationDocxv2.docx';


$reserveid = $_GET["id"];

$SQLCODE = "SELECT a.*, c.* FROM reservations a LEFT JOIN guests c ON a.GuestID = c.GuestID WHERE a.ReservationID = '$reserveid ' ORDER BY a.ReservationID DESC;";
$sqlquery = mysqli_query($conn,$SQLCODE);
$arraynew = mysqli_fetch_assoc($sqlquery);



$SQLCODE2 = "SELECT a.*, CONCAT(b.CottageType, '-', b.Cottagenum) as NAME, c.* FROM cottagereservation a LEFT JOIN cottage b ON a.cottagenum = b.Cottagenum LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName WHERE a.reservationID = '$reserveid';";
$sqlquery2 = mysqli_query($conn,$SQLCODE2);



$COTTAGECON = null;
$ROOMCON = null;
$PAVCON = null;

if(mysqli_num_rows($sqlquery2)){
    $COTTAGECON = array();
    $Carrvalues = array();

    while ($result = mysqli_fetch_assoc($sqlquery2)) {
        if($arraynew['timapackage'] == "22Hrs"){
            $pricename = "NightPrice";
        }else{
            $pricename = $arraynew['timapackage']."Price";
        }
        
        $Carrvalues[$result["NAME"]] = $result[$pricename];
    }
    $COTTAGECON = $Carrvalues;
}


$date1 = new DateTime($arraynew["eCheckin"]);
$date2 = new DateTime($arraynew["CheckOutDate"]);

$interval = $date1->diff($date2);

$total_hours = $interval->h + ($interval->days * 24);

// Round up to the nearest multiple of 24 hours
$rounded_hours = ceil($total_hours / 24) ;

$SQLCODE3 = "SELECT a.*, CONCAT(b.RoomType, '-', b.RoomNum) as NAME, c.* FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomNum LEFT JOIN roomtypes c ON b.RoomType = c.RoomType WHERE a.greservationID  = '$reserveid';";
$sqlquery3 = mysqli_query($conn,$SQLCODE3);
if(mysqli_num_rows($sqlquery3)){
    $ROOMCON = array();
    $Carrvalues = array();
    while ($result = mysqli_fetch_assoc($sqlquery3)) {
        # code...

        if($arraynew['timapackage'] == "22Hrs" || $rounded_hours  > 1){
            $pricename = "Hours22";
        }else{
            $pricename = $arraynew['timapackage']."TimePrice";
        }

        $Carrvalues[$result["NAME"]] = $result[$pricename];

    }
    $ROOMCON = $Carrvalues;
}
$SQLCODE4 = "SELECT a.* FROM eventreservation a WHERE a.reservationID = '$reserveid';";
$sqlquery4 = mysqli_query($conn,$SQLCODE4);
if(mysqli_num_rows($sqlquery3)){
    $PAVCON = array();
    $Carrvalues = array();
    while ($result = mysqli_fetch_assoc($sqlquery3)) {
        # code...


        $sqlcode4v1 = "SELECT `".$result['eventname']."` AS PRICE FROM eventplace b WHERE b.PAX >= '50' ORDER BY b.PAX ASC; LIMIT 1";
        $sqlquery4v1 = mysqli_query($conn,$sqlcode4v1);
        $result2 = mysqli_fetch_assoc($sqlquery4v1);


        $Carrvalues[$result["eventname"]] = $result2["PRICE"];

    }
    $PAVCON = $Carrvalues;
}   


$arraynew["COTTAGE"] = $COTTAGECON;
$arraynew["ROOM"] = $ROOMCON;
$arraynew["EVENT"] = $PAVCON;


$checkouttime = $arraynew["eCheckin"];


$cottages = '';
$sumOfCOTTAGES = 0;
$sumOfROOM = 0;
$sumOfEVENT = 0;
$rooms = '';
$evnt = '';


if(isset($arraynew['COTTAGE'])){
    $cottages = implode(', ',array_keys($arraynew['COTTAGE']));
    foreach ($arraynew['COTTAGE'] as $item) {
        $sumOfCOTTAGES += intval($item);
    }
}


if(isset($arraynew['ROOM'])){
    $rooms = implode(', ',array_keys($arraynew['ROOM']));
    foreach ($arraynew['ROOM'] as $item) {
        $sumOfROOM +=intval($item)*intval($rounded_hours);
    }
}


$dateTime = new DateTime($arraynew['CheckInDate']);
// Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
$dayOfWeekNumber = $dateTime->format('N');
// Convert the number to the day name
$dayOfWeekName = date('l', strtotime($arraynew['CheckInDate']));

if($dayOfWeekNumber <= 4){
    $columnstring = "Weekdays".$arraynew['timapackage']."Price";
}else{
    $columnstring = "WeekendsHolidays".$arraynew['timapackage']."Price";
}


$sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
$sql1query = mysqli_query($conn, $sql1);
$entrance = array();

while ($result = mysqli_fetch_assoc($sql1query)) {
  $entrance[] = $result[$columnstring];
}

$arraynew["ADULTPAY"] =  $entrance[0];
$arraynew["KIDPAY"]=  $entrance[1];
$arraynew["SENIORPAY"]= intval($arraynew["ADULTPAY"]) - (intval($arraynew["ADULTPAY"]) * 0.2);



if(isset($arraynew['EVENT'])){
    $evnt = implode(', ',array_keys($arraynew['EVENT']));
    foreach ($arraynew['EVENT'] as $item) {
        $sumOfEVENT += intval($item);
    }
}

if($arraynew["package"] == "Package2"){
    $TPA = "0.00";
    $TPK = "0.00";
    $TPS = "0.00";
}else{
    $TPA = number_format(($arraynew["NumAdults"]*$arraynew["ADULTPAY"]), 2, '.', ',');
    $TPK = number_format(($arraynew["NumChildren"]*$arraynew["KIDPAY"]), 2, '.', ',');
    $TPS = number_format(($arraynew["NumSeniors"]*$arraynew["SENIORPAY"]), 2, '.', ',') ;
}



if (file_exists($templateFile)) {
  
    $document = new TemplateProcessor($templateFile);
    
    // Replace placeholders with values
    $document->setValue('{{NAME}}', $arraynew["LastName"].", ".$arraynew["FirstName"]);
    $document->setValue('{{ADDR}}', $arraynew["Address"]." ".$arraynew["City"]);
    $document->setValue('{{NUMCONTENT}}', $arraynew["Phone"]);
    $document->setValue('{{EMAILCONTENT}}',$arraynew["Email"]);
    $document->setValue('{{CHECKIN}}', $arraynew["eCheckin"]);
    $document->setValue('{{CHECKOUT}}', $arraynew["CheckOutDate"]);

    $document->setValue('{{ROOM}}', $rooms);
    $document->setValue('{{PAVIL}}', $evnt);
    $document->setValue('{{COTTAGE}}', $cottages);

    $document->setValue('{{TPROM}}', number_format($sumOfROOM, 2, '.', ','));
    $document->setValue('{{TPPAV}}', number_format($sumOfEVENT, 2, '.', ','));
    $document->setValue('{{TPCOT}}', number_format($sumOfCOTTAGES, 2, '.', ','));

    $document->setValue('{{TPA}}', $TPA);
    $document->setValue('{{TPK}}', $TPK);
    $document->setValue('{{TPS}}', $TPS);

    $document->setValue('{{ADULT}}', $arraynew["NumAdults"]);
    $document->setValue('{{KIDS}}', $arraynew["NumChildren"]);
    $document->setValue('{{SENIOR}}', $arraynew["NumSeniors"]);
    $document->setValue('{{TOTAL}}', number_format($arraynew["TotalPrice"], 2, '.', ','));
    $document->setValue('{{DPAYMENT}}',number_format($arraynew["Downpayment"], 2, '.', ','));
    
    // Save the modified document
    $outputFile = 'export.docx';
    $document->saveAs($outputFile);
    

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="Elijosh_Docu.docx"');
    header('Content-Length: ' . filesize($outputFile));
    header('Connection: close');
    
    // Output the file content
    readfile($outputFile);


     // Clean output buffer
    ob_end_flush();

    /// Set a session flash message
    $_SESSION['redirect_message'] = 'Redirect after download';
    
    exit();
}





//header("Location: ../Admins/Mainpage.php?nzlz=booking&plk=2");
//ob_end_flush();
//exit; 
<?php
require '../Database.php';
require 'vendor/autoload.php';
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;


$id = $_SESSION["USERID"];
$reserveid = $_GET["id"];

$SQLCODE = "SELECT  a.*, c.* FROM reservations a LEFT JOIN userscredentials c ON a.UserID = c.userID WHERE a.UserID = '$id' AND a.ReservationID = '$reserveid' ORDER BY a.ReservationID DESC;";
$sqlquery = mysqli_query($conn,$SQLCODE);

$arraynew = mysqli_fetch_assoc($sqlquery);


$SQLCODE2 = "SELECT b.RoomType FROM reservations a LEFT JOIN roomsreservation c ON a.ReservationID = c.greservationID LEFT JOIN rooms b ON c.Room_num = b.RoomNum  WHERE a.ReservationID = '$reserveid' ORDER BY a.ReservationID DESC;";
$sqlquery2 = mysqli_query($conn,$SQLCODE2);

$arrrooms = array();

while ($result = mysqli_fetch_assoc($sqlquery2)) {
    array_push($arrrooms, $result["RoomType"]);
}

$resultty = implode(",", $arrrooms);
$arraynew["ROOMSST"] = $resultty;

// Load the template DOCX file
$templateFile = 'ReservationDocx.docx';




if (file_exists($templateFile)) {
  
    $document = new TemplateProcessor($templateFile);
    
    // Replace placeholders with values
    $document->setValue('{{NAME}}', $arraynew["LastName"].", ".$arraynew["FirstName"]." ".$arraynew["MiddleName"]);
    $document->setValue('{{ADDR}}', $arraynew["City"]);
    $document->setValue('{{NUMCONTENT}}', $arraynew["PhoneNumber"]);
    $document->setValue('{{EMAILCONTENT}}', $arraynew["Email"]);
    $document->setValue('{{CHECKIN}}', $arraynew["CheckInDate"]);
    $document->setValue('{{CHECKOUT}}', $arraynew["CheckOutDate"]);
    $document->setValue('{{ROOM}}', $arraynew["ROOMSST"]);
    $document->setValue('{{COTTAGE}}', $arraynew["CottageTypeID"]);
    $document->setValue('{{ADULT}}', $arraynew["NumAdults"]);
    $document->setValue('{{KIDS}}', $arraynew["NumChildren"]);
    $document->setValue('{{SENIOR}}', $arraynew["NumSeniors"]);
    $document->setValue('{{TOTAL}}', $arraynew["TotalPrice"]);
    $document->setValue('{{DPAYMENT}}', $arraynew["Downpayment"]);
    
    // Save the modified document
    $outputFile = 'export.docx';
    $document->saveAs($outputFile);
    
    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="My_Reservation.docx"');
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
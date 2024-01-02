<?php

require 'vendor/autoload.php';
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;

// Load the template DOCX file
$templateFile = 'ReservationDocxv2.docx';
$arraynew = json_decode( $_SESSION["Newcustomerappointment"], true);

$time =  explode(" - ",$arraynew["time"])[1];
$checkouttime = $arraynew["checkin"]." ".$time;


$cottages = '';
$sumOfCOTTAGES = 0;
$sumOfROOM = 0;
$sumOfEVENT = 0;
$rooms = '';
$evnt = '';

if(isset($arraynew['COTTAGE'])){
    $cottages = implode(', ',array_keys($arraynew['COTTAGE']));

    foreach ($arraynew['COTTAGE'] as $item) {
        $sumOfCOTTAGES += $item['price'];
    }
}
if(isset($arraynew['ROOM'])){
    $rooms = implode(', ',array_keys($arraynew['ROOM']));
    foreach ($arraynew['ROOM'] as $item) {
        $sumOfROOM += $item['price'];
    }
}
if(isset($arraynew['EVENT'])){
    $evnt = implode(', ',array_keys($arraynew['EVENT']));
    foreach ($arraynew['EVENT'] as $item) {
        $sumOfEVENT += $item['price'];
    }
}

if($arraynew["package"] == "Package2"){
    $TPA = "0.00";
    $TPK = "0.00";
    $TPS = "0.00";
}else{
    $TPA = $arraynew["No. of Adult"]*$arraynew["ADULTPAY"];
    $TPK = $arraynew["No. of Kid"]*$arraynew["KIDPAY"];
    $TPS = $arraynew["No. of Seniors"]*$arraynew["SENIORPAY"];
}



if (file_exists($templateFile)) {
  
    $document = new TemplateProcessor($templateFile);
    
    // Replace placeholders with values
    $document->setValue('{{NAME}}', $arraynew["USERINFO"]["LastName"].", ".$arraynew["USERINFO"]["FirstName"]);
    $document->setValue('{{ADDR}}', $arraynew["USERINFO"]["Address"]." ".$arraynew["USERINFO"]["City"]);
    $document->setValue('{{NUMCONTENT}}', $arraynew["USERINFO"]["PhoneNumber"]);
    $document->setValue('{{EMAILCONTENT}}',$arraynew["USERINFO"]["Email"]);
    $document->setValue('{{CHECKIN}}', $arraynew["checkin"]." ".$arraynew["ETIME"]);
    $document->setValue('{{CHECKOUT}}', $arraynew["checkout"]);

    $document->setValue('{{ROOM}}', $rooms);
    $document->setValue('{{PAVIL}}', $evnt);
    $document->setValue('{{COTTAGE}}', $cottages);

    $document->setValue('{{TPROM}}', number_format($sumOfROOM, 2, '.', ','));
    $document->setValue('{{TPPAV}}', number_format($sumOfEVENT, 2, '.', ',') );
    $document->setValue('{{TPCOT}}', number_format($sumOfCOTTAGES, 2, '.', ',') );

    $document->setValue('{{TPA}}', number_format($TPA, 2, '.', ',') );
    $document->setValue('{{TPK}}', number_format($TPK, 2, '.', ',') );
    $document->setValue('{{TPS}}', number_format($TPS, 2, '.', ',') );

    $document->setValue('{{ADULT}}', $arraynew["No. of Adult"]);
    $document->setValue('{{KIDS}}', $arraynew["No. of Kid"]);
    $document->setValue('{{SENIOR}}', $arraynew["No. of Seniors"]);
    $document->setValue('{{TOTAL}}', number_format($arraynew["TOTAL"], 2, '.', ',') );
    $document->setValue('{{DPAYMENT}}', number_format($arraynew["DPAYMENT"], 2, '.', ','));
    
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
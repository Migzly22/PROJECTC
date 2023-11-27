<?php

require 'vendor/autoload.php';
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;

// Load the template DOCX file
$templateFile = 'ReservationDocx.docx';
$arraynew = json_decode( $_SESSION["Newcustomerappointment"], true);

if (file_exists($templateFile)) {
  
    $document = new TemplateProcessor($templateFile);
    
    // Replace placeholders with values
    $document->setValue('{{NAME}}', $arraynew["lastName"].", ".$arraynew["firstName"]." ".$arraynew["middleName"]);
    $document->setValue('{{ADDR}}', $arraynew["address"]);
    $document->setValue('{{NUMCONTENT}}', $arraynew["phoneNumber"]);
    $document->setValue('{{EMAILCONTENT}}', $arraynew["email"]);
    $document->setValue('{{CHECKIN}}', $arraynew["Checkin"]);
    $document->setValue('{{CHECKOUT}}', $arraynew["Checkout"]);
    $document->setValue('{{ROOM}}', $arraynew["ROOM"]);
    $document->setValue('{{COTTAGE}}', $arraynew["Cottage"]);
    $document->setValue('{{ADULT}}', $arraynew["No. of Adult"]);
    $document->setValue('{{KIDS}}', $arraynew["No. of Kid"]);
    $document->setValue('{{SENIOR}}', $arraynew["No. of Seniors"]);
    $document->setValue('{{TOTAL}}', $arraynew["TOTAL"]);
    $document->setValue('{{DPAYMENT}}', $arraynew["DPAYMENT"]);
    
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
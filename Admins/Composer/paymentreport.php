<?php
require 'vendor/autoload.php';
require("../Database.php");
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;


// Fetch data from MySQL
$selectedColumns = ['PaymentDate', 'PaymentMethod', 'AmountPaid'];
$sqlcode = $_GET["sqlcode"];
$sql = str_replace(":*:", implode(', ', $selectedColumns), $sqlcode);
$result = mysqli_query($conn, $sql);

// Load the template DOCX file
$templateFile = 'Payment.docx';
$document = new TemplateProcessor($templateFile);

// Replace placeholders or add other content as needed
// Set the timezone to UTC+8
date_default_timezone_set('Asia/Taipei');

// Get the current date in UTC+8
$currentDate = new DateTime();
$currentDate->setTimezone(new DateTimeZone('Asia/Taipei'));

// Format the DateTime object to display the date only
$formattedDate = $currentDate->format('Y-m-d');

$document->setValue('{{DATETODAY}}', $formattedDate);
$document->setValue('{{DATATODAY}}', createTable($result));

// Save the modified document
$outputFile = 'export.docx';
$document->saveAs($outputFile);

// Set headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="Elijosh_Report.docx"');
header('Content-Length: ' . filesize($outputFile));
header('Connection: close');

// Output the file content
readfile($outputFile);

function createTable($result) {
    // Create a table with 4 columns, each having borders and bold text
    $tablerowdata = "";
    while ( $row = mysqli_fetch_assoc($result)) {
        $daterow = $row['PaymentDate'];
        $PaymentMethod = $row['PaymentMethod'];
        $AmountPaid = $row['AmountPaid'];
        $tablerowdata .= '
        <w:tr>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>'.$daterow.'</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>'.$PaymentMethod.'</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>'.$AmountPaid.'</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                </w:tr>';
    }


    $table = '<w:tbl>
                <w:tblPr>
                    <w:tblW w:w="100%" w:type="pct"/>
                    <w:tblBorders>
                        <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                        <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                        <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                        <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                    </w:tblBorders>
                </w:tblPr>
                <w:tr>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>Date</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>Payment Method</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                    <w:tc>
                        <w:tcPr>
                            <w:tclW w:w="100%" w:type="pct"/>
                            <w:tcBorders>
                                <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                            </w:tcBorders>
                        </w:tcPr>
                        <w:p>
                            <w:r>
                                <w:t>Amount Paid</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                </w:tr>
                '.$tablerowdata.'
            </w:tbl>';

    return $table;
}
?>

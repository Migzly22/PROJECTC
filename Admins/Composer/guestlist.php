<?php
require 'vendor/autoload.php';
require("../Database.php");
session_start();
ob_start();
date_default_timezone_set('Asia/Tokyo');
use PhpOffice\PhpWord\TemplateProcessor;


// Fetch data from MySQL
$sqlcode = "SELECT a.*, CONCAT(a.FirstName, ' ', a.LastName) AS NAME, b.eCheckin FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID WHERE :{^^}:;";
$sql2 = str_replace(":{^^}:", $_GET["sqlcode"], $sqlcode);


if(strpos($sql2, "b.eCheckin") !== false ||strpos($sql2, "b.CheckOutDate") !== false ){
    if(strpos($sql2, "<=") !== false || strpos($sql2, ">=") !== false){

        if(strpos($sql2, ">=") !== false){
            $nn1 = explode(">= '",$sql2)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "from $newcode";
        }
        if(strpos($sql2, "<=") !== false){
            $nn1 = explode("<= '",$sql2)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "to $newcode";

        }
       
    }
    if(strpos($sql2, "CURRENT_DATE") !== false){
        $newcode = date("Y-m-d");
        $msgarray[] = "from $newcode";
    }
    $STRINGMSG = implode(" ", $msgarray);
}

$result = mysqli_query($conn, $sql2);
// Load the template DOCX file
$templateFile = 'GuestList.docx';
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
$document->setValue('{{DATAMENT}}', $STRINGMSG);

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
        $NAME = $row['NAME'];
        $CHECKIN = $row['eCheckin'];
        $EMAIL = $row['Email'];
        $PHONE = $row['Phone'];

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
                                <w:t>'.$NAME.'</w:t>
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
                                <w:t>'.$EMAIL.'</w:t>
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
                                <w:t>'.$PHONE.'</w:t>
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
                                <w:t>'.$CHECKIN.'</w:t>
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
                                <w:t>Name</w:t>
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
                                <w:t>Email</w:t>
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
                                <w:t>Contact #</w:t>
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
                                <w:t>Check-in</w:t>
                            </w:r>
                        </w:p>
                    </w:tc>
                </w:tr>
                '.$tablerowdata.'
            </w:tbl>';

    return $table;
}
?>

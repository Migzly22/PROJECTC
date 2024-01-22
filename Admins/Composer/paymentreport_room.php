<?php
require 'vendor/autoload.php';
require("../Database.php");
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;


// Fetch data from MySQL
$selectedColumns = ['b.ChargeDescription', 'SUM(b.quantity) AS USEDQUANTITY', 'SUM(b.ChargeAmount) AS TOTALAMOUNT'];
$sqlcode = "SELECT COUNT(a.RR_ID)  AS total,
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
WHERE :{^^}:
GROUP BY b.RoomType DESC  
ORDER BY COUNT(a.RR_ID) DESC";
$sql2 = str_replace(":{^^}:", $_GET["sqlcode"], $sqlcode);


$msgarray = array();
$monthsArray = [];

for ($i = 1; $i <= 12; $i++) {
    $monthsArray[$i] = date('F', mktime(0, 0, 0, $i, 1));
}

if(strpos($sql2, "c.CheckInDate") !== false){
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
        $STRINGMSG = implode(" ", $msgarray);
    }else{
        if(strpos($sql2, "MONTH(") !== false){
            $nn1 = explode("MONTH(c.CheckInDate) = '",$sql2)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "the month of ".$monthsArray[$newcode];
        }
        if (strpos($sql2, "YEAR(") !== false){
            $nn1 = explode("YEAR(c.CheckInDate) = '",$sql2)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "year $newcode";
        }
        $STRINGMSG = implode(" and ", $msgarray);
    }

    
}else{
    $STRINGMSG = "the beginning of the Sales";
}

$sql = $sql2;//str_replace(":*:", implode(', ', $selectedColumns), $sql2);



$print = true;

$result = mysqli_query($conn, $sql);
// Load the template DOCX file
$templateFile = 'Payment3.docx';
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

if($print){
// Set headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="Elijosh_Report.docx"');
header('Content-Length: ' . filesize($outputFile));
header('Connection: close');

// Output the file content
readfile($outputFile);
}

function createTable($result) {
    // Create a table with 4 columns, each having borders and bold text
    $tablerowdata = "";
    while ( $row = mysqli_fetch_assoc($result)) {
        $daterow = $row['RoomType'];
        $PaymentMethod = $row['total'];
        $AmountPaid = number_format($row['Profit'], 2,".", ",");
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
                                <w:t>Room Name</w:t>
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
                                <w:t></w:t>
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

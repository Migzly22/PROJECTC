<?php
require 'vendor/autoload.php';
require("../Database.php");
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;

$sqlcode = $_GET["sqlcode"];

$msgarray = array();
$monthsArray = [];

for ($i = 1; $i <= 12; $i++) {
    $monthsArray[$i] = date('F', mktime(0, 0, 0, $i, 1));
}

if(strpos($sqlcode, "a.PaymentDate") !== false){
    if(strpos($sqlcode, "<=") !== false || strpos($sqlcode, ">=") !== false){

        if(strpos($sqlcode, ">=") !== false){
            $nn1 = explode(">= '",$sqlcode)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "from $newcode";
        }
        if(strpos($sqlcode, "<=") !== false){
            $nn1 = explode("<= '",$sqlcode)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "to $newcode";
        }
        $STRINGMSG = implode(" ", $msgarray);
    }else{
        if(strpos($sqlcode, "MONTH(") !== false){
            $nn1 = explode("MONTH(a.PaymentDate) = '",$sqlcode)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "the month of ".$monthsArray[$newcode];
        }
        if (strpos($sqlcode, "YEAR(") !== false){
            $nn1 = explode("YEAR(a.PaymentDate) = '",$sqlcode)[1];
            $newcode = explode("'",$nn1)[0];
            $msgarray[] = "year $newcode";
        }
        $STRINGMSG = implode(" and ", $msgarray);
    }

    
}else{
    $STRINGMSG = "the beginning of the Sales";
}


$sql = "SELECT a.*, if(a.Description = 'Downpayment', 'WALKIN', a.Description) AS DESCK, CONCAT(c.LastName, ', ', c.FirstName) AS NAME, b.timapackage, b.eCheckin, b.CheckOutDate , (b.NumAdults+b.NumChildren+b.NumSeniors+b.NumExcessPax) AS NUMGUEST 
FROM guestpayments a LEFT JOIN reservations b ON a.ReservationID = b.ReservationID LEFT JOIN guests c ON b.GuestID = c.GuestID
where $sqlcode
ORDER BY  CASE WHEN a.Description = 'CHECKOUT' THEN 1 ELSE 0 END, a.PaymentDate DESC ;";
$result = mysqli_query($conn, $sql);

$tablerowdata = "";
$COTTAGE= array();
$ROOM= array();
$PAVILION= array();
$ITEMS = array();
while ( $row = mysqli_fetch_assoc($result)) {
    $daterow = $row['PaymentDate'];
    $PaymentMethod = $row['NAME'];
    $description = $row['DESCK'];
    $AmountPaid = number_format( $row['AmountPaid'],2, ".", ",");

    $ReservationID = $row['ReservationID'];
    $date1 = new DateTime($row["eCheckin"]);
	$date2 = new DateTime($row["CheckOutDate"]);

	$interval = $date1->diff($date2);

	$total_hours = $interval->h + ($interval->days * 24);

	// Round up to the nearest multiple of 24 hours
	$rounded_hours = ceil($total_hours / 24) ;


    if($description == "CHECKOUT"){
        $sqlITEM = "SELECT COALESCE( SUM(a.ChargeAmount), 0) AS TOTAL FROM guestextracharges a WHERE a.ReservationID = '$ReservationID';";
        $sqlITEMquery = mysqli_query($conn,$sqlITEM);
        $ITEMRESULT = mysqli_fetch_assoc($sqlITEMquery);
        $ITEMS[$ReservationID] = $ITEMRESULT['TOTAL'];
    }

    if($row["timapackage"] == "22Hrs"){
        $datatype = "NightPrice";
    }else{
        $datatype = $row["timapackage"]."Price";
    }

    $sqlcottage = "SELECT a.*, SUM(c.$datatype) AS TOTAL FROM cottagereservation a LEFT JOIN cottage b ON a.cottagenum = b.Cottagenum LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName WHERE a.reservationID = '$ReservationID';";
    $cottagequery = mysqli_query($conn, $sqlcottage);
    $cottageresult = mysqli_fetch_assoc($cottagequery);
    $COTTAGE[$ReservationID] = ($description == "CHECKOUT") ? floatval($cottageresult["TOTAL"]) : floatval($cottageresult["TOTAL"])/2;


    if($row["timapackage"] == "22Hrs" || $rounded_hours > 1){
        $datatype2 = "Hours22";
    }else{
        $datatype2 = $row["timapackage"]."TimePrice";
    }

    $sqlroom = "SELECT a.*, SUM(c.$datatype2) AS TOTAL FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomNum LEFT JOIN roomtypes c ON b.RoomType = c.RoomType WHERE a.greservationID = '$ReservationID';";
    $roomquery = mysqli_query($conn, $sqlroom);
    $roomresult = mysqli_fetch_assoc($roomquery);
    $ROOM[$ReservationID] = ($description == "CHECKOUT") ? floatval($roomresult["TOTAL"])*$rounded_hours : (floatval($roomresult["TOTAL"])*$rounded_hours)/2;


    $EVENTLIST = "SELECT a.*, b.* FROM eventreservation a LEFT JOIN eventpav b ON a.eventname = b.Pavtype WHERE a.reservationID = '$ReservationID';";

    $EVENTLISTQuery =  mysqli_query($conn, $EVENTLIST);
    if(mysqli_num_rows($EVENTLISTQuery) > 0){
        $event2 = array();
        while($EVENTResult = mysqli_fetch_assoc($EVENTLISTQuery)){
            
            $guesttotalnumber = $row["NUMGUEST"] ;
            $newsql22 = "SELECT `".$EVENTResult["Pavtype"]."` FROM eventplace WHERE PAX >= '$guesttotalnumber' ORDER BY PAX ASC LIMIT 1;";
            $EVENTLISTQuery1 =  mysqli_query($conn, $newsql22);
            $EVENTresult = mysqli_fetch_assoc($EVENTLISTQuery1);
            $event2[$EVENTResult["eventname"]] = $EVENTresult[$EVENTResult["Pavtype"]];
        }

        if (!empty($event2)) {
            $PAVILION[$ReservationID] =  ($description == "CHECKOUT") ? array_sum($event2) : array_sum($event2)/2;
        }

    }

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
                            <w:t>'.$description.'</w:t>
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
                            <w:t>₱ '.$AmountPaid.'</w:t>
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
                            <w:t>Description / Paypal ID</w:t>
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








$csr = !empty($COTTAGE) ? array_sum($COTTAGE): 0;
$rsr = !empty($ROOM) ?  array_sum($ROOM): 0;
$psr = !empty($PAVILION) ? array_sum($PAVILION) : 0;
$isr = !empty($ITEMS) ? array_sum($ITEMS) : 0;
$tsr = $csr + $rsr + $psr;




// Load the template DOCX file
$templateFile = 'SalesReport.docx';
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
$document->setValue('{CSR}', number_format( $csr,2, ".", ","));
$document->setValue('{RSR}', number_format( $rsr,2, ".", ","));
$document->setValue('{PSR}', number_format( $psr,2, ".", ","));
$document->setValue('{ISR}', number_format( $isr,2, ".", ","));
$document->setValue('{TSR}', number_format( $tsr,2, ".", ","));
$document->setValue('{{DATAMENT}}', $STRINGMSG);

$document->setValue('{{DATATODAY}}', $table);

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
?>

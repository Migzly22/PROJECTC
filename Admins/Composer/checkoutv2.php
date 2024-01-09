<?php
require '../../Database.php';
require 'vendor/autoload.php';
session_start();
ob_start();

use PhpOffice\PhpWord\TemplateProcessor;

// Load the template DOCX file
$templateFile = 'Checkout.docx';


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

$cottagedataTable = "";
if(isset($arraynew['COTTAGE'])){
    $cottages = implode(', ',array_keys($arraynew['COTTAGE']));
    foreach ($arraynew['COTTAGE'] as $key => $item) {
        $sumOfCOTTAGES += intval($item);
        $cottagedataTable .= '<w:tr>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>'.$key.'</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>1</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
        
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>₱ '.number_format(intval($item), 2, '.', ',').'</w:t>
                </w:r>
            </w:p>
            </w:tc>
        </w:tr>';
    }
}


if(isset($arraynew['ROOM'])){
    $rooms = implode(', ',array_keys($arraynew['ROOM']));
    foreach ($arraynew['ROOM'] as $key => $item) {
        $sumOfROOM +=intval($item)*intval($rounded_hours);
        $cottagedataTable .= '<w:tr>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>'.$key.'</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>1</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
        
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>₱ '.number_format(intval($item)*intval($rounded_hours), 2, '.', ',').'</w:t>
                </w:r>
            </w:p>
            </w:tc>
        </w:tr>';
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
    foreach ($arraynew['EVENT'] as $key => $item) {
        $sumOfEVENT += intval($item);
        $cottagedataTable .= '<w:tr>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>'.$key.'</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
                <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>1</w:t>
                </w:r>
            </w:p>
            </w:tc>
            <w:tc>
        
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>₱ '.number_format(intval($item), 2, '.', ',').'</w:t>
                </w:r>
            </w:p>
            </w:tc>
        </w:tr>';
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


$tablerowdata = "";
$tablerowdata .= '
<w:tr>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>No. of Adults</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>'.$arraynew["NumAdults"].'</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>

    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>₱ '.$TPA.'</w:t>
        </w:r>
    </w:p>
    </w:tc>
</w:tr>
<w:tr>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>No. of Kids</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>'.$arraynew["NumChildren"].'</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>

    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>₱ '.$TPK.'</w:t>
        </w:r>
    </w:p>
    </w:tc>
</w:tr>
<w:tr>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>No. of Kids</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:jc w:val="center"/>
        </w:tcPr>
    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>'.$arraynew["NumSeniors"].'</w:t>
        </w:r>
    </w:p>
    </w:tc>
    <w:tc>

    <w:p>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                <w:sz w:val="24"/>
            </w:rPr>
            <w:t>₱ '.$TPS.'</w:t>
        </w:r>
    </w:p>
    </w:tc>
</w:tr>'.$cottagedataTable;


$table = '  <w:body>
    <w:tbl>
      <w:tblPr>
        <w:tblW w:w="100%" w:type="pct"/>
        <w:tblBorders>
            <w:top w:val="single" w:sz="1" w:color="000000"/>
            <w:left w:val="single" w:sz="1" w:color="000000"/>
            <w:bottom w:val="single" w:sz="1" w:color="000000"/>
            <w:right w:val="single" w:sz="1" w:color="000000"/>
            <w:insideH w:val="single" w:sz="1" w:color="000000"/>
            <w:insideV w:val="single" w:sz="1" w:color="000000"/>
        </w:tblBorders>
      </w:tblPr>
      <w:tr>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
          <w:p>
            <w:r>
              <w:t></w:t>
            </w:r>
          </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
          <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t>Quantity</w:t>
            </w:r>
          </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
          <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
              <w:t>Price</w:t>
            </w:r>
          </w:p>
        </w:tc>
      </w:tr>
      '.$tablerowdata.'
    </w:tbl>
  </w:body>';













$tablerowdata2 = "";
// if there are no data
$dataisnone = '  <w:tr>
    <w:tc>
    <w:tcPr>
        <w:vMerge w:val="restart"/>
    </w:tcPr>
            <w:p>
            <w:r>
                <w:t>-</w:t>
            </w:r>
            </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:vMerge w:val="continue"/>
        </w:tcPr>
        <w:p>
        <w:r>
            <w:t>-</w:t>
        </w:r>
        </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:vMerge w:val="continue"/>
        </w:tcPr>
        <w:p>
        <w:r>
            <w:t>-</w:t>
        </w:r>
        </w:p>
    </w:tc>
    <w:tc>
        <w:tcPr>
            <w:vMerge w:val="continue"/>
        </w:tcPr>
        <w:p>
        <w:r>
            <w:t>-</w:t>
        </w:r>
        </w:p>
    </w:tc>
</w:tr>
';

$sqlforITEMS = "SELECT * FROM guestextracharges WHERE ReservationID = '$reserveid';";
$sqlqueryITEMS = mysqli_query($conn,$sqlforITEMS);

while($result = mysqli_fetch_assoc($sqlqueryITEMS)){
    $data = $result['ChargeDate'];
    $name = $result['ChargeDescription'];
    $quantity = $result['quantity'];
    $price = $result['ChargeAmount'];

    $tablerowdata2 .= '
    <w:tr>
        <w:tc>
            <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
                <w:p>
                <w:r>
                    <w:t>'.$name.'</w:t>
                </w:r>
                </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:b/>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>'.$data.'</w:t>
                </w:r>
            </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t>'.$quantity.'</w:t>
            </w:r>
            </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t>'.$price.'</w:t>
            </w:r>
            </w:p>
        </w:tc>
    </w:tr>';
}   
if(mysqli_num_rows($sqlqueryITEMS) <= 0){
    $tablerowdata2 = $dataisnone;
}


$table2 = '  <w:body>
  <w:tbl>
    <w:tblPr>
      <w:tblW w:w="100%" w:type="pct"/>
      <w:tblBorders>
          <w:top w:val="single" w:sz="1" w:color="000000"/>
          <w:left w:val="single" w:sz="1" w:color="000000"/>
          <w:bottom w:val="single" w:sz="1" w:color="000000"/>
          <w:right w:val="single" w:sz="1" w:color="000000"/>
          <w:insideH w:val="single" w:sz="1" w:color="000000"/>
          <w:insideV w:val="single" w:sz="1" w:color="000000"/>
      </w:tblBorders>
    </w:tblPr>
    <w:tr>
        <w:tc>
            <w:tcPr>
                    <w:jc w:val="center"/>
                </w:tcPr>
                <w:p>
                <w:r>
                    <w:t></w:t>
                </w:r>
                </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
                <w:r>
                    <w:rPr>
                        <w:b/>
                        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                        <w:sz w:val="24"/>
                    </w:rPr>
                    <w:t>Date</w:t>
                </w:r>
            </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t>Quantity</w:t>
            </w:r>
            </w:p>
        </w:tc>
        <w:tc>
            <w:tcPr>
                <w:jc w:val="center"/>
            </w:tcPr>
            <w:p>
            <w:r>
                <w:rPr>
                    <w:b/>
                    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t>Price</w:t>
            </w:r>
            </w:p>
        </w:tc>
    </w:tr>
    '.$tablerowdata2.'
  </w:tbl>
</w:body>';



$utcNow = new DateTime('now', new DateTimeZone('UTC'));

// Set the time zone to Asia/Tokyo
$tokyoTimeZone = new DateTimeZone('Asia/Tokyo');

// Convert UTC time to Tokyo time
$tokyoTime = clone $utcNow;
$tokyoTime->setTimezone($tokyoTimeZone);

if (file_exists($templateFile)) {
  
    $document = new TemplateProcessor($templateFile);
    
    // Replace placeholders with values
    $name = $arraynew["LastName"].", ".$arraynew["FirstName"];
    $document->setValue('{{DATA1}}', $name);
    $document->setValue('{{DATA3}}', $arraynew["Address"]." ".$arraynew["City"]);
    $document->setValue('{{DATA4}}', $arraynew["Phone"]);
    $document->setValue('{{DATA2}}',$arraynew["Email"]);
    $document->setValue('{{DATADATE1}}',$tokyoTime->format('Y-m-d'));

    $document->setValue('{{DATABOOKINGS}}', $table);
    $document->setValue('{{DATAEXPENSES}}', $table2);
    //$document->setValue('{-RNA-}', $arraynew["CheckOutDate"]);

    $document->setValue('{{DATAT4}}', $TPA);
    $document->setValue('{{DATAT5}}', $TPK);
    $document->setValue('{{DATAT6}}', $TPS);

    $document->setValue('{{DATAT1}}', $arraynew["NumAdults"]);
    $document->setValue('{{DATAT2}}', $arraynew["NumChildren"]);
    $document->setValue('{{DATAT3}}', $arraynew["NumSeniors"]);
    $document->setValue('{{DATA6}}', number_format($arraynew["TotalPrice"], 2, '.', ','));
    $document->setValue('{{DATA5}}',number_format($arraynew["Downpayment"], 2, '.', ','));
    
    // Save the modified document
    $outputFile = 'export.docx';
    $document->saveAs($outputFile);
    

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="Elijosh_Receipt_'.$name.'.docx"');
    header('Content-Length: ' . filesize($outputFile));
    header('Connection: close');
    
    // Output the file content
    readfile($outputFile);


     // Clean output buffer
    ob_end_flush();

    /// Set a session flash message
    //$_SESSION['redirect_message'] = 'Redirect after download';
    
   // exit();
}

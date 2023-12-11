<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];

    $sqlcodeGuestinfo = "SELECT a.* FROM guests a WHERE a.GuestID = '$userid';";
    $GuestQuesry = mysqli_query($conn,$sqlcodeGuestinfo);
    $GuestInfo = mysqli_fetch_assoc($GuestQuesry);


    $sqlReservation = "SELECT * FROM reservations WHERE GuestID = '$userid';";
    $ReservationQuery = mysqli_query($conn,$sqlReservation);
    $ReservationData = mysqli_fetch_assoc($ReservationQuery);

?>


<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Reservation</h1>
                </div>

                
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="firstName">First Name :</label>
                                <input type="text" name="firstName" id="firstName" readonly value="<?php echo $GuestInfo["FirstName"]?>">
                            </div>
                            <div class="form-column">
                                <label for="middleName">Middle Name :</label>
                                <input type="text" name="middleName" id="middleName" readonly value="<?php echo $GuestInfo["LastName"]?>">
                            </div>
                            <div class="form-column">
                                <label for="lastName">Last Name  :</label>
                                <input type="text" name="lastName" id="lastName" readonly value="<?php echo $GuestInfo["LastName"]?>">
                            </div>
                            <div class="form-column">
                                <label for="address">Address :</label>
                                <input type="text" name="address" id="address" readonly value="<?php echo $GuestInfo["Address"]?>">
                            </div>
                            <div class="form-column">
                                <label for="email">Email :</label>
                                <input type="email" name="email" id="email" readonly value="<?php echo $GuestInfo["Email"]?>">
                            </div>
                            <div class="form-column">
                                <label for="phoneNumber">Phone Number :</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" readonly value="<?php echo $GuestInfo["Phone"]?>">
                            </div>
                        </div>
                        <div>
                            <h3>-Summary-</h3>
                        </div>
                        <div class="box2">
           
                        <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th scope='col'></th>
                                    <th scope='col' style='text-align:center;'>Quantity</th>
                                    <th scope='col' style='text-align:center;'>Price</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
<?php    

$dateTime = new DateTime($ReservationData['CheckInDate']);
// Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
$dayOfWeekNumber = $dateTime->format('N');

// Convert the number to the day name
$dayOfWeekName = date('l', strtotime($ReservationData['CheckInDate']));



if($dayOfWeekNumber <= 4){
    $columnstring = "Weekdays".$ReservationData['timapackage']."Price";
}else{
    $columnstring = "WeekendsHolidays".$ReservationData['timapackage']."Price";
}


$sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
$sql1query = mysqli_query($conn, $sql1);
$entrance = array();

while ($result = mysqli_fetch_assoc($sql1query)) {
  $entrance[] = $result[$columnstring];
}



    $sum = 0;
    $sum += $ReservationData["NumAdults"] * $entrance[0];
    $sum += $ReservationData["NumChildren"] * $entrance[1];
    $sum += $ReservationData["NumSeniors"] * ($entrance[0]-(($entrance[0]*.2)));


    $pricepool = array();
    $pricepool[] = $ReservationData["NumAdults"] * $entrance[0];
    $pricepool[] = $ReservationData["NumChildren"] * $entrance[1];
    $pricepool[] = $ReservationData["NumSeniors"] * ($entrance[0]-(($entrance[0]*.2)));

    if($ReservationData["package"] == "Package2"){
        $pricepool[0] = 0.00;
        $pricepool[1] = 0.00;
        $pricepool[2] = 0.00;
    }

    $sum += $pricepool[0];
    $sum += $pricepool[1];
    $sum += $pricepool[2] ;
?>


                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumAdults"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo  $pricepool[0];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumChildren"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo $pricepool[1];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumSeniors"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo $pricepool[2];?></td>
                                </tr>


<?php
$COTTAGELIST = "SELECT a.*, b.*, c.* FROM cottagereservation a LEFT JOIN cottage b ON a.cottagenum = b.Cottagenum LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName  WHERE a.reservationID = '".$ReservationData["ReservationID"]."';";

$COTTAGELISTQuery =  mysqli_query($conn, $COTTAGELIST);
$data1 = "";
if(mysqli_num_rows($COTTAGELISTQuery) > 0){
    while($CottageResult = mysqli_fetch_assoc($COTTAGELISTQuery)){
        if($ReservationData["timapackage"] == "22Hrs"){
            $datatype = "NightPrice";
        }else{
            $datatype = $ReservationData["timapackage"]."Price";
        }

        $data1 .= "<tr>
        <th style='text-align:start;'>".$CottageResult["ServiceTypeName"]."-".$CottageResult["cottagenum"]."</th>
        <td style='text-align:center;'>1</td>
        <td style='text-align:end;'>₱ ".number_format($CottageResult[$datatype], 2)."</td>
        </tr>";

        $sum += intval($CottageResult[$datatype]);
    }
    echo $data1;
}

$ROOMLIST = "SELECT a.*, b.*, c.* FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomNum LEFT JOIN roomtypes c ON b.RoomType = c.RoomType  WHERE a.greservationID = '".$ReservationData["ReservationID"]."';";
$ROOMLISTQuery =  mysqli_query($conn, $ROOMLIST);
$data2 = "";

if(mysqli_num_rows($ROOMLISTQuery) > 0){
    while($CottageResult = mysqli_fetch_assoc($ROOMLISTQuery)){
        if($ReservationData["timapackage"] == "22Hrs"){
            $datatype = "Hours22";
        }else{
            $datatype = $ReservationData["timapackage"]."TimePrice";
        }

        $data2 .= "<tr>
        <th style='text-align:start;'>".$CottageResult["RoomType"]."-".$CottageResult["RoomNum"]."</th>
        <td style='text-align:center;'>1</td>
        <td style='text-align:end;'>₱ ".number_format($CottageResult[$datatype], 2)."</td>
        </tr>";
        $sum += intval($CottageResult[$datatype]);
    }
    echo $data2;
    
}


$EVENTLIST = "SELECT a.*, b.* FROM eventreservation a LEFT JOIN eventpav b ON a.eventname = b.Pavtype WHERE a.reservationID = '".$ReservationData["ReservationID"]."';";
$EVENTLISTQuery =  mysqli_query($conn, $EVENTLIST);
$data2 = "";

if(mysqli_num_rows($EVENTLISTQuery) > 0){
    while($CottageResult = mysqli_fetch_assoc($EVENTLISTQuery)){
        
        $guesttotalnumber = $ReservationData["NumAdults"] + $ReservationData["NumChildren"] + $ReservationData["NumSeniors"] ;
        $newsql22 = "SELECT `".$CottageResult["Pavtype"]."` FROM eventplace WHERE PAX >= '$guesttotalnumber' ORDER BY PAX ASC LIMIT 1;";
        $EVENTLISTQuery1 =  mysqli_query($conn, $newsql22);
        $EVENTresult = mysqli_fetch_assoc($EVENTLISTQuery1);

        $data2 .= "<tr>
        <th style='text-align:start;'>".$CottageResult["eventname"]."</th>
        <td style='text-align:center;'>1</td>
        <td style='text-align:end;'>₱ ".number_format($EVENTresult[$CottageResult["Pavtype"]], 2)."</td>
        </tr>";
        $sum += intval($EVENTresult[$CottageResult["Pavtype"]]);
    }
    echo $data2;
    
}

?>

                                <tr>
                                    <th style='text-align:start;' colspan="2">Initial Total</th>
                                    <td style='text-align:end;' id="TPrice">₱<?php echo  $ReservationData["TotalPrice"];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;' colspan="2">Downpayment</th>
                                    <td style='text-align:end;' id="Dpayment">₱<?php echo $ReservationData["Downpayment"];?></td>
                                </tr>
                            </tbody>
                        </table>

                        
                        </div>


                        <div>
                            <h3>-Extra Charges-</h3>
                        </div>
                        <div class="box2">
                                                    <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th scope='col'></th>
                                    <th scope='col' style='text-align:center;'>Quantity</th>
                                    <th scope='col' style='text-align:center;'>Price</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT2">
<?php 
    $extrachargessql = "SELECT *, SUM(quantity) AS newQuantity, SUM(ChargeAmount) as newPrice FROM guestextracharges WHERE ReservationID = '".$ReservationData['ReservationID']."' GROUP BY ChargeDescription;";
    $extrachargequery = mysqli_query($conn,$extrachargessql);
    $extrachargestable = "";
    while ($extrachargeresult = mysqli_fetch_assoc($extrachargequery)) {
        $arraycharge =  explode(" - ", $extrachargeresult["ChargeDescription"]);
        $extrachargestable .= "
            <tr>
                <th style='text-align:start;'>".$extrachargeresult["ChargeDescription"]."</th>
                <td style='text-align:center;'>".$extrachargeresult["newQuantity"]."</td>
                <td style='text-align:end;'>₱ ".$extrachargeresult["newPrice"]."</td>
            </tr>
        ";
    }
    echo $extrachargestable;

?>
                            </tbody>
                        </table>

                        </div>
                        <div>
                            <h3>-Total-</h3>
                        </div>
                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                            <thead>
<?php 
    $totalsumsql = "SELECT
    (a.TotalPrice +COALESCE(b.ExtraChargeSum, 0)) AS TotalOverall,
    (a.TotalPrice +COALESCE(b.ExtraChargeSum, 0)) -SUM(c.AmountPaid) AS Balance
FROM reservations a
LEFT JOIN (
    SELECT ReservationID, SUM(ChargeAmount) AS ExtraChargeSum
    FROM guestextracharges
    GROUP BY ReservationID) b ON a.ReservationID = b.ReservationID
LEFT JOIN guestpayments c ON a.ReservationID = c.ReservationID
WHERE a.ReservationID = '".$ReservationData['ReservationID']."';";

    $totalquery = mysqli_query($conn,$totalsumsql);
    $totalresult = mysqli_fetch_assoc($totalquery);

        echo "
            <tr>
                <th style='text-align:start;'>Total Price</th>
                <th style='text-align:end;'>₱ ".$totalresult["TotalOverall"]."</th>
            </tr>
            <tr>
                <th style='text-align:start;'>Balance</th>
                <th style='text-align:end;'>₱ ".$totalresult["Balance"]."</th>
            </tr>
        ";


?>
                            </thead>
                        </table>

                        </div>
                    </div>
                </form>
            </div>


<script>

    function changebacktozero(id){
        var element = document.getElementById(id);
        if(element.value < 0 ){
            element.value = 0;
        }
    }
    async function ADDPERSON(id){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>No. of Adult</label>
                <input type ="number" id="swal-input1" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>No. of Kids</label>
                <input type ="number" id="swal-input2" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>No. of Senior</label>
                <input type ="number" id="swal-input3" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
        </div>`

        let formValues =await POPUPCREATE("Additional Head Count",design,3)

        if (formValues) {
            let conditions = [];
            
            let paymentadult = document.getElementById("valueid1").value
            let paymentkid = document.getElementById("valueid1").value

            let Tabledata = '';
            let sqlcode = `INSERT INTO guestextracharges (ReservationID,ChargeDescription, quantity, ChargeAmount, ChargeDate) VALUES ('${id}', :VALUECHANGE:, CURRENT_DATE);`;
            
            if(formValues[0] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Adult','${formValues[0]}', '${parseFloat(formValues[0])*parseFloat(paymentadult)}'`)
                Tabledata = await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            if(formValues[1] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Kid','${formValues[1]}', '${parseFloat(formValues[1])*parseFloat(paymentkid)}'`)
                Tabledata = await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            if(formValues[2] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Senior','${formValues[2]}', '${parseFloat(formValues[2])* (parseFloat(paymentadult) - (parseFloat(paymentadult)*.2))}'`)
                Tabledata =await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            const TBODYELEMENT = document.getElementById('TBODYELEMENT2')
            TBODYELEMENT.innerHTML = Tabledata
        }
    }
    async function EDITStatus(params,gid) {
        location.href = `./Mainpage.php?nzlz=addItems&plk=2&ISU=${params}&GID=${gid}`;
    }
</script>
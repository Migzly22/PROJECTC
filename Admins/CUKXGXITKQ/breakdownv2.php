<?php
//error_reporting(E_ERROR | E_PARSE);
$pacvalue = "";
$timevalue = "";

switch ($_GET['package']) {
  case 'Package1':
    $pacvalue = "Swimming Only";
    break;
  case 'Package2':
    $pacvalue = "Rooms + Swimming";
    break;
  case 'Package3':
    $pacvalue = "Pavilions";
    break;
}

switch ($_GET['tRANGE']) {
  case 'Day':
    $timevalue = "8:00 - 17:00";
    break;
  case 'Night':
    $timevalue = "19:00 - 7:00";
    break;
  case '22Hrs':
    $timevalue = "14:00 - 12:00";
    break;
}
$arraynew['checkin'] = $_GET['cin'];
$arraynew['package'] = $_GET['package'];
$arraynew["time"] = $timevalue;
$arraynew["trange"] = $_GET['tRANGE'];
?>

    <link rel="stylesheet" href="./CSS/styleformsettingclient.css">




<?php
    $ids = $_SESSION["USERID"];
    $sqlcode = "SELECT userID, FirstName, MiddleName,LastName, PhoneNumber, Address, City, Email FROM userscredentials WHERE userID = '$ids';";
    $USERDATA = mysqli_query($conn,$sqlcode);   
    $resultname = mysqli_fetch_assoc($USERDATA);

    $arraynew["USERINFO"] = $_SESSION["Walkinuser"];

    $dateTime = new DateTime($_GET['cin']);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($_GET['cin']));



    if($dayOfWeekNumber <= 4){
        $columnstring = "Weekdays".$_GET['tRANGE']."Price";
    }else{
        $columnstring = "WeekendsHolidays".$_GET['tRANGE']."Price";
    }


    $sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
    $sql1query = mysqli_query($conn, $sql1);
    $entrance = array();

    while ($result = mysqli_fetch_assoc($sql1query)) {
      $entrance[] = $result[$columnstring];
    }

?>

            <div class="mainbodycontainer">
                <div class="stafflistbox">
                    <div class="box">
                        <div class="box2">
                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2><?php echo $resultname["LastName"].", ".$resultname["FirstName"]?> Payment</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col'></th>
                                    <th scope='col' style="text-align:center;">Quantity</th>
                                    <th scope='col' style="text-align:center;">Price</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
                                <?php

                                    $arraynew["No. of Adult"] = $_GET['na'];
                                    $arraynew["No. of Kid"] = $_GET['nk'];
                                    $arraynew["No. of Seniors"] = $_GET['ns'];

                                ?>
                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $_GET['na'];?></td>
                                    <td style='text-align:end;'>₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" : number_format($arraynew["No. of Adult"] *$entrance[0], 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $_GET['nk'];?></td>
                                    <td style='text-align:end;'>₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" :number_format($arraynew["No. of Kid"] * $entrance[1], 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $_GET['ns'];?></td>
                                    <td style='text-align:end;'>₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" : number_format($arraynew["No. of Seniors"] * ($entrance[0]-(($entrance[0]*.2))), 2);?></td>
                                </tr>


<?php

$cottagejson = json_decode($_GET["cotlist"], true);

if(count($cottagejson) >  0 ){
    // Iterate over the main array
    foreach ($cottagejson as $key => $nestedArray) {

        echo "<tr>
            <th style='text-align:start;'>".$key."</th>
            <td style='text-align:center;'>1</td>
            <td style='text-align:end;'>₱ ".number_format($nestedArray["price"], 2)."</td>
            </tr>";
    }
}
$roomjson = json_decode($_GET["roomlist"], true);


if(count($roomjson) >  0 ){
    // Iterate over the main array
    foreach ($roomjson as $key => $nestedArray) {

        echo "<tr>
            <th style='text-align:start;'>".$key."</th>
            <td style='text-align:center;'>1</td>
            <td style='text-align:end;'>₱ ".number_format($nestedArray["price"], 2)."</td>
            </tr>";
    }
}

$eventjson = json_decode($_GET["eventlist"], true);


if(count($eventjson) >  0 ){
    // Iterate over the main array
    foreach ($eventjson as $key => $nestedArray) {

        echo "<tr>
            <th style='text-align:start;'>".$key."</th>
            <td style='text-align:center;'>1</td>
            <td style='text-align:end;'>₱ ".number_format($nestedArray["price"], 2)."</td>
            </tr>";
    }
}

$arraynew["COTTAGE"] = json_decode( $_GET["cotlist"], true);
$arraynew["ROOM"] = json_decode( $_GET["roomlist"], true);
$arraynew["EVENT"] = json_decode( $_GET["eventlist"], true);
$arraynew['TOTAL'] = $_GET["tinit"];
$arraynew['DPAYMENT'] = $_GET["tinit"]*.5;


$arraynew['ETIME'] = $_GET["ETIME"];
$arraynew['ADULTPAY'] = $entrance[0];
$arraynew['KIDPAY'] = $entrance[1];
$arraynew['SENIORPAY'] = $entrance[0]-(($entrance[0]*.2));
$_SESSION["Newcustomerappointment"] = json_encode($arraynew, JSON_PRETTY_PRINT);

//print_r($_SESSION["Newcustomerappointment"]);


?>
    <textarea name="" id="savevalues" cols="30" rows="10" style="display:none;"><?php echo $_SESSION["Newcustomerappointment"];?></textarea>
                                <tr>
                                    <th style='text-align:start;' colspan="2">TOTAL</th>
                                    <td style='text-align:end;' id="TPrice">₱ <?php echo  number_format($_GET["tinit"], 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;' colspan="2">DOWNPAYMENT</th>
                                    <td style='text-align:end;' id="Dpayment">₱ <?php echo  number_format($_GET["tinit"]*.5, 2);?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top:2em; ">
                        <textarea name="" id="savevalues" cols="30" rows="10" style="display:none;"><?php echo $_SESSION["Newcustomerappointment"];?></textarea>
                        <input type="button" value="Save and Submit" class="submitbtn addbtn" onclick="SAVE()">
                </div>
       
                </div>
     
            </div>
       


    

    <script>


    async function SAVE(ids) {
        let downpayment = `<?php echo $arraynew['DPAYMENT'];?>`;

        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Total</label>
                <input type ="text" id="swal-input3" class="SWALinput" readonly value='${downpayment}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Payment</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Type of Payment</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value='CASH'>Cash</option>
                    <option value='ONLINE'>Online Payment</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Downpayment",design,3)

        if (formValues) {
            let conditions = [];

            conditions.push(`${formValues[1]}`);

            if(formValues[0] !== "" && parseFloat(formValues[0]) >= parseFloat(downpayment)){
                let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES (':ID:', CURRENT_DATE , '${downpayment}', 'ONLINE','${ids}');`;
                Inputtime(sqlcodepayment,ids)
            }else{
                await Swal.fire({
                    title: "",
                    text: "Wrong Payment Value",
                    icon: "warning"
                });
                SAVE();
            }
    
            
        }


    }

    async function Inputtime(sqlcodepayment,paymentdescription){
   
        const savevalues = document.getElementById("savevalues").value; `<?php echo $arraynew['DPAYMENT'];?>`
        var jsonObject = JSON.parse(savevalues);
        console.log(jsonObject)



        let insertguest = `INSERT INTO guests (GuestID, FirstName, MiddleName, LastName, Email, Phone, Address) VALUES 
        (NULL, '${jsonObject.USERINFO.FirstName}', 
        '${jsonObject.USERINFO.MiddleName}' , 
        '${jsonObject.USERINFO.LastName}', 
        '${jsonObject.USERINFO.Email}', 
        '${jsonObject.USERINFO.PhoneNumber}', 
        '${jsonObject.USERINFO.Address}')`

        let selectguest = `SELECT GuestID FROM guests WHERE FirstName = '${jsonObject.USERINFO.FirstName}' AND 
        LastName = '${jsonObject.USERINFO.LastName}' AND 
        Email = '${jsonObject.USERINFO.Email}' ORDER BY GuestID DESC LIMIT 1;`
        const dataid =await AjaxSendv3(insertguest,"BREAKDOWNLOGIC",`&Process=UpdateGuest&sqlcode2=${selectguest}`)
       

        let timeitself = jsonObject.time.split(' - ')[1]
        const dateObject = new Date(jsonObject.checkin);

        // Get the current date components
        const currentYear = dateObject.getFullYear();
        const currentMonth = dateObject.getMonth() + 1;
        const currentDay = dateObject.getDate();

        // Calculate the next day
        let nextDay = currentDay + 1;
        let nextMonth = currentMonth;
        let nextYear = currentYear;

        // Check if the next day exceeds the number of days in the current month
        if (nextDay > new Date(currentYear, currentMonth, 0).getDate()) {
            nextDay = 1;
            nextMonth += 1;

            // Check if the next month exceeds 11 (December)
            if (nextMonth > 12) {
                nextMonth = 1;
                nextYear += 1;
            }
        }

        // Create a new Date object for the next day
        const nextDayDateObject = new Date(nextYear, nextMonth - 1, nextDay);
        console.log(nextDayDateObject);

        let newdata = ''
        switch (jsonObject.trange) {
            case 'Day':
                newdata = `${dateObject.getFullYear()}-${dateObject.getMonth()+1}-${dateObject.getDate()}T${timeitself}`
                break;
            case 'Night':
                newdata = `${nextDayDateObject.getFullYear()}-${nextDayDateObject.getMonth()+1}-${nextDayDateObject.getDate()}T${timeitself}`
                break;
            default:
                newdata = `${nextDayDateObject.getFullYear()}-${nextDayDateObject.getMonth()+1}-${nextDayDateObject.getDate()}T${timeitself}`
                break;
        }

        let timeitself2 = `<?php echo $_GET['ETIME'];?>`;
        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate,eCheckin, CheckOutDate, NumAdults, NumChildren, NumSeniors, NumExcessPax, timapackage, TotalPrice, Downpayment) 
        VALUES (NULL, '${dataid}', 
        '${jsonObject.checkin}', 
        '${jsonObject.checkin} ${timeitself2}',
        '${newdata}', 
         '${jsonObject["No. of Adult"]}', 
         '${jsonObject["No. of Kid"]}', 
         '${jsonObject["No. of Seniors"]}', 
         '0', 
         '${jsonObject.trange}', 
         '${jsonObject.TOTAL}', 
         '${jsonObject.DPAYMENT}');`

         let selectreservation = `SELECT ReservationID FROM reservations WHERE CheckInDate = '${jsonObject.checkin}' AND GuestID = '${dataid}' ORDER BY ReservationID DESC LIMIT 1;`
        console.log(selectreservation)
        console.log(insertreservation)
         const dataid2 =await AjaxSendv3(insertreservation,"BREAKDOWNLOGIC",`&Process=UpdateReservation&sqlcode2=${selectreservation}`)


        if(jsonObject.COTTAGE !== null){
            for (const key in jsonObject.COTTAGE) {
                if (jsonObject.COTTAGE.hasOwnProperty(key)) {
                    const keyholder = jsonObject.COTTAGE[key];
                    let insertrooms = `INSERT INTO cottagereservation (reservationID, cottagenum) VALUES ('${dataid2}', '${keyholder.num}');`
                    await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
                }
            }
        }
        if(jsonObject.ROOM !== null){
            for (const key in jsonObject.ROOM) {
                if (jsonObject.ROOM.hasOwnProperty(key)) {
                    const keyholder = jsonObject.ROOM[key];
                    let insertrooms = `INSERT INTO roomsreservation (greservationID, Room_num) VALUES ('${dataid2}', '${keyholder.num}');`
                    await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
                }
            }
        }
        if(jsonObject.EVENT !== null){
            for (const key in jsonObject.COTTAGE) {
                if (jsonObject.COTTAGE.hasOwnProperty(key)) {
                    const keyholder = jsonObject.COTTAGE[key];
                    let insertrooms = `INSERT INTO eventreservation (reservationID, eventname) VALUES ('${dataid2}', '${keyholder.name}');`
                    await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
                }
            }
        }
        

        let paymentdone = sqlcodepayment.replace(':ID:', `${dataid2}`)
        await AjaxSendv3(paymentdone,"BREAKDOWNLOGIC",`&Process=Insertmore`)

        
        $.ajax({
            url:`../Admins/Composer/paypal.php`,
            type:"GET",
            beforeSend:function(){
                location.href = "../Admins/Composer/paypal.php";
            },
            error: function(e) 
            {
                console.log("errro")
            },
            success:async function(){
                //await sendinggmailnotif(dataid2, paymentdescription,jsonObject["email"],jsonObject["userID"])
                //location.href = "../Admins/Composer/docxphp.php";dataid2, paymentdescription
                location.href = `./Mainpage.php?nzlz=booking&plk=2`;
                //location.href = "./bookinginformations.php";
            }
        }); 

    }
    </script>

<?php 
    $cin = isset($_GET['cin']) ? $_GET['cin'] : "";
    $ETIME = isset($_GET['ETIME']) ? $_GET['ETIME'] : "";
    $tRANGE = isset($_GET['tRANGE']) ? $_GET['tRANGE'] : "";
    $package = isset($_GET['package']) ? $_GET['package'] : "";

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
        $timevalue = "08:00 AM - 05: 00 PM";
        $timevalue2 = "08:00 AM - 17:00";
        break;
    case 'Night':
        $timevalue = "07:00 PM - 07: 00 AM";
        $timevalue2 = "07:00 PM - 07:00";
        break;
    case '22Hrs':
        $timevalue = "02:00 PM - 12: 00 PM";
        $timevalue2 = "02:00 PM - 12:00";
        break;
    }
    
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

    $guesttotalnumber = $_GET['na']+$_GET['nk']+$_GET['ns'];
    $arraynew["USERINFO"] = $_SESSION["Walkinuser"];

    $currentURL = $_SERVER['REQUEST_URI'];
    $dataurl =  explode("?nzlz=booking_breakdown&",$currentURL)[1];

    $arraynew['checkin'] = $_GET['cin'];
    $arraynew['package'] = $_GET['package'];
    $arraynew["time"] = $timevalue2;
    $arraynew["trange"] = $_GET['tRANGE'];
?>


<main>
    <div class="head-title">
        <div class="left">
            <h1>Payment Breakdown</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Booking</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="./index.php?nzlz=booking">Home</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="./index.php?nzlz=booking_walkin&<?php echo $dataurl;?>">Walk-ins</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Payment Breakdown</a>
                </li>
            </ul>
        </div>

    </div>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Walkin Information</h3>
            </div>
            <div class="layer-3">
                <div class="form-group f30">
                    <p>Name : <?php echo $arraynew["USERINFO"]["LastName"] .", ".$arraynew["USERINFO"]["FirstName"] ;?></p>
                </div>
                <div class="form-group f30">
                    <p>Time Range : <?php echo $timevalue?></</p>
                </div>
                <div class="form-group f30">
                    <p>Package : <?php echo $pacvalue?></</p>
                </div>
            </div>
        </div>

    </div>
    <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Pool & Cottages</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th></th>
								<th>Quantity</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
              <?php

                  $arraynew["No. of Adult"] = $_GET['na'];
                  $arraynew["No. of Kid"] = $_GET['nk'];
                  $arraynew["No. of Seniors"] = $_GET['ns'];

              ?>
              <tr>
                  <th >No. of Adults</th>
                  <td ><?php echo $_GET['na'];?></td>
                  <td >₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" : number_format($arraynew["No. of Adult"] *$entrance[0], 2);?></td>
              </tr>
              <tr>
                  <th>No. of Kids</th>
                  <td ><?php echo $_GET['nk'];?></td>
                  <td>₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" :number_format($arraynew["No. of Kid"] * $entrance[1], 2);?></td>
              </tr>
              <tr>
                  <th>No. of Senior</th>
                  <td ><?php echo $_GET['ns'];?></td>
                  <td>₱ <?php echo ($_GET['package'] == 'Package2') ? "0.00" : number_format($arraynew["No. of Seniors"] * ($entrance[0]-(($entrance[0]*.2))), 2);?></td>
              </tr>
							<?php

                $cottagejson = json_decode($_GET["cotlist"], true);

                if(count($cottagejson) >  0 ){
                    // Iterate over the main array
                    foreach ($cottagejson as $key => $nestedArray) {

                        echo "<tr>
                            <th>".$key."</th>
                            <td>1</td>
                            <td>₱ ".number_format($nestedArray["price"], 2)."</td>
                            </tr>";
                    }
                }
              ?>
						</tbody>
					</table>
				</div>

		</div>
    <?php
    
      $roomjson = (isset($_GET["roomlist"])) ? json_decode($_GET["roomlist"], true) :  array();


      if(count($roomjson) >  0 ){
          // Iterate over the main array
    ?>
        <div class="table-data">
          <div class="order">
            <div class="head">
              <h3>Rooms</h3>
            </div>
            <table>
              <thead>
                <tr>
                  <th></th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($roomjson as $key => $nestedArray) {

                    echo "<tr>
                        <th>".$key."</th>
                        <td>1</td>
                        <td>₱ ".number_format($nestedArray["price"], 2)."</td>
                        </tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>

        </div>
    <?php
          
      }

    ?>

    <?php
    
    $eventjson = isset($_GET["eventlist"]) ? json_decode($_GET["eventlist"], true) : array();


    if(count($eventjson) >  0 ){
    ?>
        <div class="table-data">
          <div class="order">
            <div class="head">
              <h3>Event</h3>
            </div>
            <table>
              <thead>
                <tr>
                  <th></th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img src="img/people.png">
                    <p>John Doe</p>
                  </td>
                  <td>01-10-2021</td>
                  <td>01-10-2021</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
        <div class="table-data">
          <div class="order">
            <div class="head">
              <h3>Rooms</h3>
            </div>
            <table>
              <thead>
                <tr>
                  <th></th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($eventjson as $key => $nestedArray) {

                      echo "<tr>
                          <th style='text-align:start;'>".$key."</th>
                          <td style='text-align:center;'>1</td>
                          <td style='text-align:end;'>₱ ".number_format($nestedArray["price"], 2)."</td>
                          </tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>

        </div>
    <?php
          
      }

      $arraynew["COTTAGE"] = json_decode( $_GET["cotlist"], true);
      $arraynew["ROOM"] = isset($_GET["roomlist"]) ? json_decode( $_GET["roomlist"], true) : null;
      $arraynew["EVENT"] = isset($_GET["eventlist"]) ? json_decode( $_GET["eventlist"], true) : null;
      $arraynew['TOTAL'] = $_GET["tinit"];
      $arraynew['DPAYMENT'] = $_GET["tinit"]*.5;


      $arraynew['ETIME'] = $_GET["ETIME"];
      $arraynew['packagenum'] = $_GET["package"];
      $arraynew['ADULTPAY'] = $entrance[0];
      $arraynew['KIDPAY'] = $entrance[1];
      $arraynew['SENIORPAY'] = $entrance[0]-(($entrance[0]*.2));

      $_SESSION["Newcustomerappointment"] = json_encode($arraynew, JSON_PRETTY_PRINT);
    ?>
 <div class="table-data">
				<div class="order">
					<table>
						<tbody>
							<tr>
								<th>Total Price</th>
								<th></th>
								<th style="text-align: end;">₱ <?php echo  number_format($arraynew["TOTAL"], 2);?></th>
							</tr>
              <tr>
								<th>Downpayment</th>
								<th></th>
								<th style="text-align: end;">₱ <?php echo  number_format($arraynew["DPAYMENT"], 2);?></th>
							</tr>
						</tbody>
					</table>
          <div class="BUTTONHANDLER">
            <button type="submit" class="ContinueBTN" onclick="SAVE()">Submit</button>
        </div>
				</div>
       
		</div>

   
</main>
<script>
    async function SAVE() {
        let downpayment = `<?php echo $arraynew['DPAYMENT'];?>`;

        let design = `
        <div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
          <label for="inputLabel">Total</label>
          <input type ="text" id="swal-input3" class="SWALinput"  class='SWALinput swalselect'  style='padding:0.5em;' readonly value='${downpayment}'>
        </div>
        <div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
          <label for="inputLabel">Payment</label>
          <input type ="text" id="swal-input1" class="SWALinput" style='padding:0.5em;' required>
        </div>
        <div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
          <label for="inputLabel">Type of Payment</label>
          <select class='SWALinput swalselect' style='padding:0.5em;' id='swal-input2' aria-label='Floating label select example'>
                <option value='CASH'>Cash</option>
                <option value='E-Pay'>E-Cash</option>
            </select>
        </div>`

        let formValues =await POPUPCREATE("Downpayment",design,3)

        if (formValues) {
            let conditions = [];

            conditions.push(`${formValues[1]}`);

            if(formValues[0] !== "" && parseFloat(formValues[0]) >= parseFloat(downpayment)){
                let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES (':ID:', CURRENT_DATE , '${downpayment}', 'ONLINE','Downpayment');`;
                Inputtime(sqlcodepayment,'Downpayment')
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
   
        const savevalues =`<?php echo $_SESSION["Newcustomerappointment"];?>`; 
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
                newdata = `${dateObject.getFullYear()}-${dateObject.getMonth()+1}-${dateObject.getDate()} ${timeitself}`
                break;
            case 'Night':
                newdata = `${nextDayDateObject.getFullYear()}-${nextDayDateObject.getMonth()+1}-${nextDayDateObject.getDate()} ${timeitself}`
                break;
            default:
                newdata = `${nextDayDateObject.getFullYear()}-${nextDayDateObject.getMonth()+1}-${nextDayDateObject.getDate()} ${timeitself}`
                break;
        }

        let timeitself2 = `<?php echo $_GET['ETIME'];?>`;
        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate,eCheckin, CheckOutDate, NumAdults, NumChildren, NumSeniors, NumExcessPax, timapackage,package, TotalPrice, Downpayment) 
        VALUES (NULL, '${dataid}', 
        '${jsonObject.checkin}', 
        '${jsonObject.checkin} ${timeitself2}',
        '${newdata}', 
         '${jsonObject["No. of Adult"]}', 
         '${jsonObject["No. of Kid"]}', 
         '${jsonObject["No. of Seniors"]}', 
         '0', 
         '${jsonObject.trange}', 
         '${jsonObject.packagenum}', 
         '${jsonObject.TOTAL}', 
         '${jsonObject.DPAYMENT}');`

         console.log(insertreservation)
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
            
            for (const key in jsonObject.EVENT) {
                if (jsonObject.EVENT.hasOwnProperty(key)) {
                    const keyholder = jsonObject.EVENT[key];
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
                location.href = `./index.php?nzlz=booking`;
                //location.href = "./bookinginformations.php";
            }
        }); 

    }
    </script>
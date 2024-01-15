<?php 


    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        $specialcase = isset(explode('?', $_SERVER['REQUEST_URI'])[1]) ? "?".explode('?', $_SERVER['REQUEST_URI'])[1] : "";
        
        echo "
        <script>
            Swal.fire({
                icon : 'info',
                text: `It seems you haven't logged in yet. Do you have an account ?`,
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                allowOutsideClick: false
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    location.href = `../EliJosh_Login/index.php$specialcase`
                } else if (result.isDenied) {
                    location.href = `../EliJosh_Registration/index.php$specialcase`
                }
            });

        </script>
        ";
        
        //header("Location: ../EliJosh_Registration/index.php$specialcase");
        //ob_end_flush();
        exit;
    }
    //get the user information
    $getUSER = "SELECT * FROM userscredentials WHERE userID = '".$_SESSION["USERID"]."';";
    $sqlquerygetUSER = mysqli_query($conn,$getUSER);
    $datausersgetUSER = mysqli_fetch_assoc($sqlquerygetUSER);
    $_SESSION["Walkinuser"] = $datausersgetUSER;





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
    $daysofstay = $_GET["nsy"];

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

    $startdatecheckin = $arraynew['checkin']." ".$_GET['ETIME'];

    if(isset($_GET['nsy']) && $_GET['nsy'] > 1){
        $daystostay = ($_GET['nsy'] - 1) * 24;
        $newDate = date("Y-m-d", strtotime($startdatecheckin . " + $daystostay hours"));

    }else{
        $newDate = $arraynew['checkin'];
    }


    switch ($_GET['tRANGE']) {
    case 'Day':
        $newDate = $newDate." 17:00";
        break;
    case 'Night':
        $newDate = date("Y-m-d", strtotime($newDate . " + 1 days"))." 07:00";
        break;
    case '22Hrs':
        $newDate = date("Y-m-d", strtotime($newDate . " + 1 days"))." 12:00";
        break;
    }

    $arraynew['checkout'] = $newDate;
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

                $cottagejson = isset($_GET["cotlist"]) ? json_decode($_GET["cotlist"], true) : array();

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
              <h3>Pavilion</h3>
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

                        $itemarr = explode("-", $key); 
                      echo "<tr>
                          <th >".$itemarr[0]."</th>
                          <td >1</td>
                          <td >₱ ".number_format($eventjson[$key]["price"], 2)."</td>
                          </tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>

        </div>
    <?php
          
      }

      $arraynew["COTTAGE"] = isset($_GET["cotlist"]) ? json_decode( $_GET["cotlist"], true) : null;
      $arraynew["ROOM"] = isset($_GET["roomlist"]) ? json_decode( $_GET["roomlist"], true) : null;
      $arraynew["EVENT"] = isset($_GET["eventlist"]) ? json_decode( $_GET["eventlist"], true) : null;
      $arraynew['TOTAL'] = $_GET["tinit"];
      $arraynew['DPAYMENT'] = $_GET["tinit"]*.5;


      $arraynew['ETIME'] = $_GET["ETIME"];
      $arraynew['packagenum'] = $_GET["package"];
      $arraynew['ADULTPAY'] = $entrance[0];
      $arraynew['KIDPAY'] = $entrance[1];
      $arraynew['SENIORPAY'] = $entrance[0]-(($entrance[0]*.2));

     


      //transform the data to utf8 data so that there wont be any errors
    function utf8_encode_recursive($array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                // If the element is an array, recursively encode its values
                $value = utf8_encode_recursive($value);
            } elseif (is_string($value)) {
                // If the element is a string, apply utf8_encode
                $value = utf8_encode($value);
            }
        }

        return $array;
    }
    $encodedArray = utf8_encode_recursive($arraynew);


      $_SESSION["Newcustomerappointment"] = json_encode($encodedArray);

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
                    <div style="text-align: center;display:flex;justify-content:center; padding-top:2em;" class="hehezzz">
                        <div id="paypal-button-container" style="width:30%;min-width:300px;" ></div>
                    </div>
				</div>
       
		</div>

   
</main>
<script>
        const exchange = async (varname)=>{
            // get the most recent exchange rates via the "live" endpoint:
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_maAhMIbabbYJwSwLgRyKK0Z6H6FcGHDMSsHKyoEB',   
                    success: function(json) {
                        localStorage.setItem(varname, JSON.stringify(json));
                        return json
                    },
                    error: function (error) {
                        reject(error);
                    }
                });
            });
        }
        const dataGathering = async () =>{
            const timeZone = 'Asia/Tokyo';
            // Get the current date and time in the specified time zone
            const currentDate = new Date().toLocaleDateString('en-US', { timeZone });
            const data = localStorage.getItem(`USDval${currentDate}`);
            const exchangeDATA = data ? JSON.parse(data) : await exchange(`USDval${currentDate}`);
            return exchangeDATA.data.PHP
        }
        var USD_PHP = 55;

        const testing = async() =>{
            USD_PHP = await dataGathering()
        }
        testing();
        let downP = <?php echo $arraynew["DPAYMENT"];?>

        paypal.Buttons({

            createOrder: async function(data, actions){
                result = downP / USD_PHP;
                result = Math.round(result * 100) / 100;

                return actions.order.create({
                    purchase_units: [{
                        description : "EliJosh Resort Reservation Downpayment",
                        amount: {
                            value: result
                        }
                    }]
                })

            },
            onApprove: function(data, actions){
                return actions.order.capture().then(function(details){
                    
                    if(details.status === "COMPLETED"){
                        SAVE(details.id);
                    }
                    
                })
            },
            onError: async function (err) {
                // For example, redirect to a specific error page
                await Swal.fire({
                    title: "Failed!",
                    text: "Payment Transaction Failed!",
                    icon: "failed"
                });
            }

        }).render('#paypal-button-container');

    async function SAVE(ids) {
        let downpayment = `<?php echo $arraynew['DPAYMENT'];?>`;

        let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES (':ID:', CURRENT_DATE , '${downpayment}', 'PAYPAL','${ids}');`;
        Inputtime(sqlcodepayment,ids)

    }

    async function Inputtime(sqlcodepayment,paymentdescription){
   
        const savevalues =`<?php echo $_SESSION["Newcustomerappointment"];?>`; 
        var jsonObject = JSON.parse(savevalues);




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
        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate,eCheckin, CheckOutDate, NumAdults, NumChildren, NumSeniors, NumExcessPax, timapackage,package, TotalPrice, Downpayment, UserID) 
        VALUES (NULL, '${dataid}', 
        '${jsonObject.checkin}', 
        '${jsonObject.checkin} ${timeitself2}',
        '${jsonObject.checkout}', 
         '${jsonObject["No. of Adult"]}', 
         '${jsonObject["No. of Kid"]}', 
         '${jsonObject["No. of Seniors"]}', 
         '0', 
         '${jsonObject.trange}', 
         '${jsonObject.package}', 
         '${jsonObject.TOTAL}', 
         '${jsonObject.DPAYMENT}',
         '${jsonObject.USERINFO.userID}');`

         let selectreservation = `SELECT ReservationID FROM reservations WHERE CheckInDate = '${jsonObject.checkin}' AND GuestID = '${dataid}' ORDER BY ReservationID DESC LIMIT 1;`
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
            success:async function(){const filePath = '../Send2.php';
                await sendinggmailnotif(dataid2, paymentdescription,jsonObject.USERINFO.Email,jsonObject.USERINFO.userID)
                
            }
        }); 

    }

    async function sendinggmailnotif (reserveid,paymentdescription,email,ids){
        $.ajax({    
            type: "post",
            url: "../Send2.php",             
            data: "reservationvalue="+ reserveid+"&&pid="+paymentdescription+"&&email="+email+"&&ids="+ids,    
            dataType: 'json',   
            beforeSend:function(){
                // Set the content of the loading container
            },  
            error:function(response){
                // Remove the loading screen
                console.log(response)
                
            },
            success: async function(response) {

                await Swal.fire({
                    text: "Transaction is successful! Thank you for your reservation.",
                    icon: "success"
                });
                location.href = "./specialcon.php?nzlz=bookingDetails";
            }


        });
    }
    </script>
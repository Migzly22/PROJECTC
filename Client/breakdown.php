<?php
    require("../Database.php");
    session_start();
    ob_start();

    $jsonString = $_GET["sqlcode"];
    $datafromclient = json_decode($jsonString, true);

    $uids = $_SESSION["USERID"];

    $usersql = "SELECT userID, FirstName as firstName, LastName as lastName, MiddleName as middleName, CONCAT(Address, ' ', City) as address,  Email AS email, PhoneNumber AS phoneNumber  FROM userscredentials WHERE userID = '$uids';";
    $userquery = mysqli_query($conn,$usersql);
    $userresultdata = mysqli_fetch_assoc($userquery);
    

    $arraynew = array_merge($datafromclient, $userresultdata);

    $expendituresvalues = $arraynew["EXPENDITURES"];
    $cottagearr = array();
    $cottagequanarr = array();
    $roomarr = array();
    $roomquanarr = array();
    $evtnquan = array();
    $cottagecounter = 0;
    $roomcounter = 0;
    $arraynew["evplace"] = "None";

    for ($i=0; $i < count($expendituresvalues); $i++) { 
        switch ($expendituresvalues[$i]["TYpeofR"]) {
            case ' Room ':
                    $roomcounter++;
                    $roomarr[] = $expendituresvalues[$i]["nameitem"];
                    $roomquanarr[] = $expendituresvalues[$i]["total"];
                break;
            case ' Cottage ':
                    $cottagecounter++;
                    $cottagearr[] = $expendituresvalues[$i]["nameitem"];
                    $cottagequanarr[] = $expendituresvalues[$i]["total"];
                break;
            case ' Pavilion ':
                # code...
                    $arraynew["evplace"] =$expendituresvalues[$i]["nameitem"];
                    $evtnquan[] = $expendituresvalues[$i]["total"];
                break;
            default:

                break;
        }
    }
    $arraynew["numromocu"] = $roomcounter;


    $dateTime = new DateTime($arraynew["Checkin"]);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($arraynew["Checkin"]));

    if($dayOfWeekName >= 4){
        $columnstring = "Weekdays".$arraynew["TND"];
    }else{
        $columnstring = "WeekendsHolidays".$arraynew["TND"];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliJosh Resort & Event</title>


    <link rel="stylesheet" href="./CSS/Table.css">
    <link rel="stylesheet" href="./CSS/Admin12.css">
    
    <link rel="stylesheet" href="./CSS/styleformsettingclient.css">

    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">

    <script src="./JS/script1.js" defer></script>
    <script src="./Calendar/app.js" defer></script>

        <!--SweetAlert-->
        <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <!--Jquery-->
        <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
        <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>




        <script src="https://www.paypal.com/sdk/js?client-id=ASOqstSFrYa4HOtKpsdNhQV8_RvIiHFc0447LO_Vm-QMLhHObWY8dclfI84oymETpgdVBgWo4zgdLc3V"></script>
        <link rel="stylesheet" href="./CSS/BREAKDOWN.CSS">
</head>
<body>
    <nav class="Mainnavigation glassylink">
        <ul class="smoothmenu">
            <li class="creator">
                <a href="./index.php#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="./booking.php#COTTAGES" class="textkainit">COTTAGES</a>
            </li>
            <li>
                <a href="./booking.php#ROOMS" class="textkainit">ROOMS</a>
            </li>
            <li>
                <a href="./booking.php#EVENTPLACE" class="textkainit">EVENTPLACE</a>
            </li>
            <li>
                <a href="./booking.php#EXPENDITURES" class="textkainit">EXPENDITURES</a>
            </li>
        </ul>
        <div class="USERVALUE USERVALUE2 dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <ul class="dropdown-menu">
                <li><a href="./InsideMain.php">Account Settings</a></li>
                <li><a href="./bookinginformations.php">Booking Information</a></li>
                <li><a href="./logOut.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main>
<?php
    $ids = $_SESSION["USERID"];
    $sqlcode = "SELECT userID, FirstName, MiddleName,LastName, PhoneNumber, Address, City, Email FROM userscredentials WHERE userID = '$ids';";
    $USERDATA = mysqli_query($conn,$sqlcode);   
    $result = mysqli_fetch_assoc($USERDATA);

?>
        <section class="mainbody" style="padding: 1em 3em;">

            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Payments</h1>
                </div>
                <div class="stafflistbox">
                    <div class="box">
                        <div class="box2">
                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2><?php echo $arraynew["lastName"].", ".$arraynew["firstName"]?> Payment</h2>
                                
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
                                    $sql2 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Adult';";
                                    $sql2query = mysqli_query($conn,$sql2);
                                    $adultresult = mysqli_fetch_assoc($sql2query);


                                    $sql22 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Kids';";
                                    $sql22query = mysqli_query($conn,$sql22);
                                    $kidsresult = mysqli_fetch_assoc($sql22query);

                                    $sum = 0;
                                    $sum += $arraynew["noAdult"] * $adultresult[$columnstring];
                                    $sum += $arraynew["noKid"] * $kidsresult[$columnstring];
                                    $sum += $arraynew["noSenior"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));

                                    $arraynew["No. of Adult"] = $arraynew["noAdult"];
                                    $arraynew["No. of Kid"] = $arraynew["noKid"];
                                    $arraynew["No. of Seniors"] = $arraynew["noSenior"];

                                ?>
                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noAdult"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo number_format($arraynew["noAdult"] * $adultresult[$columnstring], 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noKid"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo number_format($arraynew["noKid"] * $kidsresult[$columnstring], 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noSenior"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo number_format($arraynew["noSenior"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2))), 2);?></td>
                                </tr>


<?php
 if($cottagecounter > 0 ){
                                for ($i=0; $i < $cottagecounter ; $i++) { 
                                    $sql1 = "SELECT * FROM cottagetypes WHERE ServiceTypeName = '".$cottagearr[$i]."';";
                                    $sqlquery1 = mysqli_query($conn,$sql1);
                                    while($result = mysqli_fetch_assoc($sqlquery1)){
                                        if($arraynew["TND"] == "DayPrice"){
                                            $number = $result["DayPrice"];
                                        }else{
                                            $number = $result["NightPrice"];
                                        }
                                        $number = $number*$cottagequanarr[$i];
                                        $sum += $number;
                                        echo "<tr>
                                            <th style='text-align:start;'>".$cottagearr[$i]."</th>
                                            <td style='text-align:center;'>".$cottagequanarr[$i]."</td>
                                            <td style='text-align:end;'>₱ ".number_format($number, 2)."</td>
                                        </tr>";
                                    }
                                    $arraynew["Cottage"] = $cottagearr[$i];
                                }
                            }else{
                                $arraynew["Cottage"] = "";
                            }

    if($arraynew["numromocu"] > 0 ){
        $roomnumberlist = array();
        for ($i=0; $i < $arraynew["numromocu"] ; $i++) { 
            $autopicroom = "SELECT a.*
            FROM rooms a
            LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num
            LEFT JOIN reservations c ON b.greservationID = c.ReservationID
            WHERE (c.CheckInDate IS NULL OR c.CheckInDate >= '".$arraynew['Checkin']."' AND c.CheckOutDate <= '".$arraynew['Checkout']."')AND a.RoomType = '".$roomarr[$i]."';";
            $autochoose = mysqli_query($conn,$autopicroom);

            $countertoreturn = 1;
            while($result = mysqli_fetch_assoc($autochoose)){
                $roomnumberlist[] = $result["RoomNum"];

                if($countertoreturn == $roomquanarr[$i]){
                    break;
                }
            }
            # code...
        }
        //$roomnumberlist = explode("@", $arraynew["roomnumbers"]);
        $roomname = array();
        $roomnum = array();
        for ($i=0; $i < count($roomnumberlist) ; $i++) { 
            # code...
            $sqlloop = "SELECT a.*, b.* FROM rooms a LEFT JOIN roomtypes b ON a.RoomType = b.RoomType  WHERE a.RoomNum = '".$roomnumberlist[$i]."';";
            $sqlqueryloop = mysqli_query($conn,$sqlloop);
            $resultloop = mysqli_fetch_assoc($sqlqueryloop);

            if($arraynew["TND"] == "DayPrice"){
                $number = $resultloop["DayTimePrice"];
            }else if ($arraynew["TND"] == "NightPrice"){
                $number = $resultloop["NightTimePrice"];
            }else{
                $number = $resultloop["Hours22"];
            }
            $roomname[] = $resultloop["RoomType"];
            $roomnum[] = $resultloop["RoomNum"];
            $sum += $number;
            echo "<tr>
                <th style='text-align:start;'>ROOM-".$resultloop["RoomNum"]." ".$resultloop["RoomType"]."</th>
                <td style='text-align:center;'>1</td>
                <td style='text-align:end;'>₱ ".number_format($number, 2)."</td>
            </tr>";

        }

        
        $arraynew['roomnumbers'] = join("@", $roomname);
        $arraynew['ROOM'] = join(",", $roomname);

    }else{
        $arraynew['roomnumbers'] = "";
        $arraynew['ROOM'] = "";

    }



                        if($arraynew["evplace"] != "None" ){
                                $pax = $arraynew["noAdult"] + $arraynew["noKid"] + $arraynew["noSenior"];
                                # code...
                                $sqlloop2 = "SELECT `".$arraynew["evplace"]."` FROM eventplace WHERE PAX >= $pax ORDER BY PAX ASC LIMIT 1";

                                $sqlqueryloop = mysqli_query($conn,$sqlloop2);
                                $resultloop2 = mysqli_fetch_assoc($sqlqueryloop);
                                
                                $number = $resultloop2[$arraynew["evplace"]] *$evtnquan[0] ;
                                $sum += $number;
                                echo "<tr>
                                    <th style='text-align:start;'>".$arraynew["evplace"]."</th>
                                    <td style='text-align:center;'>1</td>
                                    <td style='text-align:end;'>₱ ".number_format($number, 2)."</td>
                                </tr>";

                        }

    $arraynew['TOTAL'] = $sum;
    $arraynew['DPAYMENT'] = $sum*.5;
    $_SESSION["Newcustomerappointment"] = json_encode($arraynew, JSON_PRETTY_PRINT);
?>
    <textarea name="" id="savevalues" cols="30" rows="10" style="display:none;"><?php echo $_SESSION["Newcustomerappointment"];?></textarea>
                                <tr>
                                    <th style='text-align:start;' colspan="2">TOTAL</th>
                                    <td style='text-align:end;' id="TPrice">₱ <?php echo  number_format($sum, 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;' colspan="2">DOWNPAYMENT</th>
                                    <td style='text-align:end;' id="Dpayment">₱ <?php echo  number_format($sum*.5, 2);?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div style="text-align: center;" class="hehezzz">
                        <div id="paypal-button-container" ></div>
                    </div>
                </div>
     
            </div>
       

        </section>

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

        paypal.Buttons({

            createOrder: async function(data, actions){
                let USD_PHP = await dataGathering()

                let downpaymenttext = document.getElementById("Dpayment").innerText
                let downpayment = parseFloat(downpaymenttext.replace(/₱|,/g, ''));
                result = downpayment / USD_PHP;
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
                    console.log(details.id)
                    
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
        let downpaymenttext = document.getElementById("Dpayment").innerText
        let downpayment = parseFloat(downpaymenttext.replace(/₱|,/g, ''));

        let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES (':ID:', CURRENT_DATE , '${downpayment}', 'ONLINE','${ids}');`;
        Inputtime(sqlcodepayment,ids)

    }

    async function Inputtime(sqlcodepayment,paymentdescription){
   
        const savevalues = document.getElementById("savevalues").value;
        var jsonObject = JSON.parse(savevalues);

        let insertguest = `INSERT INTO guests (GuestID, FirstName, MiddleName, LastName, Email, Phone, Address) VALUES 
        (NULL, '${jsonObject["firstName"]}', '${jsonObject["middleName"]}' , '${jsonObject["lastName"]}', '${jsonObject["email"]}', '${jsonObject["phoneNumber"]}', '${jsonObject["address"]}')`

        let selectguest = `SELECT GuestID FROM guests WHERE FirstName = '${jsonObject["firstName"]}' AND LastName = '${jsonObject["lastName"]}' AND Email = '${jsonObject["email"]}' ORDER BY GuestID DESC LIMIT 1;`
        const dataid =await AjaxSendv3(insertguest,"BREAKDOWNLOGIC",`&Process=UpdateGuest&sqlcode2=${selectguest}`)


        var dateTimeString = jsonObject["Checkin"];
        var dateOnly = dateTimeString.split('T')[0];

        var datetime2 = jsonObject["Checkout"]; // Parse the string into a Date object
        // Create a new Date object with the same year, month, and day, but set the time to midnight (00:00:00)
        var dateOnly2 = datetime2.split('T')[0];

        let TPrice = document.getElementById("TPrice").innerText.replace(/₱/g, '')
        TPrice = TPrice.replace(/,/g, '')
        let Dpayment = document.getElementById("Dpayment").innerText.replace(/₱/g, '')
        Dpayment = Dpayment.replace(/,/g, '')
        let roomnumbers = jsonObject["roomnumbers"].replace(/@/g, ',')

        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate, CheckOutDate, RoomNumber, CottageTypeID, NumAdults, NumChildren, NumSeniors, NumExcessPax, timapackage, Eventplace, TotalPrice, Downpayment, UserID) 
        VALUES (NULL, '${dataid}', '${dateOnly}', '${dateOnly2}', '${roomnumbers}', '${jsonObject["Cottage"]}', '${jsonObject["No. of Adult"]}', '${jsonObject["No. of Kid"]}', '${jsonObject["No. of Seniors"]}', '0', '${jsonObject["timapackage"]}', '${jsonObject["evplace"]}', '${TPrice}', '${Dpayment}','${jsonObject["userID"]}');`

        let selectreservation = `SELECT ReservationID FROM reservations WHERE CheckInDate = '${dateOnly}' AND GuestID = '${dataid}' ORDER BY ReservationID DESC LIMIT 1;`

        const dataid2 =await AjaxSendv3(insertreservation,"BREAKDOWNLOGIC",`&Process=UpdateReservation&sqlcode2=${selectreservation}`)


        let roomnumbersarray = jsonObject["roomnumbers"].split("@")

        for (let index = 0; index < roomnumbersarray.length; index++) {
            let insertrooms = `INSERT INTO roomsreservation (greservationID, Room_num) VALUES ('${dataid2}', '${roomnumbersarray[index]}');`
            await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
        }

        let paymentdone = sqlcodepayment.replace(':ID:', `${dataid2}`)

        await AjaxSendv3(paymentdone,"BREAKDOWNLOGIC",`&Process=Insertmore`)

        $.ajax({
            url:`../Admins/Composer/docxphp.php`,
            type:"GET",
            beforeSend:function(){
                location.href = "../Admins/Composer/docxphp.php";
            },
            error: function(e) 
            {
                console.log("errro")
            },
            success:async function(){
                await sendinggmailnotif(dataid2, paymentdescription,jsonObject["email"],jsonObject["userID"])
                //location.href = "../Admins/Composer/docxphp.php";dataid2, paymentdescription
                
                //location.href = "./bookinginformations.php";
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
                    text: "Transaction successful! Thank you for your reservation.",
                    icon: "success"
                });
                location.href = "./bookinginformations.php";
            }


        });
    }
    </script>
</body>
</html>